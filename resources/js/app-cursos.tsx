import React from "react";
import { createRoot } from "react-dom/client";
import { motion } from "motion/react";
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
} from "lucide-react";
import {
  FeatureCarousel,
  type FeatureItem,
} from "@/components/ui/feature-carousel";

interface CourseData {
  id: number;
  title: string;
  description: string;
  schedule: string;
  hours: number;
  capacity: number;
  image: string | null;
  category_name: string;
  category_icon: string;
  status: string;
}

// Map category → lucide-react icon component
const categoryIconMap: Record<string, React.ComponentType<{ size?: number; strokeWidth?: number }>> = {
  "artes plásticas": Palette,
  música: Music,
  "danza y teatro": Theater,
  literatura: BookOpen,
  "fotografía y video": Camera,
  artesanía: Scissors,
  "gastronomía cultural": UtensilsCrossed,
  "tecnología e innovación": Laptop,
  "patrimonio cultural": Landmark,
  "circo y acrobacia": Trophy,
};

// Map category → fallback Unsplash image
const categoryFallbackImages: Record<string, string> = {
    "artes plásticas":
        "https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&w=800&q=80",
  música:
    "https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80",
    "danza y teatro":
        "https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80",
  literatura:
    "https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=800&q=80",
  "fotografía y video":
    "https://images.unsplash.com/photo-1452587925148-ce544e77e70d?auto=format&fit=crop&w=800&q=80",
    artesanía:
        "https://images.unsplash.com/photo-1582562124811-c09040d0a901?auto=format&fit=crop&w=800&q=80",
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
    "https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=800&q=80";

function getIcon(categoryName: string) {
  const key = categoryName.toLowerCase();
  return categoryIconMap[key] || GraduationCap;
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

function toFeatureItems(courses: CourseData[]): FeatureItem[] {
  return courses.map((course) => ({
    id: course.id,
    label: course.category_name,
    icon: getIcon(course.category_name),
    image: course.image || getFallbackImage(course.category_name),
    description: course.title,
    meta: `${course.schedule} · ${course.hours}h · ${course.capacity} cupos`,
    linkHref: buildRoute(course.id),
  }));
}

const CourseSection = ({ courses }: { courses: CourseData[] }) => {
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

  const featureItems = toFeatureItems(courses);

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

      <FeatureCarousel
        features={featureItems}
        accentColor="#3650BB"
      />
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
