<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer la liste des utilisateurs
        $authors = User::all();
        // Récupérer la liste des catégories
        $categories = Category::all();

        return view('posts.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate($this->validationRules());

        // Créer un Post vide
        $newPost = new Post();

        // Le remplir avec le contenu du formulaire
        $newPost->title = $request->title;
        $newPost->content = $request->content;
        $newPost->user_id = $request->user_id;
        $newPost->category_id = $request->category_id;

        // Sauvegarde dans la BD
        $newPost->save();

        return redirect()->route('posts.show', $newPost->id)->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('category', 'user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function validationRules()
    {
        return [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
