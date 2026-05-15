import React from "react";
import { createRoot } from "react-dom/client";
import { motion } from "motion/react";
import { NewsColumn, type NewsItem } from "@/components/ui/news-columns";

const NewsSection = ({ news }: { news: NewsItem[] }) => {
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
                    Cero noticias por ahora
                </p>
                <p className="text-sm">
                    Vuelve pronto para enterarte de lo que pasa en esta sede.
                </p>
            </div>
        );
    }

    const firstColumn = news.slice(0, Math.ceil(news.length / 3));
    const secondColumn = news.slice(
        Math.ceil(news.length / 3),
        Math.ceil((2 * news.length) / 3),
    );
    const thirdColumn = news.slice(Math.ceil((2 * news.length) / 3));

    return (
        <section className="my-10 relative">
            <div className="w-full z-10 mx-auto">
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
                            Noticias y Actualidad
                        </div>
                    </div>
                    <h2 className="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-black tracking-tighter mt-5 text-gray-900 text-center">
                        Novedades de la Sede
                    </h2>
                    <p className="text-center mt-5 opacity-75 text-gray-500">
                        Entérate de las novedades, eventos y convocatorias de
                        esta casa de la cultura.
                    </p>
                </motion.div>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 [mask-image:linear-gradient(to_bottom,transparent,black_25%,black_75%,transparent)] max-h-[740px] overflow-hidden">
                    <NewsColumn news={firstColumn} duration={15} />
                    <NewsColumn
                        news={secondColumn}
                        className="hidden md:block"
                        duration={19}
                    />
                    <NewsColumn
                        news={thirdColumn}
                        className="hidden lg:block"
                        duration={17}
                    />
                </div>
            </div>
        </section>
    );
};

const el = document.getElementById("news-columns-root");
if (el) {
    const raw = el.getAttribute("data-news") || "[]";
    const news: NewsItem[] = JSON.parse(raw);
    const root = createRoot(el);
    root.render(
        <React.StrictMode>
            <NewsSection news={news} />
        </React.StrictMode>,
    );
}
