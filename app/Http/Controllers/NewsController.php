<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function indexPublic()
    {
        // Se sacan únicamente las noticias "generales" (sin sede) publicadas, ordenadas de más nuevas a antiguas
        $news = News::whereNull('sede_id')
                    ->where('is_published', true)
                    ->latest()
                    ->paginate(12);

        return view('noticias.index', compact('news'));
    }
}
