"use client";

import React, { useState, useEffect, useCallback } from "react";
import { motion, AnimatePresence } from "motion/react";
import { cn } from "@/lib/utils";

export interface FeatureItem {
  id: string | number;
  label: string;
  icon: React.ComponentType<{ size?: number; strokeWidth?: number }>;
  image: string;
  description: string;
  meta?: string;
  linkHref?: string;
}

interface FeatureCarouselProps {
  features: FeatureItem[];
  autoPlayInterval?: number;
  accentColor?: string;
}

const DEFAULT_AUTO_PLAY = 4000;
const ITEM_HEIGHT = 65;

const wrap = (min: number, max: number, v: number) => {
  const rangeSize = max - min;
  return ((((v - min) % rangeSize) + rangeSize) % rangeSize) + min;
};

export function FeatureCarousel({
  features,
  autoPlayInterval = DEFAULT_AUTO_PLAY,
  accentColor = "#3650BB",
}: FeatureCarouselProps) {
  const [step, setStep] = useState(0);
  const [isPaused, setIsPaused] = useState(false);

  const currentIndex =
    ((step % features.length) + features.length) % features.length;

  const nextStep = useCallback(() => {
    setStep((prev) => prev + 1);
  }, []);

  const handleChipClick = (index: number) => {
    const diff = (index - currentIndex + features.length) % features.length;
    if (diff > 0) setStep((s) => s + diff);
  };

  useEffect(() => {
    if (isPaused) return;
    const interval = setInterval(nextStep, autoPlayInterval);
    return () => clearInterval(interval);
  }, [nextStep, isPaused, autoPlayInterval]);

  const getCardStatus = (index: number) => {
    const diff = index - currentIndex;
    const len = features.length;
    let normalizedDiff = diff;
    if (diff > len / 2) normalizedDiff -= len;
    if (diff < -len / 2) normalizedDiff += len;
    if (normalizedDiff === 0) return "active";
    if (normalizedDiff === -1) return "prev";
    if (normalizedDiff === 1) return "next";
    return "hidden";
  };

  if (features.length === 0) return null;

  return (
    <div className="w-full max-w-7xl mx-auto md:p-8">
      <div className="relative overflow-hidden rounded-[2.5rem] lg:rounded-[4rem] flex flex-col lg:flex-row min-h-[600px] lg:aspect-video border border-border/40">
        {/* Left sidebar — chip list */}
        <div
          className="w-full lg:w-[40%] min-h-[350px] md:min-h-[450px] lg:h-full relative z-30 flex flex-col items-start justify-center overflow-hidden px-8 md:px-16 lg:pl-16"
          style={{ backgroundColor: accentColor }}
        >
          {/* Top fade gradient */}
          <div
            className="absolute inset-x-0 top-0 h-12 md:h-20 lg:h-16 z-40"
            style={{
              background: `linear-gradient(to bottom, ${accentColor}, ${accentColor}cc, transparent)`,
            }}
          />
          {/* Bottom fade gradient */}
          <div
            className="absolute inset-x-0 bottom-0 h-12 md:h-20 lg:h-16 z-40"
            style={{
              background: `linear-gradient(to top, ${accentColor}, ${accentColor}cc, transparent)`,
            }}
          />

          <div className="relative w-full h-full flex items-center justify-center lg:justify-start z-20">
            {features.map((feature, index) => {
              const isActive = index === currentIndex;
              const distance = index - currentIndex;
              const wrappedDistance = wrap(
                -(features.length / 2),
                features.length / 2,
                distance,
              );

              const IconComponent = feature.icon;

              return (
                <motion.div
                  key={feature.id}
                  style={{
                    height: ITEM_HEIGHT,
                    width: "fit-content",
                  }}
                  animate={{
                    y: wrappedDistance * ITEM_HEIGHT,
                    opacity: 1 - Math.abs(wrappedDistance) * 0.25,
                  }}
                  transition={{
                    type: "spring",
                    stiffness: 90,
                    damping: 22,
                    mass: 1,
                  }}
                  className="absolute flex items-center justify-start"
                >
                  <button
                    onClick={() => handleChipClick(index)}
                    onMouseEnter={() => setIsPaused(true)}
                    onMouseLeave={() => setIsPaused(false)}
                    className={cn(
                      "relative flex items-center gap-4 px-6 md:px-10 lg:px-8 py-3.5 md:py-5 lg:py-4 rounded-full transition-all duration-700 text-left group border",
                      isActive
                        ? "bg-white border-white z-10"
                        : "bg-transparent border-white/20 hover:border-white/40",
                    )}
                    style={{
                      color: isActive ? accentColor : "rgba(255,255,255,0.6)",
                    }}
                  >
                    <div
                      className="flex items-center justify-center transition-colors duration-500"
                      style={
                        isActive
                          ? { color: accentColor }
                          : { color: "rgba(255,255,255,0.4)" }
                      }
                    >
                      <IconComponent size={18} strokeWidth={2} />
                    </div>
                    <span className="font-normal text-sm md:text-[15px] tracking-tight whitespace-nowrap uppercase">
                      {feature.label}
                    </span>
                  </button>
                </motion.div>
              );
            })}
          </div>
        </div>

        {/* Right panel — featured image card */}
        <div className="flex-1 min-h-[500px] md:min-h-[600px] lg:h-full relative bg-secondary/30 flex items-center justify-center py-16 md:py-24 lg:py-16 px-6 md:px-12 lg:px-10 overflow-hidden border-t lg:border-t-0 lg:border-l border-border/20">
          <div className="relative w-full max-w-[420px] aspect-[4/5] flex items-center justify-center">
            {features.map((feature, index) => {
              const status = getCardStatus(index);
              const isActive = status === "active";
              const isPrev = status === "prev";
              const isNext = status === "next";

              return (
                <motion.div
                  key={feature.id}
                  initial={false}
                  animate={{
                    x: isActive ? 0 : isPrev ? -100 : isNext ? 100 : 0,
                    scale: isActive ? 1 : isPrev || isNext ? 0.85 : 0.7,
                    opacity: isActive ? 1 : isPrev || isNext ? 0.4 : 0,
                    rotate: isPrev ? -3 : isNext ? 3 : 0,
                    zIndex: isActive ? 20 : isPrev || isNext ? 10 : 0,
                    pointerEvents: isActive ? "auto" : "none",
                  }}
                  transition={{
                    type: "spring",
                    stiffness: 260,
                    damping: 25,
                    mass: 0.8,
                  }}
                  className="absolute inset-0 rounded-[2rem] md:rounded-[2.8rem] overflow-hidden border-4 md:border-8 border-background bg-background origin-center"
                  onClick={() => {
                    if (isActive && feature.linkHref) {
                      window.location.href = feature.linkHref;
                    }
                  }}
                  style={{
                    cursor: isActive && feature.linkHref ? "pointer" : "default",
                  }}
                >
                  <img
                    src={feature.image}
                    alt={feature.label}
                    className={cn(
                      "w-full h-full object-cover transition-all duration-700",
                      isActive
                        ? "grayscale-0 blur-0"
                        : "grayscale blur-[2px] brightness-75",
                    )}
                  />

                  <AnimatePresence>
                    {isActive && (
                      <motion.div
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: 10 }}
                        className="absolute inset-x-0 bottom-0 p-10 pt-32 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end pointer-events-none"
                      >
                        <div className="bg-white text-gray-900 px-4 py-1.5 rounded-full text-[11px] font-normal uppercase tracking-[0.2em] w-fit shadow-lg mb-3 border border-gray-200">
                          {index + 1} &bull; {feature.label}
                        </div>
                        <p className="text-white font-normal text-xl md:text-2xl leading-tight drop-shadow-md tracking-tight">
                          {feature.description}
                        </p>
                        {feature.meta && (
                          <p className="text-white/60 text-sm mt-2 tracking-tight">
                            {feature.meta}
                          </p>
                        )}
                      </motion.div>
                    )}
                  </AnimatePresence>

                  <div
                    className={cn(
                      "absolute top-8 left-8 flex items-center gap-3 transition-opacity duration-300",
                      isActive ? "opacity-100" : "opacity-0",
                    )}
                  >
                    <div
                      className="w-2 h-2 rounded-full bg-white shadow-[0_0_10px_white]"
                    />
                    <span className="text-white/80 text-[10px] font-normal uppercase tracking-[0.3em] font-mono">
                      {feature.meta ? "Inscripción abierta" : "Curso activo"}
                    </span>
                  </div>
                </motion.div>
              );
            })}
          </div>
        </div>
      </div>
    </div>
  );
}

export default FeatureCarousel;
