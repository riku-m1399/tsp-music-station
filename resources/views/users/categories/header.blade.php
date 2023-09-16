<div class="row">
  <div class="col-4">
    <i class="fa-solid fa-magnifying-glass text-secondary d-block text-center icon-lg"></i>
  </div>

  <div class="col-8">
    <div class="row mb-3">
      <div class="col-auto">
        <h2 class="display-6 mb-0">{{ $category->name }}</h2>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-auto">
        <strong>{{ $category->categoryPost->count() }}</strong> {{ $category->categoryPost->count() == 1 ? 'Post':'Posts' }}
      </div>

    </div>

  </div>

</div>