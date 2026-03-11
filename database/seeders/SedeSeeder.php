<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sedes = [
            [
                'name' => 'Casa de la Cultura Alto Bonito',
                'address' => 'Vereda Alto Bonito, Manizales, Caldas, Colombia',
                'zone' => 'rural',
                'description' => 'Un espacio para la creación y difusión de saberes campesinos y artísticos en la zona rural. Talleres de tejido, música tradicional y agricultura sostenible.',
                'image_url' => 'https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.10000000,
                'longitude' => -75.48000000,
            ],
            [
                'name' => 'Casa de la Cultura El Nevado',
                'address' => 'Sector El Nevado, Manizales, Caldas, Colombia',
                'zone' => 'rural',
                'description' => 'Centro de encuentro en las alturas, enfocado en el turismo cultural, la gastronomía local y el senderismo de apreciación ambiental.',
                'image_url' => 'https://images.unsplash.com/photo-1542281286-9e0a16bb7366?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.09500000,
                'longitude' => -75.47000000,
            ],
            [
                'name' => 'Casa de la Cultura Cumanday',
                'address' => 'Barrio Cumanday, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'El corazón cultural del barrio Cumanday, con una gran oferta en artes plásticas, de danza folclórica y literatura para niños.',
                'image_url' => 'https://images.unsplash.com/photo-1577416412292-747c6607f055?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.07000000,
                'longitude' => -75.49000000,
            ],
            [
                'name' => 'Casa de la Cultura Minitas',
                'address' => 'Barrio Minitas, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'Formación artística para jóvenes y adultos. Cuenta con estudios de grabación comunitaria y espacios de ensayo musical.',
                'image_url' => 'https://images.unsplash.com/photo-1502014822147-1aed4d402349?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.06500000,
                'longitude' => -75.48000000,
            ],
            [
                'name' => 'Casa de la Cultura Santa Clara',
                'address' => 'Vereda Santa Clara, Manizales, Caldas, Colombia',
                'zone' => 'rural',
                'description' => 'Integración comunitaria rural mediante la enseñanza artística, teatro campesino y festivales tradicionales locales.',
                'image_url' => 'https://images.unsplash.com/photo-1605810230434-7631ac76ec81?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.08000000,
                'longitude' => -75.51000000,
            ],
            [
                'name' => 'Casa de la Cultura Chipre',
                'address' => 'Barrio Chipre, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'El mirador cultural de la ciudad. Con salas de exposiciones itinerantes y un balcón para el teatro urbano.',
                'image_url' => 'https://images.unsplash.com/photo-1569007358249-f00e57202d73?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.06890000,
                'longitude' => -75.52220000,
            ],
            [
                'name' => 'Casa de la Cultura Tesorito',
                'address' => 'Barrio Tesorito, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'Espacio enfocado en la enseñanza de cerámica, escultura y pintura para la preservación de técnicas ancestrales.',
                'image_url' => 'https://images.unsplash.com/photo-1516962126636-27ad087061cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.08000000,
                'longitude' => -75.50000000,
            ],
            [
                'name' => 'Casa de la Cultura Kilómetro 41',
                'address' => 'Km 41, vía a Neira, Manizales, Caldas, Colombia',
                'zone' => 'rural',
                'description' => 'Punto de encuentro musical en la vía norte. Reconocida por sus ensambles instrumentales y danzas de salón.',
                'image_url' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.00000000,
                'longitude' => -75.53000000,
            ],
            [
                'name' => 'Casa de la Cultura San José',
                'address' => 'Barrio San José, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'Fomento a la lectura y escritura creativa. Sede de la biblioteca barrial y escenario de debates y conversatorios.',
                'image_url' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.07500000,
                'longitude' => -75.48000000,
            ],
            [
                'name' => 'Casa de la Cultura Versalles',
                'address' => 'Barrio Versalles, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'Fotografía, cine-club y artes visuales. Un espacio contemporáneo para las nuevas expresiones de la comuna.',
                'image_url' => 'https://images.unsplash.com/photo-1510070009289-b5fe3ed8c58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.07300000,
                'longitude' => -75.49200000,
            ],
            [
                'name' => 'Casa de la Cultura La Estación',
                'address' => 'Barrio La Estación, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'Arquitectura patrimonial y enseñanza de lutería, restauración de instrumentos y memoria ferroviaria.',
                'image_url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.08200000,
                'longitude' => -75.49900000,
            ],
            [
                'name' => 'Casa de la Cultura El Remanso',
                'address' => 'Vereda El Remanso, Manizales, Caldas, Colombia',
                'zone' => 'rural',
                'description' => 'Naturaleza viva y saberes medicinales. Fomenta el vínculo entre la botánica, el arte y la sanación tradicional.',
                'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.03000000,
                'longitude' => -75.55000000,
            ],
            [
                'name' => 'Casa de la Cultura El Bosque',
                'address' => 'Barrio El Bosque, Manizales, Caldas, Colombia',
                'zone' => 'urbana',
                'description' => 'Talleres de ecología y artes plásticas con material reciclado, y cursos gratuitos de jardinería comunitaria.',
                'image_url' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'latitude' => 5.08500000,
                'longitude' => -75.49000000,
            ],
        ];



        foreach ($sedes as $sede) {
            \App\Models\Sede::create($sede);
        }
    }
}
