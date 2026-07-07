<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offre;

class OffresSeeder extends Seeder
{
    public function run(): void
    {
        $offres = [
            [
                'titre'              => 'Decouverte de Paris',
                'description'        => 'Visitez la ville lumiere avec un guide expert. Tour Eiffel, Louvre, Champs-Elysees.',
                'destination'        => 'Paris',
                'pays'               => 'France',
                'prix'               => 1200.00,
                'duree_jours'        => 7,
                'date_depart'        => '2025-06-15',
                'date_retour'        => '2025-06-22',
                'places_totales'     => 20,
                'places_disponibles' => 15,
                'type'               => 'sejour',
                'statut'             => 'active',
                'featured'           => true,
            ],
            [
                'titre'              => 'Safari Kenya',
                'description'        => 'Aventure extraordinaire dans les savanes du Kenya.',
                'destination'        => 'Nairobi',
                'pays'               => 'Kenya',
                'prix'               => 3500.00,
                'duree_jours'        => 10,
                'date_depart'        => '2025-07-01',
                'date_retour'        => '2025-07-11',
                'places_totales'     => 12,
                'places_disponibles' => 8,
                'type'               => 'aventure',
                'statut'             => 'active',
                'featured'           => true,
            ],
            [
                'titre'              => 'Istanbul Magique',
                'description'        => 'Plongez dans la culture ottomane. Mosquee Bleue, Grand Bazar.',
                'destination'        => 'Istanbul',
                'pays'               => 'Turquie',
                'prix'               => 950.00,
                'duree_jours'        => 5,
                'date_depart'        => '2025-05-20',
                'date_retour'        => '2025-05-25',
                'places_totales'     => 25,
                'places_disponibles' => 20,
                'type'               => 'circuit',
                'statut'             => 'active',
                'featured'           => false,
            ],
            [
                'titre'              => 'Maldives Paradis',
                'description'        => 'Sejour de reve dans les eaux cristallines des Maldives.',
                'destination'        => 'Male',
                'pays'               => 'Maldives',
                'prix'               => 4200.00,
                'duree_jours'        => 8,
                'date_depart'        => '2025-08-10',
                'date_retour'        => '2025-08-18',
                'places_totales'     => 10,
                'places_disponibles' => 6,
                'type'               => 'sejour',
                'statut'             => 'active',
                'featured'           => true,
                'prix_promo'         => 3800.00,
            ],
            [
                'titre'              => 'Rome Eternelle',
                'description'        => 'Explorez l histoire de Rome. Colisee, Vatican, Fontaine de Trevi.',
                'destination'        => 'Rome',
                'pays'               => 'Italie',
                'prix'               => 880.00,
                'duree_jours'        => 6,
                'date_depart'        => '2025-09-05',
                'date_retour'        => '2025-09-11',
                'places_totales'     => 18,
                'places_disponibles' => 18,
                'type'               => 'circuit',
                'statut'             => 'active',
                'featured'           => false,
            ],
        ];

        foreach ($offres as $offre) {
            Offre::create($offre);
        }
        $this->command->info('5 offres creees !');
    }
}