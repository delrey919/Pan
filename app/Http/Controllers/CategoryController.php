<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Categories;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('ListCategories', [
            'categories' => Categories::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateCategories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        Categories::create($validate);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        return Inertia::render('CreateCategories',[
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        return Inertia::render('EditCategories', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Categories $category)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
        ]);

        $category->update($validate);
        return redirect()->route('categories.index');
    }

    public function destroy(Categories $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
