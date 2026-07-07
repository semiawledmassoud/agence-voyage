from flask import Flask, request, jsonify
from flask_cors import CORS
import re, math, json
from collections import Counter

app = Flask(__name__)
CORS(app)

KB = [
    {"p": ["bonjour","salut","hello","bonsoir","hi","hey","coucou"],
     "r": "Bonjour ! Je suis l'assistant IA TravelDream 🤖\n\nJe peux vous aider avec :\n✈ Réservations de voyages\n🌍 Destinations disponibles\n💳 Paiements et tarifs\n❌ Annulations\n📞 Contact et support\n\nQue puis-je faire pour vous ?"},

    {"p": ["reserver","reservation","booking","comment reserver","je veux reserver","faire une reservation"],
     "r": "📋 Comment réserver un voyage :\n\n1️⃣ Allez dans la section Destinations\n2️⃣ Choisissez l'offre qui vous convient\n3️⃣ Cliquez sur Réserver maintenant\n4️⃣ Remplissez vos coordonnées\n5️⃣ Procédez au paiement sécurisé\n\n✅ Vous recevrez une confirmation par email immédiatement !"},

    {"p": ["annuler","annulation","cancel","rembourser","remboursement","comment annuler"],
     "r": "❌ Procédure d'annulation :\n\n📱 Depuis votre espace client :\n→ Mes Réservations → Cliquez sur la réservation → Annuler\n\n📋 Conditions :\n• Avant confirmation admin : annulation GRATUITE\n• Après confirmation : contactez-nous\n• Remboursement : 5-7 jours ouvrables\n\n📞 Besoin d'aide : +216 71 XXX XXX"},

    {"p": ["paiement","payer","carte","prix","tarif","combien","cout","stripe","paypal","visa","mastercard"],
     "r": "💳 Modes de paiement acceptés :\n\n• Carte Visa / Mastercard (via Stripe)\n• PayPal sécurisé\n• Virement bancaire (sur demande)\n\n🔒 Toutes les transactions sont chiffrées SSL.\n\n💰 Les prix incluent :\n✓ Vols aller-retour\n✓ Hébergement\n✓ Guide touristique\n✓ Transferts aéroport"},

    {"p": ["destination","voyage","offre","vacances","ou aller","pays","proposez"],
     "r": "🌍 Nos destinations populaires :\n\n🗼 Paris, France — dès 1 200 DT (7j)\n🕌 Istanbul, Turquie — dès 950 DT (5j)\n🌴 Maldives — dès 3 800 DT (8j) 🔥\n🏛️ Rome, Italie — dès 880 DT (6j)\n🦁 Safari Kenya — dès 3 500 DT (10j)\n🏙️ Dubai, Émirats — dès 2 100 DT (5j)\n🏝️ Bali, Indonésie — dès 1 600 DT (8j)\n\n👉 Consultez toutes nos offres dans Destinations !"},

    {"p": ["paris","france","tour eiffel","louvre","champs"],
     "r": "🗼 Voyage Paris — France\n\n⏱ Durée : 7 jours\n💰 Prix : 1 200 DT / personne\n⭐ Inclus : Vol A/R + Hôtel 4★ + Guide + Transferts\n\n🎯 Au programme :\n• Tour Eiffel & Champs-Élysées\n• Musée du Louvre\n• Montmartre & Notre-Dame\n• Versailles\n\n📅 Départs disponibles toute l'année !"},

    {"p": ["maldives","plage","ile","paradis","bungalow","lagon"],
     "r": "🌴 Maldives Paradis — PROMO !\n\n⏱ Durée : 8 jours\n💰 Prix PROMO : 3 800 DT (au lieu de 4 200 DT)\n⭐ Inclus : Vol A/R + Bungalow sur l'eau + Petit-déj\n\n🎯 Activités :\n• Plongée sous-marine\n• Snorkeling avec raies\n• Spa de luxe\n• Couchers de soleil exceptionnels\n\n⚠️ Places très limitées !"},

    {"p": ["istanbul","turquie","mosquee","bazar","bosphore"],
     "r": "🕌 Istanbul Magique — Turquie\n\n⏱ Durée : 5 jours\n💰 Prix : 950 DT / personne\n⭐ Inclus : Vol A/R + Hôtel + Guide local\n\n🎯 À découvrir :\n• Mosquée Bleue & Sainte-Sophie\n• Grand Bazar historique\n• Croisière sur le Bosphore\n• Palais de Topkapi\n\n✅ Pas de visa requis pour les Tunisiens !"},

    {"p": ["rome","italie","colisee","vatican","trevi"],
     "r": "🏛️ Rome Éternelle — Italie\n\n⏱ Durée : 6 jours\n💰 Prix : 880 DT / personne\n⭐ Inclus : Vol A/R + Hôtel + Guide\n\n🎯 Incontournables :\n• Colisée & Forum Romain\n• Cité du Vatican\n• Fontaine de Trevi\n• Place Navone\n\n📅 Découvrez 2000 ans d'histoire !"},

    {"p": ["dubai","emirats","burj","desert","shopping"],
     "r": "🏙️ Dubai — Émirats Arabes Unis\n\n⏱ Durée : 5 jours\n💰 Prix : 2 100 DT / personne\n⭐ Inclus : Vol A/R + Hôtel luxe + Transferts\n\n🎯 Expériences :\n• Burj Khalifa (la plus haute tour)\n• Safari dans le désert\n• Shopping Mall of the Emirates\n• Dîner sur dhow traditionnel\n\n📋 Visa requis — nous vous aidons !"},

    {"p": ["safari","kenya","afrique","lion","elephant","faune","girafes"],
     "r": "🦁 Safari Kenya — Afrique\n\n⏱ Durée : 10 jours\n💰 Prix : 3 500 DT / personne\n⭐ Inclus : Vol A/R + Lodge + Guide naturaliste + Jeeps\n\n🦒 La grande faune :\n• Lions, Léopards, Guépards\n• Éléphants, Rhinocéros\n• Girafes, Zèbres, Gnous\n• Hippopotames et crocodiles\n\n🌅 Une expérience de vie inoubliable !"},

    {"p": ["contact","telephone","email","adresse","joindre","appeler","urgence"],
     "r": "📞 Contactez TravelDream :\n\n☎️ Téléphone : +216 71 XXX XXX\n📧 Email : contact@traveldream.tn\n🕐 Horaires : Lun-Ven 8h00-18h00\n📍 Adresse : Tunis, Tunisie\n\n💬 Je suis disponible 24h/24 pour répondre à vos questions !\n\n🚨 Urgence voyage : +216 9X XXX XXX"},

    {"p": ["visa","passeport","document","papier","entree"],
     "r": "🛂 Documents de voyage :\n\n📔 Passeport : valide 6 mois minimum\n\n🗺️ Visas par destination :\n• 🇫🇷 France/Europe : Visa Schengen requis\n• 🇹🇷 Turquie : Visa à l'arrivée (15€)\n• 🌴 Maldives : Visa gratuit à l'arrivée\n• 🇦🇪 Dubai : Visa requis (nous gérons)\n• 🇮🇹 Italie : Visa Schengen requis\n\n✅ Nous vous accompagnons dans toutes les démarches !"},

    {"p": ["assurance","accident","sante","medecin","couverture","protection"],
     "r": "🏥 Assurance voyage recommandée :\n\nCouverture complète incluant :\n• Assistance médicale internationale\n• Rapatriement d'urgence\n• Annulation/interruption de voyage\n• Bagages perdus/volés\n• Responsabilité civile\n\n💰 Tarifs : à partir de 50 DT par voyage\n\n📞 Nous travaillons avec des assureurs partenaires — contactez-nous pour un devis !"},

    {"p": ["enfant","famille","kids","bebe","reduction","tarif enfant"],
     "r": "👨‍👩‍👧‍👦 Tarifs famille TravelDream :\n\n👶 Moins de 2 ans : GRATUIT\n🧒 2 à 12 ans : -30% sur le tarif adulte\n👦 12 à 18 ans : -10% sur le tarif adulte\n\n🎒 Services famille :\n• Chambres familiales disponibles\n• Activités adaptées aux enfants\n• Menus spéciaux enfants\n\n📞 Contactez-nous pour un devis personnalisé !"},

    {"p": ["hotel","hebergement","logement","chambre","nuit","etoile"],
     "r": "🏨 Hébergement TravelDream :\n\nTous nos forfaits incluent l'hôtel :\n\n⭐⭐⭐ Standard — confort garanti\n⭐⭐⭐⭐ Confort — notre recommandation\n⭐⭐⭐⭐⭐ Luxe — expérience premium\n\n✓ Hôtels soigneusement sélectionnés\n✓ Petit-déjeuner inclus (selon offre)\n✓ Emplacement idéal garanti\n\nPrécisez vos préférences lors de la réservation !"},

    {"p": ["merci","super","parfait","excellent","genial","bien","bravo"],
     "r": "😊 Merci pour votre confiance !\n\nC'est toujours un plaisir de vous aider.\n\n✈️ Bon voyage avec TravelDream !\n🌍 Le monde vous attend...\n\nN'hésitez pas si vous avez d'autres questions !"},

    {"p": ["au revoir","bye","bonne journee","a bientot","ciao","goodbye"],
     "r": "👋 Au revoir et à très bientôt !\n\n✈️ TravelDream vous souhaite de beaux voyages !\n\nRevenez quand vous voulez, je suis là 24h/24 🤖"},

    {"p": ["aide","help","que fais tu","que peux tu faire","fonctions","capacites"],
     "r": "🤖 Bienvenue ! Je suis l'assistant IA TravelDream.\n\nJe peux vous informer sur :\n\n📋 Réservations — Comment réserver, modifier, suivre\n🌍 Destinations — Paris, Istanbul, Maldives, Dubai...\n💳 Paiements — Modes, sécurité, tarifs\n❌ Annulations — Procédure et remboursements\n🛂 Documents — Visa, passeport, assurance\n👨‍👩‍👧 Famille — Réductions enfants, offres famille\n📞 Contact — Coordonnées, horaires\n\nPosez-moi votre question !"},
]


def clean(t):
    t = t.lower()
    for a, b in [('é','e'),('è','e'),('ê','e'),('à','a'),('â','a'),('î','i'),('ô','o'),('û','u'),('ç','c'),("'",' '),('-',' ')]:
        t = t.replace(a, b)
    return [w for w in re.sub(r'[^\w\s]',' ',t).split() if len(w)>1]


def tf(tokens):
    c = Counter(tokens)
    n = len(tokens) or 1
    return {w: v/n for w, v in c.items()}


def cos(v1, v2):
    keys = set(v1)|set(v2)
    dot = sum(v1.get(k,0)*v2.get(k,0) for k in keys)
    n1 = math.sqrt(sum(x**2 for x in v1.values()))
    n2 = math.sqrt(sum(x**2 for x in v2.values()))
    return dot/(n1*n2) if n1 and n2 else 0


def find(msg):
    tokens = clean(msg)
    v_msg = tf(tokens)
    best_score, best_r = 0, None

    for item in KB:
        v_kb = tf(clean(' '.join(item['p'])))
        score = cos(v_msg, v_kb)

        # Bonus correspondance exacte
        for p in item['p']:
            words = clean(p)
            if all(w in tokens for w in words):
                score += 0.6
            elif any(w in tokens for w in words):
                score += 0.25

        if score > best_score:
            best_score = score
            best_r = item['r']

    return best_r if best_score > 0.08 else None


@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'ok', 'version': '3.0', 'kb': len(KB)})


@app.route('/chat', methods=['POST'])
def chat():
    data = request.get_json() or {}
    msg  = data.get('message', '').strip()

    if not msg:
        return jsonify({'reponse': 'Posez-moi une question !'})

    r = find(msg)
    if not r:
        r = ("🤔 Je n'ai pas trouvé de réponse précise.\n\n"
             "Essayez :\n• 'Comment réserver ?'\n• 'Destinations disponibles'\n"
             "• 'Modes de paiement'\n• 'Annuler une réservation'\n\n"
             "Ou appelez-nous : +216 71 XXX XXX")

    return jsonify({'reponse': r, 'status': 'ok'})


@app.route('/train', methods=['POST'])
def train():
    data = request.get_json() or {}
    p, r = data.get('patterns', []), data.get('response', '')
    if p and r:
        KB.append({'p': p, 'r': r})
        return jsonify({'status': 'ok', 'total': len(KB)})
    return jsonify({'status': 'error'}), 400


if __name__ == '__main__':
    print("="*45)
    print("  TravelDream Chatbot IA v3.0")
    print(f"  KB: {len(KB)} entrees")
    print("  URL: http://localhost:5000")
    print("="*45)
    app.run(host='0.0.0.0', port=5000, debug=False)