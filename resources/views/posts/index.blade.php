@extends('layouts.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <a href="{{ url('posts/create') }}" class="btn btn-primary">New Post</a>
    <h2 class="py-4">Posts List</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Category</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ substr($post->title, 1, 40) . '...' }}</td>
                    <td>{{ substr($post->content, 1, 60) . '...' }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>
                        <a href="{{ Route('posts.show', $post->id) }}" class="btn btn-outline-info">Show</a>
                        <a href="{{ Route('posts.edit', $post->id) }}" class="btn btn-outline-info">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Delete Post ?')"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
