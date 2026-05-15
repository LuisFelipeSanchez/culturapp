import React from "react";
import { createRoot } from "react-dom/client";
import { motion, AnimatePresence } from "motion/react";
import {
    Palette,
    Music,
    Theater,
    BookOpen,
    Camera,
    Scissors,
    UtensilsCrossed,
    Laptop,
    Landmark,
    Trophy,
    GraduationCap,
    ChevronLeft,
    ChevronRight,
} from "lucide-react";
import { ExpandingCards, type CardItem } from "@/components/ui/expanding-cards";

interface CourseData {
    id: number;
    title: string;
    description: string;
    image: string | null;
    category_name: string;
    category_icon: string;
    status: string;
}

const PAGE_SIZE = 6;

const categoryIconMap: Record<string, React.ReactNode> = {
    "artes plásticas": <Palette size={24} />,
    música: <Music size={24} />,
    "danza y teatro": <Theater size={24} />,
    literatura: <BookOpen size={24} />,
    "fotografía y video": <Camera size={24} />,
    artesanía: <Scissors size={24} />,
    "gastronomía cultural": <UtensilsCrossed size={24} />,
    "tecnología e innovación": <Laptop size={24} />,
    "patrimonio cultural": <Landmark size={24} />,
    "circo y acrobacia": <Trophy size={24} />,
};

const categoryFallbackImages: Record<string, string> = {
    "artes plásticas":
        "https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8a?auto=format&fit=crop&w=800&q=80",
    música: "https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80",
    "danza y teatro":
        "https://images.unsplash.com/photo-1508700929629-7e8b67e536f5?auto=format&fit=crop&w=800&q=80",
    literatura: "https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=800&q=80",
    "fotografía y video":
        "https://images.unsplash.com/photo-1452587925148-ce544e77e70d?auto=format&fit=crop&w=800&q=80",
    artesanía: "https://images.unsplash.com/photo-1565193566173-7d017cda8584?auto=format&fit=crop&w=800&q=80",
    "gastronomía cultural":
        "https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=800&q=80",
    "tecnología e innovación":
        "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80",
    "patrimonio cultural":
        "https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=80",
    "circo y acrobacia":
        "https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?auto=format&fit=crop&w=800&q=80",
};

const defaultFallbackImage =
    "https://images.unsplash.com/photo-1523050854058-8df90110c476?auto=format&fit=crop&w=800&q=80";

function getIcon(categoryName: string): React.ReactNode {
    const key = categoryName.toLowerCase();
    return categoryIconMap[key] || <GraduationCap size={24} />;
}

function getFallbackImage(categoryName: string): string {
    const key = categoryName.toLowerCase();
    return categoryFallbackImages[key] || defaultFallbackImage;
}

function buildRoute(courseId: number): string {
    const base = document
        .getElementById("courses-expanding-root")
        ?.getAttribute("data-base-url");
    return base ? `${base}/${courseId}` : `/cursos/${courseId}`;
}

function toCardItems(courses: CourseData[]): CardItem[] {
    return courses.map((course) => ({
        id: course.id,
        title: course.title,
        description: course.description,
        imgSrc: course.image || getFallbackImage(course.category_name),
        icon: getIcon(course.category_name),
        linkHref: buildRoute(course.id),
    }));
}

const CourseSection = ({ courses }: { courses: CourseData[] }) => {
    const [page, setPage] = React.useState(0);

    if (courses.length === 0) {
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
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                </svg>
                <p className="font-bold text-lg text-gray-500 mb-1">
                    Sin cursos todavía
                </p>
                <p className="text-sm">
                    Actualmente no hay inscripciones abiertas para esta sede.
                </p>
            </div>
        );
    }

    const totalPages = Math.ceil(courses.length / PAGE_SIZE);
    const pageItems = courses.slice(page * PAGE_SIZE, (page + 1) * PAGE_SIZE);
    const cardItems = toCardItems(pageItems);

    const goTo = (newPage: number) => {
        if (newPage >= 0 && newPage < totalPages) setPage(newPage);
    };

    return (
        <section className="my-10 relative">
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
                    <div className="border py-1 px-4 rounded-lg text-mzl-teal border-mzl-teal/30 bg-mzl-teal/5 font-bold text-xs uppercase tracking-wider">
                        Oferta Formativa
                    </div>
                </div>
                <h2 className="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-black tracking-tighter mt-5 text-gray-900 text-center">
                    Cursos Disponibles
                </h2>
                <p className="text-center mt-5 opacity-75 text-gray-500">
                    Explora nuestra oferta cultural. Haz clic en un curso para
                    conocer más detalles e inscribirte.
                </p>
            </motion.div>

            <div className="flex justify-center">
                <AnimatePresence mode="wait">
                    <motion.div
                        key={page}
                        initial={{ opacity: 0, x: 40 }}
                        animate={{ opacity: 1, x: 0 }}
                        exit={{ opacity: 0, x: -40 }}
                        transition={{ duration: 0.35, ease: "easeInOut" }}
                    >
                        <ExpandingCards
                            items={cardItems}
                            defaultActiveIndex={0}
                        />
                    </motion.div>
                </AnimatePresence>
            </div>

            {totalPages > 1 && (
                <div className="flex items-center justify-center gap-4 mt-8">
                    <button
                        onClick={() => goTo(page - 1)}
                        disabled={page === 0}
                        className="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold transition-colors disabled:opacity-30 disabled:cursor-not-allowed bg-white border border-gray-200 text-gray-600 hover:bg-mzl-blue hover:text-white hover:border-mzl-blue"
                    >
                        <ChevronLeft size={18} />
                        Anterior
                    </button>

                    <div className="flex gap-2">
                        {Array.from({ length: totalPages }, (_, i) => (
                            <button
                                key={i}
                                onClick={() => goTo(i)}
                                className={`w-8 h-8 rounded-full text-xs font-bold transition-colors ${
                                    i === page
                                        ? "bg-mzl-blue text-white"
                                        : "bg-white border border-gray-200 text-gray-400 hover:bg-mzl-teal hover:text-white hover:border-mzl-teal"
                                }`}
                            >
                                {i + 1}
                            </button>
                        ))}
                    </div>

                    <button
                        onClick={() => goTo(page + 1)}
                        disabled={page === totalPages - 1}
                        className="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold transition-colors disabled:opacity-30 disabled:cursor-not-allowed bg-white border border-gray-200 text-gray-600 hover:bg-mzl-blue hover:text-white hover:border-mzl-blue"
                    >
                        Siguiente
                        <ChevronRight size={18} />
                    </button>
                </div>
            )}
        </section>
    );
};

const el = document.getElementById("courses-expanding-root");
if (el) {
    const raw = el.getAttribute("data-courses") || "[]";
    const courses: CourseData[] = JSON.parse(raw);
    const root = createRoot(el);
    root.render(
        <React.StrictMode>
            <CourseSection courses={courses} />
        </React.StrictMode>,
    );
}
