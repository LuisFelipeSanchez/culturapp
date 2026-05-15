<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Sede;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    private array $templates = [
        ['title' => 'Pintura al óleo para principiantes', 'description' => 'Aprende las técnicas básicas del óleo: mezcla de colores, pinceladas y composición. Incluye todos los materiales.', 'days' => [1, 3], 'start_time' => '14:00', 'end_time' => '16:00', 'status' => 'open', 'capacity' => 20],
        ['title' => 'Guitarra acústica nivel inicial', 'description' => 'Domina los acordes básicos, ritmos de pasillo y bambuco. Trae tu instrumento o usa uno de la sede.', 'days' => [2, 4], 'start_time' => '17:00', 'end_time' => '19:00', 'status' => 'open', 'capacity' => 15],
        ['title' => 'Danza folclórica colombiana', 'description' => 'Coreografías de joropo, cumbia y sanjuanero. Abierto a todas las edades, sin experiencia requerida.', 'days' => [3, 5], 'start_time' => '10:00', 'end_time' => '12:00', 'status' => 'in_progress', 'capacity' => 25],
        ['title' => 'Taller de escritura creativa', 'description' => 'Explora el cuento corto, la poesía y la crónica urbana con ejercicios prácticos y lectura grupal.', 'days' => [6], 'start_time' => '09:00', 'end_time' => '12:00', 'status' => 'open', 'capacity' => 18],
        ['title' => 'Fotografía digital y edición', 'description' => 'De la captura al postproceso: composición, luz natural y edición con software libre.', 'days' => [1, 3, 5], 'start_time' => '18:00', 'end_time' => '20:00', 'status' => 'open', 'capacity' => 12],
        ['title' => 'Cerámica y modelado a mano', 'description' => 'Técnicas de pinzado, placas y rollos para crear piezas funcionales y decorativas.', 'days' => [2, 4], 'start_time' => '10:00', 'end_time' => '12:00', 'status' => 'open', 'capacity' => 10],
        ['title' => 'Cocina tradicional caldense', 'description' => 'Aprende a preparar arepas de mote, chorizo paisa y dulce de guayaba con ingredientes locales.', 'days' => [6], 'start_time' => '14:00', 'end_time' => '17:00', 'status' => 'open', 'capacity' => 15],
        ['title' => 'Introducción a la programación', 'description' => 'Lógica de programación con Scratch y Python. Ideal para jóvenes y adultos sin experiencia.', 'days' => [1, 3], 'start_time' => '18:00', 'end_time' => '20:00', 'status' => 'in_progress', 'capacity' => 20],
        ['title' => 'Restauración de patrimonio local', 'description' => 'Técnicas de conservación y restauración de fachadas y objetos históricos del centro de Manizales.', 'days' => [5], 'start_time' => '15:00', 'end_time' => '18:00', 'status' => 'open', 'capacity' => 12],
        ['title' => 'Malabares y acrobacia básica', 'description' => 'Clavas, aros y equilibrio corporal. Desarrolla coordinación y confianza escénica.', 'days' => [2, 4], 'start_time' => '16:00', 'end_time' => '18:00', 'status' => 'open', 'capacity' => 16],
        ['title' => 'Acuarela paisajística', 'description' => 'Pinta los paisajes de Manizales con técnicas de lavado, húmedo sobre húmedo y veladuras.', 'days' => [6], 'start_time' => '10:00', 'end_time' => '13:00', 'status' => 'open', 'capacity' => 14],
        ['title' => 'Piano y teclados populares', 'description' => 'Acompañamiento de música tropical y sacra. Lectura de partituras y práctica en teclado.', 'days' => [1, 4], 'start_time' => '16:00', 'end_time' => '18:00', 'status' => 'open', 'capacity' => 10],
        ['title' => 'Teatro comunitario y dramaturgia', 'description' => 'Crea y monta obras cortas a partir de historias del barrio. Incluye técnicas de voz y cuerpo.', 'days' => [3, 5], 'start_time' => '17:00', 'end_time' => '19:00', 'status' => 'finished', 'capacity' => 22],
        ['title' => 'Tejido en telar artesanal', 'description' => 'Aprende a montar un telar de madera y tejer bufandas, tapetes y mochilas con lana local.', 'days' => [2, 6], 'start_time' => '09:00', 'end_time' => '11:00', 'status' => 'open', 'capacity' => 8],
        ['title' => 'Video documental comunitario', 'description' => 'De la idea al cortometraje: guion, grabación con celular y edición básica para contar tu territorio.', 'days' => [4, 5], 'start_time' => '18:00', 'end_time' => '20:00', 'status' => 'open', 'capacity' => 14],
    ];

    private array $categoryMap = [
        0 => 'Artes Plásticas',
        1 => 'Música',
        2 => 'Danza y Teatro',
        3 => 'Literatura',
        4 => 'Fotografía y Video',
        5 => 'Artes Plásticas',
        6 => 'Gastronomía Cultural',
        7 => 'Tecnología e Innovación',
        8 => 'Patrimonio Cultural',
        9 => 'Circo y Acrobacia',
        10 => 'Artes Plásticas',
        11 => 'Música',
        12 => 'Danza y Teatro',
        13 => 'Artesanía',
        14 => 'Fotografía y Video',
    ];

    public function run(): void
    {
        $sedes = Sede::all();
        $categories = Category::all()->keyBy('name');

        foreach ($sedes as $sede) {
            foreach ($this->templates as $index => $template) {
                $categoryName = $this->categoryMap[$index];
                $category = $categories->get($categoryName);

                Course::create([
                    'sede_id' => $sede->id,
                    'category_id' => $category->id,
                    'title' => $template['title'],
                    'description' => $template['description'],
                    'capacity' => $template['capacity'],
                    'hours' => 0,
                    'image' => null,
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
