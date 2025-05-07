<?php

namespace App\Http\Controllers;

use App\Models\Zapatos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Categories;

class ZapatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('ListZapatos', [
            'zapatos' => Zapatos::with('category')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return Inertia::render('CreateZapatos',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'required|max:255',
            'number'      => 'required|max:2',
            'category_id' => 'required|max:255',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validate['photo'] = $path;
        }

        Zapatos::create($validate);
        return redirect()->route('zapatos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zapatos $zapato)
    {
        return Inertia::render('ShowZapatos', [
            'zapatos' => $zapato->load('category')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zapatos $zapato)
    {
        return Inertia::render('EditZapatos', [
            'zapatos' => $zapato,
            'categories' => Categories::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zapatos $zapato)
    {
        $validate = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'required|max:255',
            'number'      => 'required|max:2',
            'category_id' => 'required|max:255',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validate['photo'] = $path;
        }

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
