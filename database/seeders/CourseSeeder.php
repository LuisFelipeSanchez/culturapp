<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Sede;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    private array $templates = [
        [
            'title' => 'Pintura al óleo para principiantes',
            'description' => 'Aprende las técnicas básicas del óleo: mezcla de colores, pinceladas y composición. Incluye todos los materiales.',
            'days' => [1, 3],
            'start_time' => '14:00',
            'end_time' => '16:00',
            'status' => 'open',
            'capacity' => 20,
            'category' => 'Artes Plásticas',
            'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Guitarra acústica nivel inicial',
            'description' => 'Domina los acordes básicos, ritmos de pasillo y bambuco. Trae tu instrumento o usa uno de la sede.',
            'days' => [2, 4],
            'start_time' => '17:00',
            'end_time' => '19:00',
            'status' => 'open',
            'capacity' => 15,
            'category' => 'Música',
            'image' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Danza folclórica colombiana',
            'description' => 'Coreografías de joropo, cumbia y sanjuanero. Abierto a todas las edades, sin experiencia requerida.',
            'days' => [3, 5],
            'start_time' => '10:00',
            'end_time' => '12:00',
            'status' => 'in_progress',
            'capacity' => 25,
            'category' => 'Danza y Teatro',
            'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Taller de escritura creativa',
            'description' => 'Explora el cuento corto, la poesía y la crónica urbana con ejercicios prácticos y lectura grupal.',
            'days' => [6],
            'start_time' => '09:00',
            'end_time' => '12:00',
            'status' => 'open',
            'capacity' => 18,
            'category' => 'Literatura',
            'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Fotografía digital y edición',
            'description' => 'De la captura al postproceso: composición, luz natural y edición con software libre.',
            'days' => [1, 3, 5],
            'start_time' => '18:00',
            'end_time' => '20:00',
            'status' => 'open',
            'capacity' => 12,
            'category' => 'Fotografía y Video',
            'image' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Cerámica y modelado a mano',
            'description' => 'Técnicas de pinzado, placas y rollos para crear piezas funcionales y decorativas.',
            'days' => [2, 4],
            'start_time' => '10:00',
            'end_time' => '12:00',
            'status' => 'open',
            'capacity' => 10,
            'category' => 'Artesanía',
            'image' => 'https://images.unsplash.com/photo-1582562124811-c09040d0a901?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Cocina tradicional caldense',
            'description' => 'Aprende a preparar arepas de mote, chorizo paisa y dulce de guayaba con ingredientes locales.',
            'days' => [6],
            'start_time' => '14:00',
            'end_time' => '17:00',
            'status' => 'open',
            'capacity' => 15,
            'category' => 'Gastronomía Cultural',
            'image' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Introducción a la programación',
            'description' => 'Lógica de programación con Scratch y Python. Ideal para jóvenes y adultos sin experiencia.',
            'days' => [1, 3],
            'start_time' => '18:00',
            'end_time' => '20:00',
            'status' => 'in_progress',
            'capacity' => 20,
            'category' => 'Tecnología e Innovación',
            'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80',
        ],
    ];

    public function run(): void
    {
        $sedes = Sede::all();
        $categories = Category::all()->keyBy('name');

        foreach ($sedes as $sede) {
            foreach ($this->templates as $template) {
                $category = $categories->get($template['category']);

                Course::create([
                    'sede_id' => $sede->id,
                    'category_id' => $category->id,
                    'title' => $template['title'],
                    'description' => $template['description'],
                    'capacity' => $template['capacity'],
                    'hours' => 0,
                    'image' => $template['image'],
                    'days' => $template['days'],
                    'start_time' => $template['start_time'],
                    'end_time' => $template['end_time'],
                    'start_date' => '2026-05-15',
                    'end_date' => '2026-09-15',
                    'status' => $template['status'],
                ]);
            }
        }
    }
}
