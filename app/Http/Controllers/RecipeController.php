<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Recipe;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::latest()->get(); // récupère toutes les recettes
        return view('recipes.index', compact('recipes')); // **vue dédiée à la liste**
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prep_time' => 'required|integer|min:1',
            'difficulty' => 'required|in:Facile,Moyenne,Difficile',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        Recipe::create($validated);

        return redirect()->route('recipes.index')->with('success', 'Recette ajoutée avec succès !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        // Affiche la vue d'édition avec la recette à modifier
        return view('recipes.edit', compact('recipe'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Validation des champs
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prep_time' => 'required|integer|min:1',
            'difficulty' => 'required|in:Facile,Moyenne,Difficile',
            'image' => 'nullable|image|max:2048',
        ]);

        // Gestion de l'image : si une nouvelle image est uploadée, on remplace l'ancienne
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        // Mise à jour de la recette
        $recipe->update($validated);

        return redirect()->route('recipes.index')->with('success', 'Recette mise à jour avec succès !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        // Supprime l'image si elle existe
        if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
            Storage::disk('public')->delete($recipe->image);
        }

        // Supprime la recette
        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Recette supprimée avec succès !');
    }

    public function toggleFavorite(Recipe $recipe)
    {
        $user = auth()->user();

        if ($user->favorites()->where('recipe_id', $recipe->id)->exists()) {
            $user->favorites()->detach($recipe->id);
            return back()->with('success', 'Recette retirée des favoris.');
        }

        $user->favorites()->attach($recipe->id);
        return back()->with('success', 'Recette ajoutée aux favoris.');
    }


    public function favorites()
    {
        $recipes = auth()->user()->favorites()->latest()->get();

        return view('recipes.favorites', compact('recipes'));
    }




}
