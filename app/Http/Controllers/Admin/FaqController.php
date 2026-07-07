<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = ChatbotFaq::orderBy('ordre')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'  => 'required|string',
            'reponse'   => 'required|string',
            'categorie' => 'required|string',
        ]);

        ChatbotFaq::create([
            'question'  => $request->question,
            'reponse'   => $request->reponse,
            'categorie' => $request->categorie,
            'mots_cles' => json_encode(explode(',', $request->mots_cles ?? '')),
            'actif'     => $request->has('actif'),
            'ordre'     => $request->ordre ?? 0,
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ creee !');
    }

    public function edit(ChatbotFaq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, ChatbotFaq $faq)
    {
        $faq->update([
            'question'  => $request->question,
            'reponse'   => $request->reponse,
            'categorie' => $request->categorie,
            'mots_cles' => json_encode(explode(',', $request->mots_cles ?? '')),
            'actif'     => $request->has('actif'),
            'ordre'     => $request->ordre ?? 0,
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ mise a jour !');
    }

    public function destroy(ChatbotFaq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ supprimee !');
    }

    public function show(ChatbotFaq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }
}