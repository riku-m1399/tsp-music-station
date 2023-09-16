@extends('layouts.app')

@section('title', 'Category')
    
@section('content')
  <div class="container">
    @include('users.categories.header')

    {{-- Show all posts here --}}
    <div style="margin-top: 100px">
      @if ($category->categoryPost->isNotEmpty())
          <div class="row">
            @foreach ($category->categoryPost as $categoryPost)
                <div class="col-lg-4 col-md-6 mb-4">
                  <a href="{{ route('post.show', $categoryPost->post->id) }}">
                    <img src="{{ $categoryPost->post->image }}" alt="post id {{ $categoryPost->post->id }}" class="grid-img">
                  </a>
                </div>
            @endforeach
          </div>
      @else
          <h3 class="text-muted text-center">No posts yet.</h3>
      @endif
    </div>
  </div>
  

@endsection