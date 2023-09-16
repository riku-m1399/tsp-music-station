@extends('layouts.app')

@section('title', 'Show Post')
    
@section('content')
<style>
  .col-4{
    overflow-y: scroll;
  }

  .card-body{
    position: absolute;
    top: 65px;
  }
</style>
<div class="container justify-content-center w-75 mt-5">
  <div class="row border shadow">
    <div class="col p-0 border-end">
      <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </div>
    <div class="col-4 px-0 bg-white">
      <div class="card border-0">
        <div class="card-header py-3 bg-white">
          <div class="row align-items-center">
            <div class="col-auto">
              <a href="{{ route('profile.show', $post->user->id) }}">
                @if ($post->user->avatar)
                  <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
                @else
                  <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                @endif
              </a>
            </div>
            <div class="col ps-0">
              <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-secondary">{{ $post->user->name }}</a>
            </div>
            <div class="col-auto">
              {{-- If you are OWNER of the post, you can edit or delete the post --}}
              @if (Auth::user()->id === $post->user->id)
                <div class="dropdown">
                  <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                  </button>
                  <div class="dropdown-menu">
                  <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </a>
                  <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                    <i class="fa-regular fa-trash-can"></i> Delete
                  </button>
                </div>
                {{-- Insert a modal --}}
                @include('users.posts.contents.modals.delete')
              @endif
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row align-items-center">

              {{-- Like --}}
              <div class="col-auto">
                @if ($post->isLiked())
                    <form action="{{ route('like.destroy', $post->id) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-solid fa-heart text-danger"></i>
                      </button>
                    </form>
                @else
                    <form action="{{ route('like.store', $post->id) }}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
                    </form>
                @endif
              </div>
              <div class="col-auto">
                <span>{{ $post->likes->count() }}</span>
              </div>
            
            {{-- Categories --}}
            <div class="col text-end">
              @foreach ($post->categoryPost as $category_post)
                  <div class="badge bg-secondary bg-opacity-50">
                    {{$category_post->category->name}}
                  </div>
              @endforeach
            </div>
          </div>
          <div class="row">
            {{-- Display the information of the post --}}
            <p class="h5 mt-2">{{ $post->artist }} - {{ $post->name }}</p>
            <p class="fw-light">{{ $post->description }}</p>
            @if ($post->url)
              <a class="small text-decoration-none" href="{{ $post->url }}">Jump to the track</a>
            @endif
            <p class="text-muted small">Posted {{$post->created_at->diffForHumans()}}</p>
          </div>

          {{-- Add comments --}}
          <div class="mt-4">
            <form action="{{ route('comment.store', $post->id) }}" method="post">
              @csrf
              <div class="input-group">
                <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
                <button type="submit" class="btn btn-outline-secondary btm-sm">Post</button>
              </div>
              {{-- Error --}}
              @error('comment.body' . $post->id)
                <div class="text-danger small">{{ $message }}</div>
              @enderror
            </form>
          </div>

          {{-- Show all comments here --}}
          @if ($post->comments->isNotEmpty())
              <ul class="list-group mt-2">
                @foreach ($post->comments as $comment)
                    <li class="list-group-item border-0 p-0 mb-2">
                      <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                      &nbsp;
                      <p class="d-inline fw-light">{{ $comment->body }}</p>
                    
                      <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <span class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                        @if (Auth::user()->id === $comment->user->id)
                            &middot;
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                        @endif
                      </form>
                    </li>
                @endforeach
              </ul>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection