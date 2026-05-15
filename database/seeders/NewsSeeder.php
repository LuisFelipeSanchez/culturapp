<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Sede;

class NewsSeeder extends Seeder
{
    private array $templates = [
        [
            'title' => 'Taller de pintura al óleo para principiantes',
            'content' => 'Aprende las técnicas básicas del óleo con artistas locales reconocidos. El taller incluye todos los materiales y se realizará durante cuatro sábados consecutivos. No se requiere experiencia previa.',
            'action_text' => 'Inscribirme ahora',
        ],
        [
            'title' => 'Concierto de música tradicional caldense',
            'content' => 'Disfruta de una noche de pasillos, bambucos y guabinas interpretados por la estudiantina de la casa de la cultura. Entrada libre hasta completar aforo.',
            'action_text' => null,
        ],
        [
            'title' => 'Convocatoria abierta para formadores culturales 2026',
            'content' => 'La Alcaldía de Manizales invita a artistas, gestores y formadores a inscribir sus propuestas para el programa de formación cultural del segundo semestre. Plazo hasta el 30 de junio.',
            'action_text' => 'Ver términos y condiciones',
        ],
        [
            'title' => 'Inauguración de la exposición "Raíces y Wings"',
            'content' => 'La muestra reúne obras de 15 artistas locales que exploran la identidad manizaleña entre lo tradicional y lo contemporáneo. Estará abierta al público durante tres semanas.',
            'action_text' => 'Más información',
        ],
        [
            'title' => 'Festival de teatro comunitario',
            'content' => 'Tres días de funciones de teatro con grupos barriales y veredales. Habrá taller de dramaturgia previo al festival. Participa con tu grupo o asiste como espectador.',
            'action_text' => 'Consultar programación',
        ],
        [
            'title' => 'Círculo de lectura: autores latinoamericanos',
            'content' => 'Cada tercer jueves del mes nos reunimos para comentar obras de García Márquez, Benedetti, Valenzuela y más. Este mes leemos "Crónica de una muerte anunciada". Todos son bienvenidos.',
            'action_text' => null,
        ],
        [
            'title' => 'Clases de danza folclórica para niños y niñas',
            'content' => 'Inscripciones abiertas para el programa de iniciación dancística dirigido a menores de 8 a 12 años. Clases los martes y jueves de 4:00 a 5:30 p.m. Cupos limitados.',
            'action_text' => 'Reservar cupo',
        ],
        [
            'title' => 'Jornada de restauración del patrimonio arquitectónico',
            'content' => 'Voluntarios y voluntarias se reúnen para la limpieza y mantenimiento de fachadas del sector histórico. Incluye caminata guiada por el centro heritage de Manizales.',
            'action_text' => 'Participar como voluntario',
        ],
        [
            'title' => 'Cine-forum: cine arte latinoamericano',
            'content' => 'Proyección mensual de películas independientes seguida de un diálogo con cineastas locales. Este mes presentamos "La teta asustada" de Claudia Llosa. Entrada por aporte voluntario.',
            'action_text' => null,
        ],
        [
            'title' => 'Feria de emprendimiento cultural',
            'content' => 'Artistas y emprendedores culturales exhiben y venden sus productos artesanales, discos, libros y obras gráficas. Espacios disponibles para nuevos expositores.',
            'action_text' => 'Solicitar stand',
        ],
    ];

    public function run(): void
    {
        $sedes = Sede::all();

        foreach ($sedes as $sede) {
            foreach ($this->templates as $template) {
                News::create([
                    'sede_id' => $sede->id,
                    'title' => $template['title'],
                    'content' => $template['content'],
                    'image_url' => null,
                    'is_published' => true,
                    'action_text' => $template['action_text'],
                    'action_url' => $template['action_text']
                        ? route('sedes.show', $sede)
                        : null,
                ]);
            }
        }

        News::create([
            'sede_id' => null,
            'title' => 'Gran convocatoria anual de Cultura',
            'content' => 'La Alcaldía de Manizales abre la gran convocatoria para formadores culturales. Revisa los términos y condiciones en el documento oficial.',
            'image_url' => null,
            'is_published' => true,
            'action_text' => 'Descargar PDF (Términos)',
            'action_url' => 'https://manizales.gov.co/cultura',
        ]);
    }
}
