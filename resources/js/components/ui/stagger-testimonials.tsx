"use client";

import React, { useState, useEffect } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { cn } from "@/lib/utils";

const SQRT_5000 = Math.sqrt(5000);

export interface StaggerNewsItem {
  id: string | number;
  title: string;
  content: string;
  image_url: string | null;
  sede_name: string | null;
  date: string;
  action_text: string | null;
  action_url: string | null;
}

interface NewsCardProps {
  position: number;
  item: StaggerNewsItem;
  handleMove: (steps: number) => void;
  cardSize: number;
}

const NewsCard: React.FC<NewsCardProps> = ({
  position,
  item,
  handleMove,
  cardSize,
}) => {
  const isCenter = position === 0;
  const fallbackImage =
    "https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=800&q=80";
  const imgSrc = item.image_url || fallbackImage;

  return (
    <div
      onClick={() => handleMove(position)}
      className={cn(
        "absolute left-1/2 top-1/2 cursor-pointer border-2 transition-all duration-500 ease-in-out overflow-hidden",
        isCenter
          ? "z-10 bg-mzl-blue text-white border-mzl-blue"
          : "z-0 bg-white text-gray-900 border-gray-200 hover:border-mzl-blue/50",
      )}
      style={{
        width: cardSize,
        height: cardSize,
        clipPath: `polygon(50px 0%, calc(100% - 50px) 0%, 100% 50px, 100% 100%, calc(100% - 50px) 100%, 50px 100%, 0 100%, 0 0)`,
        transform: `
          translate(-50%, -50%)
          translateX(${(cardSize / 1.5) * position}px)
          translateY(${isCenter ? -65 : position % 2 ? 15 : -15}px)
          rotate(${isCenter ? 0 : position % 2 ? 2.5 : -2.5}deg)
        `,
        boxShadow: isCenter
          ? "0px 8px 0px 4px #3650BB40"
          : "0px 0px 0px 0px transparent",
      }}
    >
      {/* Decorative corner notch */}
      <span
        className="absolute block origin-top-right rotate-45"
        style={{
          right: -2,
          top: 48,
          width: SQRT_5000,
          height: 2,
          backgroundColor: isCenter ? "rgba(255,255,255,0.3)" : "#e5e7eb",
        }}
      />

      {/* Image area */}
      <div className="relative w-full h-[45%] overflow-hidden">
        <img
          src={imgSrc}
          alt={item.title}
          className="w-full h-full object-cover"
          style={{
            boxShadow: `3px 3px 0px ${isCenter ? "rgba(255,255,255,0.2)" : "#f9fafb"}`,
          }}
        />
        <div
          className={cn(
            "absolute inset-0",
            isCenter
              ? "bg-gradient-to-t from-mzl-blue/40 to-transparent"
              : "bg-gradient-to-t from-black/10 to-transparent",
          )}
        />
      </div>

      {/* Text content */}
      <div className="px-7 pt-4 pb-2 flex flex-col" style={{ height: "55%" }}>
        {/* Date + sede badge */}
        <div
          className={cn(
            "flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider mb-2",
            isCenter ? "text-white/70" : "text-gray-400",
          )}
        >
          <span
            className={cn(
              "w-1.5 h-1.5 rounded-full",
              isCenter ? "bg-mzl-yellow" : "bg-mzl-orange",
            )}
          />
          {item.date}
          {item.sede_name && (
            <>
              <span>·</span>
              <span className="truncate">{item.sede_name}</span>
            </>
          )}
        </div>

        {/* Title */}
        <h3
          className={cn(
            "text-sm sm:text-base font-black leading-snug line-clamp-3",
            isCenter ? "text-white" : "text-gray-900",
          )}
        >
          {item.title}
        </h3>

        {/* Content excerpt */}
        <p
          className={cn(
            "mt-2 text-xs leading-relaxed line-clamp-2",
            isCenter ? "text-white/70" : "text-gray-500",
          )}
        >
          {item.content}
        </p>

        {/* Action link */}
        {item.action_text && item.action_url && isCenter && (
          <a
            href={item.action_url}
            onClick={(e) => e.stopPropagation()}
            className="mt-auto inline-flex items-center gap-1.5 text-[11px] font-bold text-mzl-yellow hover:text-white transition-colors"
          >
            {item.action_text}
            <svg
              className="w-3 h-3 transition-transform hover:translate-x-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2.5}
                d="M14 5l7 7m0 0l-7 7m7-7H3"
              />
            </svg>
          </a>
        )}
      </div>
    </div>
  );
};

interface StaggerTestimonialsProps {
  items: StaggerNewsItem[];
}

export const StaggerTestimonials: React.FC<StaggerTestimonialsProps> = ({
  items,
}) => {
  const [cardSize, setCardSize] = useState(365);
  const [list, setList] = useState(items);

  const handleMove = (steps: number) => {
    const newList = [...list];
    if (steps > 0) {
      for (let i = steps; i > 0; i--) {
        const item = newList.shift();
        if (!item) return;
        newList.push({ ...item, _tempId: Math.random() });
      }
    } else {
      for (let i = steps; i < 0; i++) {
        const item = newList.pop();
        if (!item) return;
        newList.unshift({ ...item, _tempId: Math.random() });
      }
    }
    setList(newList);
  };

  useEffect(() => {
    const updateSize = () => {
      const { matches } = window.matchMedia("(min-width: 640px)");
      setCardSize(matches ? 365 : 290);
    };
    updateSize();
    window.addEventListener("resize", updateSize);
    return () => window.removeEventListener("resize", updateSize);
  }, []);

  if (items.length === 0) return null;

  return (
    <div
      className="relative w-full overflow-hidden bg-gray-50/50"
      style={{ height: 600 }}
    >
      {list.map((item, index) => {
        const position =
          list.length % 2
            ? index - (list.length + 1) / 2
            : index - list.length / 2;
        return (
          <NewsCard
            key={(item as any)._tempId ?? item.id}
            item={item}
            handleMove={handleMove}
            position={position}
            cardSize={cardSize}
          />
        );
      })}

      {/* Navigation buttons */}
      <div className="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
        <button
          onClick={() => handleMove(-1)}
          className={cn(
            "flex h-14 w-14 items-center justify-center text-2xl transition-colors",
            "bg-white border-2 border-gray-200 hover:bg-mzl-blue hover:text-white hover:border-mzl-blue",
            "rounded-xl shadow-sm",
            "focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-mzl-blue focus-visible:ring-offset-2",
          )}
          aria-label="Noticia anterior"
        >
          <ChevronLeft />
        </button>
        <button
          onClick={() => handleMove(1)}
          className={cn(
            "flex h-14 w-14 items-center justify-center text-2xl transition-colors",
            "bg-white border-2 border-gray-200 hover:bg-mzl-blue hover:text-white hover:border-mzl-blue",
            "rounded-xl shadow-sm",
            "focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-mzl-blue focus-visible:ring-offset-2",
          )}
          aria-label="Noticia siguiente"
        >
          <ChevronRight />
        </button>
      </div>
    </div>
  );
};

export default StaggerTestimonials;
