<div class="modal fade" id="delete-post-{{ $post->id }}" tabindex="-1" aria-labelledby="delete-post-{{ $post->id }}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border border-danger">
      <div class="modal-header border-bottom border-danger">
        <h5 class="modal-title text-danger" id="delete-post-{{ $post->id }}Label">Delete Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
        <img src="{{ $post->image }}" class="img-thumbnail">
        <p class="h5 mt-2 text-center">{{ $post->artist }} - {{ $post->name }}</p>
      </div>
      <div class="modal-footer border border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
        <form action="{{ route('post.destroy', $post->id) }}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-outline-danger">DELETE</button>
        </form>
      </div>
    </div>
  </div>
</div>