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
            'image_url' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Concierto de música tradicional caldense',
            'content' => 'Disfruta de una noche de pasillos, bambucos y guabinas interpretados por la estudiantina de la casa de la cultura. Entrada libre hasta completar aforo.',
            'action_text' => null,
            'image_url' => 'https://images.unsplash.com/photo-1444021465936-c6ca81d39b84?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Convocatoria abierta para formadores culturales 2026',
            'content' => 'La Alcaldía de Manizales invita a artistas, gestores y formadores a inscribir sus propuestas para el programa de formación cultural del segundo semestre. Plazo hasta el 30 de junio.',
            'action_text' => 'Ver términos y condiciones',
            'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Inauguración de la exposición "Raíces y Wings"',
            'content' => 'La muestra reúne obras de 15 artistas locales que exploran la identidad manizaleña entre lo tradicional y lo contemporáneo. Estará abierta al público durante tres semanas.',
            'action_text' => 'Más información',
            'image_url' => 'https://images.unsplash.com/photo-1574182245530-967d9b3831af?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Festival de teatro comunitario',
            'content' => 'Tres días de funciones de teatro con grupos barriales y veredales. Habrá taller de dramaturgia previo al festival. Participa con tu grupo o asiste como espectador.',
            'action_text' => 'Consultar programación',
            'image_url' => 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Círculo de lectura: autores latinoamericanos',
            'content' => 'Cada tercer jueves del mes nos reunimos para comentar obras de García Márquez, Benedetti, Valenzuela y más. Este mes leemos "Crónica de una muerte anunciada". Todos son bienvenidos.',
            'action_text' => null,
            'image_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Clases de danza folclórica para niños y niñas',
            'content' => 'Inscripciones abiertas para el programa de iniciación dancística dirigido a menores de 8 a 12 años. Clases los martes y jueves de 4:00 a 5:30 p.m. Cupos limitados.',
            'action_text' => 'Reservar cupo',
            'image_url' => 'https://images.unsplash.com/photo-1508700929628-666bc8bd84ea?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Jornada de restauración del patrimonio arquitectónico',
            'content' => 'Voluntarios y voluntarias se reúnen para la limpieza y mantenimiento de fachadas del sector histórico. Incluye caminata guiada por el centro heritage de Manizales.',
            'action_text' => 'Participar como voluntario',
            'image_url' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Cine-forum: cine arte latinoamericano',
            'content' => 'Proyección mensual de películas independientes seguida de un diálogo con cineastas locales. Este mes presentamos "La teta asustada" de Claudia Llosa. Entrada por aporte voluntario.',
            'action_text' => null,
            'image_url' => 'https://images.unsplash.com/photo-1580477667995-2b94f01c9516?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Feria de emprendimiento cultural',
            'content' => 'Artistas y emprendedores culturales exhiben y venden sus productos artesanales, discos, libros y obras gráficas. Espacios disponibles para nuevos expositores.',
            'action_text' => 'Solicitar stand',
            'image_url' => 'https://images.unsplash.com/photo-1531058020387-3be344556be6?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Taller de fotografía documental',
            'content' => 'Aprende a contar historias a través de la lente. Este taller práctico de cinco sesiones te guiará en la composición, edición y narrativa visual. Trae tu cámara o celular y tu curiosidad.',
            'action_text' => 'Registrarme',
            'image_url' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Conversatorio: memoria y patrimonio barrial',
            'content' => 'Vecinos y vecinas comparten historias, anécdotas y fotografías antiguas del barrio. Un espacio para tejer la memoria colectiva y reconocer nuestro patrimonio cotidiano.',
            'action_text' => null,
            'image_url' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Programa de formación en musiquería tradicional',
            'content' => 'Aprende a construir y tocar instrumentos de percusión y cuerda con maestros artesanos. El programa incluye materiales y está dirigido a jóvenes y adultos. Duración: tres meses.',
            'action_text' => 'Conocer detalles',
            'image_url' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Encuentro de poesía urbana y spoken word',
            'content' => 'Una noche de versos, rimas y palabras al aire. Poetas locales y emergentes comparten sus creaciones en un formato íntimo y participativo. Micrófono abierto al final del evento.',
            'action_text' => null,
            'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'title' => 'Jornada de vacunación y salud comunitaria',
            'content' => 'La Secretaría de Salud se une a la casa de la cultura para ofrecer vacunación gratuita, toma de signos vitales y orientación en salud mental. Servicios sin cita previa.',
            'action_text' => 'Ver horarios',
            'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80',
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
                'image_url' => $template['image_url'],
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
            'image_url' => 'https://images.unsplash.com/photo-1497375638960-ca368c7231e4?auto=format&fit=crop&w=800&q=80',
            'is_published' => true,
            'action_text' => 'Descargar PDF (Términos)',
            'action_url' => 'https://manizales.gov.co/cultura',
        ]);
    }
}
