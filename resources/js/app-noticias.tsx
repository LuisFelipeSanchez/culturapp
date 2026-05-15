import React from "react";
import { createRoot } from "react-dom/client";
import { motion } from "motion/react";
import {
  StaggerTestimonials,
  type StaggerNewsItem,
} from "@/components/ui/stagger-testimonials";

interface NewsData {
  id: number;
  title: string;
  content: string;
  image_url: string | null;
  sede_name: string | null;
  date: string;
  action_text: string | null;
  action_url: string | null;
}

const NewsSection = ({ news }: { news: NewsData[] }) => {
  if (news.length === 0) {
    return (
      <div className="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
        <svg
          className="w-16 h-16 mx-auto mb-4 text-gray-300"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth={1.5}
            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"
          />
        </svg>
        <p className="font-bold text-lg text-gray-500 mb-1">
          Cero anuncios por ahora
        </p>
        <p className="text-sm">
          Vuelve pronto para enterarte de lo que pasa a nivel ciudad.
        </p>
      </div>
    );
  }

  const items: StaggerNewsItem[] = news.map((n) => ({
    id: n.id,
    title: n.title,
    content:
      n.content.length > 120 ? n.content.slice(0, 120) + "…" : n.content,
    image_url: n.image_url,
    sede_name: n.sede_name,
    date: n.date,
    action_text: n.action_text,
    action_url: n.action_url,
  }));

  return (
    <section className="relative">
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{
          duration: 0.8,
          delay: 0.1,
          ease: [0.16, 1, 0.3, 1],
        }}
        viewport={{ once: true }}
        className="flex flex-col items-center justify-center max-w-[540px] mx-auto mb-10"
      >
        <div className="flex justify-center">
          <div className="border py-1 px-4 rounded-lg text-mzl-orange border-mzl-orange/30 bg-mzl-orange/5 font-bold text-xs uppercase tracking-wider">
            Actualidad Cultural
          </div>
        </div>
        <h2 className="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-black tracking-tighter mt-5 text-gray-900 text-center">
          Noticias y Eventos
        </h2>
        <p className="text-center mt-5 opacity-75 text-gray-500">
          Navega por las noticias culturales de Manizales. Haz clic en las
          flechas para explorar más.
        </p>
      </motion.div>

      <StaggerTestimonials items={items} />
    </section>
  );
};

const el = document.getElementById("stagger-news-root");
if (el) {
  const raw = el.getAttribute("data-news") || "[]";
  const news: NewsData[] = JSON.parse(raw);
  const root = createRoot(el);
  root.render(
    <React.StrictMode>
      <NewsSection news={news} />
    </React.StrictMode>,
  );
}
