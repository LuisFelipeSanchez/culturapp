<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::with(['courses', 'news'])->get();
        return view('sedes.index', compact('sedes'));
    }

    public function show(Sede $sede)
    {
        $sede->load(['courses.category', 'news' => fn($q) => $q->latest()->take(20)]);
        return view('sedes.show', compact('sede'));
    }
}
