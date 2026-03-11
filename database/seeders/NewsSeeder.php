<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Sede;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $sedes = Sede::all();

        foreach ($sedes as $sede) {
            News::create([
                'sede_id' => $sede->id,
                'title' => '¡Nuevos cursos para esta temporada!',
                'content' => 'Estamos felices de anunciar la apertura de nuevos cursos en nuestra casa de la cultura. Inscríbete ahora para no quedarte sin cupo. Descubre todas las opciones disponibles en nuestra sección de cursos.',
                'image_url' => null,
                'is_published' => true,
                'action_text' => 'Ver cursos disponibles',
                'action_url' => route('sedes.show', $sede) . '#cursos',
            ]);

            News::create([
                'sede_id' => $sede->id,
                'title' => 'Exposición de arte local',
                'content' => 'La próxima semana inauguramos una exposición con las mejores obras de nuestros estudiantes de artes plásticas. Estará abierta al público de lunes a viernes. ¡Te esperamos!',
                'image_url' => null,
                'is_published' => true,
                'action_text' => 'Más detalles',
                'action_url' => 'https://manizales.gov.co',
            ]);
        }

        // Global news
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
