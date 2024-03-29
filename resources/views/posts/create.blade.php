@extends('layouts.app')

@section('content')
    <h2 class="py-4">New Post</h2>
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                name="title" id="title" placeholder="Enter post title">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="3"
                placeholder="Enter content">{{ old('content') }}</textarea>
            @error('content')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label @error('image') is-invalid @enderror"">Image</label>
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
                    <option value="{{ $author->id }}" @if (old('user_id') == $author->id) selected="selected" @endif>
                        {{ $author->name}}
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
                    <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected="selected" @endif>
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