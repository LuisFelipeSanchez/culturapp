<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function indexPublic()
    {
        // Todas las noticias publicadas de cualquier sede, con relación sede cargada
        $news = News::with('sede')
            ->where('is_published', true)
            ->latest()
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'image_url' => $item->image_url
                    ? (str_starts_with($item->image_url, 'http')
                        ? $item->image_url
                        : asset($item->image_url))
                    : null,
                'sede_name' => $item->sede?->name,
                'date' => $item->created_at->translatedFormat('d M Y'),
                'action_text' => $item->action_text,
                'action_url' => $item->action_url,
            ]);

        return view('noticias.index', compact('news'));
    }
}
