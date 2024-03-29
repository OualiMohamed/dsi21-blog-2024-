<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Récupérer le nom de l'image uploadée
        // puis la transférer dans le dossier 'storage/app/posts'
        $image = Storage::disk('public')->put('posts', $request->file('image'));

        // Créer un Post vide
        $newPost = new Post();

        // Le remplir avec le contenu du formulaire
        $newPost->title = $request->title;
        $newPost->content = $request->content;
        $newPost->image = $image;
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
        // Récupérer le Post à partir de son id
        $post = Post::findOrFail($id);

        // Récupérer la liste des utilisateurs
        $authors = User::all();

        // Récupérer la liste des catégories
        $categories = Category::all();

        return view('posts.edit', compact('post', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation du formulaire
        $request->validate($this->validationRules());

        // Récupérer le Post à modifier
        $post = Post::findOrFail($id);

        if ($request->hasFile('image')) {
            // Deleting old image from storage
            $oldImage = $post->image;
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            // Add new image to storage
            $newImage = Storage::disk('public')->put('posts', $request->file('image'));
            // Add new image to DB
            $post->image = $newImage;
        }

        // Mettre à jour le post avec le contenu du formulaire
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $post->category_id = $request->category_id;

        // Enregister le Post mis à jour
        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Récupérer le Post à supprimer
        $post = Post::findOrFail($id);

        // Effacer l'image du Storage
        $image= $post->image;
        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }

        // Effacer le Post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
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
