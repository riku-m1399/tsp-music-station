<div class="card-header bg-white py-3">
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
      <div class="dropdown">
        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
          <i class="fa-solid fa-ellipsis"></i>
        </button>

        {{-- If you are the owner of the post, then display the edit and delete --}}
        @if (Auth::user()->id === $post->user->id)
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
        @else
            @if ($post->user->isFollowed())
              <div class="dropdown-menu">
                <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                </form>
              </div>
            @endif
        @endif
      </div>
    </div>
  </div>
</div>