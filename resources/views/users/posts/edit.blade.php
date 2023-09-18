@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
  <div class="container">

    <div class="row text-center mb-5">
      <h1>Edit Post</h1>
    </div>

    <div class="row justify-content-center">
      <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label for="category" class="form-label d-block fw-bold">
            Category <span class="text-muted fw-normal">(Up to 3)</span> <span class="text-danger">*</span>
          </label>
          @foreach ($all_categories as $category)
            @if (in_array($category->id, $selected_categories))
              <div class="form-check form-check-inline mb-3">
                <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input" checked>
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
              </div>
            @else
              <div class="form-check form-check-inline mb-3">
                <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
              </div>
            @endif
          @endforeach
          {{-- Error message area --}}
          @error('category')
            <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $post->name) }}">
          </div>
          {{-- Error message area --}}
          @error('name')
            <p class="text-danger small">{{ $message }}</p>
          @enderror


          <div class="mb-3">
            <label for="artist" class="form-label fw-bold">Artist <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="artist" value="{{ old('artist', $post->artist) }}">
          </div>
          {{-- Error message area --}}
          @error('artist')
            <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="10" class="form-control">{{ old('description', $post->description) }}</textarea>
          </div>
          {{-- Error message area --}}
          @error('description')
            <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="url" class="form-label fw-bold">URL <span class="text-muted fw-normal">(YouTube, Apple Music, Spotify, Sound Cloud, Band Camp, etc.)</span></label>
            <input type="text" class="form-control" name="url" value="{{ old('url', $post->url) }}">
          </div>
          {{-- Error message area --}}
          @error('url')
            <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-5">
            <label for="image" class="form-label fw-bold">Image</label>
            <div class="row mb-3">
              <div class="col-6">
                <img src="{{ $post->image }}" class="img-thumbnail w-100">
              </div>
            </div>
            <input type="file" class="form-control" name="image" area-describedby="image-info">
            <div class="form-text" id="image-info">
              The acceptable formats are jpeg, jpg, png and gif only. <br>
              Max file size: 1048Kb
            </div>
            {{-- Error Message Area --}}
            @error('image')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
          </div>

          <div class="row">
            <div class="col text-end">
              <a href="{{ route('post.show', $post->id) }}" class="btn btn-secondary">CANCEL</a>
            </div>
            <div class="col text-start">
              <button type="submit" class="btn btn-outline-warning">EDIT</button>
            </div>
          </div>
          
        </div>
      </form>
    </div>
  </div>
@endsection