"use client";

import React from "react";
import { motion, useAnimationControls } from "motion/react";

export interface NewsItem {
  title: string;
  content: string;
  image_url: string | null;
  created_at: string;
  action_text: string | null;
  action_url: string | null;
}

export const NewsColumn = (props: {
  className?: string;
  news: NewsItem[];
  duration?: number;
}) => {
  const controls = useAnimationControls();

  const handleMouseEnter = () => {
    controls.stop();
  };

  const handleMouseLeave = () => {
    controls.start({
      translateY: "-50%",
      transition: {
        duration: props.duration || 10,
        repeat: Infinity,
        ease: "linear",
        repeatType: "loop",
      },
    });
  };

  return (
    <div
      className={`w-full shrink-0 ${props.className || ""}`}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
    >
      <motion.div
        animate={controls}
        initial={{ translateY: "0%" }}
        className="flex flex-col gap-6 pb-6"
      >
        {[
          ...new Array(2)
            .fill(0)
            .map((_, index) => (
              <React.Fragment key={index}>
                {props.news.map(
                  (
                    { title, content, created_at, action_text, action_url },
                    i,
                  ) => (
                    <div
                      className="p-8 rounded-3xl border border-gray-100 shadow-lg shadow-mzl-blue/5 w-full bg-white"
                      key={`${index}-${i}`}
                    >
                      <div className="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                        <span className="w-1.5 h-1.5 rounded-full bg-mzl-orange" />
                        {new Date(created_at).toLocaleDateString("es-CO", {
                          day: "numeric",
                          month: "long",
                          year: "numeric",
                        })}
                      </div>
                      <h3 className="font-black text-xl text-gray-900 leading-snug mb-3">
                        {title}
                      </h3>
                      <p className="text-gray-500 text-sm leading-relaxed line-clamp-4">
                        {content}
                      </p>
                      {action_url && action_text && (
                        <a
                          href={action_url}
                          className="inline-flex items-center justify-center gap-2 mt-5 px-5 py-2 bg-gray-50 hover:bg-mzl-blue text-mzl-blue hover:text-white rounded-xl font-bold text-sm transition-colors border border-gray-100 hover:border-mzl-blue group/btn"
                        >
                          {action_text}
                          <svg
                            className="w-4 h-4 transition-transform group-hover/btn:translate-x-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            <path
                              strokeLinecap="round"
                              strokeLinejoin="round"
                              strokeWidth={2}
                              d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                          </svg>
                        </a>
                      )}
                    </div>
                  ),
                )}
              </React.Fragment>
            )),
        ]}
      </motion.div>
    </div>
  );
};
