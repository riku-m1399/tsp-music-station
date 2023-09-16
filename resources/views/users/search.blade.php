@extends('layouts.app')

@section('title', 'Search')
    
@section('content')
    <div class="container mt-4">
      <div class="row justify-content-center">
        <div class="col-5">
          <p class="text-muted h5 mb-4 text-center">Search results for "<span class="fw-bold">{{ $search }}</span>"</p>
          @if ($users->isNotEmpty() || $categories->isNotEmpty())

              @foreach ($categories as $category)
                  <div class="row align-items-center mb-3">
                    <div class="col-auto">
                      <a href="{{ route('category.show', $category->id) }}">
                        <i class="fa-solid fa-magnifying-glass text-secondary icon-md"></i>
                      </a>
                    </div>
                    <div class="col ps-0">
                      <a href="{{ route('category.show', $category->id) }}" class="text-decoration-none text-dark fw-bold">{{ $category->name }}</a>
                    </div>
                  </div>
              @endforeach
              
              @foreach ($users as $user)
                <div class="row align-items-center mb-3">
                  <div class="col-auto">
                    <a href="{{ route('profile.show', $user->id) }}">
                      @if ($user->avatar)
                          <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                      @else
                          <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                      @endif
                    </a>
                  </div>

                  <div class="col ps-0 text-truncate">
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                  </div>

                  <div class="col-auto">
                    @if ($user->id !== Auth::user()->id)
                      @if ($user->isFollowed())
                          <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-secondary fw-bold btn-sm">Following</button>
                          </form>
                      @else
                          <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            
                            <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                          </form>
                      @endif
                    @endif
                    
                  </div>
                </div>
              @endforeach

          @else
              <p class="lead text-muted text-center">No results.</p>
          @endif
        </div>
      </div>
    </div>
@endsection