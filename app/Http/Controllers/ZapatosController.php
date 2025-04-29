<?php

namespace App\Http\Controllers;

use App\Models\Zapatos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZapatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('ListZapatos', [
            'zapatos' => Zapatos::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateZapatos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'number' => 'required|max:2' 
        ]);

        Zapatos::create($validate);
        return redirect()->route('zapatos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zapatos $zapato)
    {
        return Inertia::render('ShowZapatos', [
            'zapatos' => $zapato
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zapatos $zapato)
    {
        return Inertia::render('EditZapatos', [
            'zapatos' => $zapato
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zapatos $zapato)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'number' => 'required|max:2' 
        ]);

        $zapato->update($validate);
        return redirect()->route('zapatos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zapatos $zapato)
    {
        $zapato->delete();
        return redirect()->route('zapatos.index');
    }
}
