@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
  <div class="container">

    <div class="row text-center mb-5">
      <h1>Create Post</h1>
    </div>

    <div class="row justify-content-center">
      <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="category" class="form-label d-block fw-bold">
            Category <span class="text-muted fw-normal">(Up to 3)</span>
          </label>
          @foreach ($all_categories as $category)
            <div class="form-check form-check-inline mb-3">
              <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
              <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>
          @endforeach
          {{-- Error message area --}}
          @error('category')
            <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" class="form-control" name="name">
          </div>
          {{-- Error Message Area --}}
          @error('name')
              <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="artist" class="form-label fw-bold">Artist</label>
            <input type="text" class="form-control" name="artist">
          </div>
          {{-- Error Message Area --}}
          @error('artist')
              <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="10" class="form-control"></textarea>
          </div>
          {{-- Error Message Area --}}
          @error('description')
              <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-3">
            <label for="url" class="form-label fw-bold">URL <span class="text-muted fw-normal">(YouTube, Apple Music, Spotify, Sound Cloud, Band Camp, etc.)</span></label>
            <input type="text" class="form-control" name="url">
          </div>
          {{-- Error Message Area --}}
          @error('url')
              <p class="text-danger small">{{ $message }}</p>
          @enderror

          <div class="mb-5">
            <label for="image" class="form-label fw-bold">Image</label>
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

          <div class="row text-center">
            <div class="col text-end">
              <a href="{{ route('index') }}" class="btn btn-secondary">CANCEL</a>
            </div>
            <div class="col text-start">
              <button type="submit" class="btn btn-outline-primary">CREATE</button>
            </div>
          </div>
          
        </div>
      </form>
    </div>
  </div>
@endsection