@extends('layouts.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <h2>Post details</h2>
    <div class="card mb-3">
        @if (Str::contains($post->image, 'https'))
            <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title }}">
        @else
            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
        @endif

        <div class="card-body">
            <h5 class="card-title">{{ $post->title }} <span class="badge bg-primary">{{ $post->category->name }}</span>
            </h5>
            <p class="card-text">Tags:
                @foreach ($post->tags as $tag)
                    <span class="badge bg-secondary">#{{ $tag->name }}</span>
                @endforeach
            </p>
            <p class="card-text">Author: {{ $post->user->name }}</p>
            <p class="card-text">{{ $post->content }}</p>
            <p class="card-text"><small class="text-body-secondary">{{ $post->created_at }}</small></p>
        </div>
    </div>
@endsection
