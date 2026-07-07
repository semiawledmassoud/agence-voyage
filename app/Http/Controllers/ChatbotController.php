<?php

namespace App\Http\Controllers;

use App\Models\ChatbotFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    // URL du serveur Python
    private string $pythonUrl = 'http://localhost:5000';

    public function repondre(Request $request)
    {
        $message = trim($request->message ?? '');

        if (empty($message)) {
            return response()->json(['reponse' => 'Posez-moi une question !']);
        }

        // 1. Essayer le chatbot Python IA
        try {
            $response = Http::timeout(5)
                ->post($this->pythonUrl . '/chat', [
                    'message' => $message,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'reponse' => $data['reponse'] ?? 'Je n\'ai pas compris.',
                    'source'  => 'ia'
                ]);
            }
        } catch (\Exception $e) {
            // Python non disponible → utiliser les FAQs
        }

        // 2. Fallback : FAQs de la base de données
        $reponseFaq = $this->chercherFaq($message);
        if ($reponseFaq) {
            return response()->json([
                'reponse' => $reponseFaq,
                'source'  => 'faq'
            ]);
        }

        // 3. Réponse par défaut
        return response()->json([
            'reponse' => "🤔 Je n'ai pas compris votre question.\n\nContactez-nous :\n📞 +216 71 XXX XXX\n✉️ contact@traveldream.tn",
            'source'  => 'default'
        ]);
    }

    private function chercherFaq(string $message): ?string
    {
        $messageLower = strtolower($message);
        $faqs         = ChatbotFaq::where('actif', true)->get();

        $meilleure = null;
        $scoreMax  = 0;

        foreach ($faqs as $faq) {
            $score = 0;
            $mots  = $faq->mots_cles ?? [];

            foreach ($mots as $mot) {
                if (str_contains($messageLower, strtolower(trim($mot)))) {
                    $score += 2;
                }
            }

            if (str_contains(strtolower($faq->question), $messageLower)) {
                $score += 5;
            }

            if ($score > $scoreMax) {
                $scoreMax  = $score;
                $meilleure = $faq;
            }
        }

        return ($meilleure && $scoreMax >= 2) ? $meilleure->reponse : null;
    }

    // Synchroniser les FAQs de la BD vers le chatbot Python
    public function syncFaqs()
    {
        try {
            $faqs = ChatbotFaq::where('actif', true)->get();

            foreach ($faqs as $faq) {
                Http::timeout(3)->post($this->pythonUrl . '/train', [
                    'patterns' => $faq->mots_cles ?? [$faq->question],
                    'response' => $faq->reponse,
                ]);
            }

            return response()->json(['status' => 'ok', 'message' => 'FAQs synchronisées !']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}