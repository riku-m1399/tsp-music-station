@extends('layouts.app')

@section('content')
<div class="container w-75 mt-5">
    <div class="row justify-content-center gx-5">
        <div class="col-md-8">
            @forelse ($home_posts as $post)
                <div class="card mb-4">
                    {{-- Insert Title --}}
                    @include('users.posts.contents.title')
                    {{-- Insert Body --}}
                    @include('users.posts.contents.body')
                </div>
            @empty
                <div class="text-center">
                    <h2>Share Music</h2>
                    <p class="text-muted">When you share music they'll appear on your profile.</p>
                    <a href="{{ route('post.create') }}" class="text-decolation-none">Share Your First Music</a>
                </div>
            @endforelse
        </div>
        <div class="col-4">
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3 mt-1">
                <div class="col-auto">
                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col ps-0">
                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="row mb-3">
                    <div class="col-auto">
                        <h5>Categories</h5>
                    </div>
                    {{-- <div class="col text-end ">
                        <a href="" class="text-decoration-none text">View all categories</a>
                    </div> --}}
                </div>
                
                @foreach ($all_categories as $category)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <a href="{{ route('category.show', $category->id) }}">
                                <i class="fa-solid fa-magnifying-glass text-secondary icon-sm"></i>
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('category.show', $category->id) }}" class="text-decoration-none text-dark fw-bold">{{ $category->name }}</a>
                        </div>
                        <div class="col-auto text-end text-muted">
                            {{ $category->categoryPost->count() }} posts
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
