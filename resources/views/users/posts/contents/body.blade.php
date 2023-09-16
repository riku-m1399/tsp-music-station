{{-- Clickable image --}}
<a href="{{ route('post.show', $post->id) }}">
  <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
</a>
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
          <a href="{{ route('category.show', $category_post->category_id) }}">
            <div class="badge bg-secondary bg-opacity-50">
              {{$category_post->category->name}}
            </div>
          </a>
      @endforeach
    </div>
  </div>

  {{-- Display the information of the post --}}
  <p class="h5 mt-2">{{ $post->artist }} - {{ $post->name }}</p>
  <p class="fw-light">{{ $post->description }}</p>
  @if ($post->url)
    <a class="small text-decoration-none" href="{{ $post->url }}">Jump to the track</a>
  @endif
  <p class="text-muted small p-0">Posted {{$post->created_at->diffForHumans()}}</p>
  
  {{-- Add comments --}}
  @include('users.posts.contents.comment')
</div>