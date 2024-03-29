@extends('layouts.app')

@section('content')
    <h2 class="py-4">Edit Post</h2>
    <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title') ?? $post->title }}" name="title" id="title" placeholder="Enter post title">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="3"
                placeholder="Enter content">{{ old('content') ?? $post->content }}</textarea>
            @error('content')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label @error('image') is-invalid @enderror">Image</label>
            <input class="form-control" type="file" name="image" id="image">
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="user" class="form-label">Author</label>
            <select class="form-select @error('user_id') is-invalid @enderror" id="user" name="user_id"
                aria-label="Default select example">
                <option selected>Select the author</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" @if ($author->id == (old('user_id') ?? $post->user_id)) selected @endif>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category" name="category_id"
                aria-label="Default select example">
                <option selected>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($category->id == (old('category_id') ?? $post->category_id)) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
