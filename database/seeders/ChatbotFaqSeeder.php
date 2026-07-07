<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotFaq;

class ChatbotFaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question'  => 'Comment reserver un voyage ?',
                'reponse'   => 'Choisissez une offre, cliquez sur Reserver, remplissez le formulaire et payez en ligne.',
                'categorie' => 'reservation',
                'mots_cles' => json_encode(['reserver', 'reservation', 'comment']),
                'ordre'     => 1,
            ],
            [
                'question'  => 'Quels sont les moyens de paiement ?',
                'reponse'   => 'Nous acceptons Visa, Mastercard via Stripe, et PayPal.',
                'categorie' => 'paiement',
                'mots_cles' => json_encode(['paiement', 'payer', 'carte', 'stripe']),
                'ordre'     => 2,
            ],
            [
                'question'  => 'Comment annuler une reservation ?',
                'reponse'   => 'Allez dans Mes Reservations puis cliquez sur Annuler.',
                'categorie' => 'reservation',
                'mots_cles' => json_encode(['annuler', 'annulation', 'cancel']),
                'ordre'     => 3,
            ],
            [
                'question'  => 'Les prix incluent les billets avion ?',
                'reponse'   => 'Oui, nos prix incluent les billets aller-retour et hotel.',
                'categorie' => 'offres',
                'mots_cles' => json_encode(['prix', 'avion', 'billet', 'inclus']),
                'ordre'     => 4,
            ],
            [
                'question'  => 'Comment modifier mon profil ?',
                'reponse'   => 'Cliquez sur votre nom en haut puis Mon Profil.',
                'categorie' => 'compte',
                'mots_cles' => json_encode(['profil', 'modifier', 'compte']),
                'ordre'     => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            ChatbotFaq::create($faq);
        }
        $this->command->info('FAQs creees !');
    }
}