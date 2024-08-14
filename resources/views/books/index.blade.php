@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form action="{{route('books.index')}}" method="GET" class="mb-4 flex gap-2 items-center">
        <input type="text" name="title" placeholder="Search by title" value="{{request('title')}}" class="input h-10">
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <button type="submit" class="btn h-10">Search</button>
        <a href="{{route('books.index')}}">Clear</a>
    </form>

    <div class="filter-container mb-4 flex">
      @php
        $filters = [
          '' => 'Latest',
          'popular_last_month' => 'Popular Last Month',
          'popular_last_6months' => 'Popular Last 6 Months',
          'highest_rated_last_month' => 'Highest rated Last Month',
          'highest_rated_last_6months' => 'Highest rated Last 6 Months'
        ];
      @endphp

      @foreach ($filters as $filter => $label)
          <a href="{{ route('books.index', [...request()->query(), 'filter' => $filter]) }}" class="{{ request('filter') === $filter || (request('filter') === null && $filter === '') ? 'filter-item-active' : 'filter-item'}}">{{ $label }}</a>
      @endforeach
      
    </div>

    <ul>
        @forelse($books as $book)
        <li class="mb-4">
            <div class="book-item">
              <div
                class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                  <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title}}</a>
                  <span class="book-author">by {{ $book->author}}</span>
                </div>
                <div>
                  <div class="book-rating">
                    {{ number_format($book->reviews_avg_rating, 1)}}
                  </div>
                  <div class="book-review-count">
                    out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                  </div>
                </div>
              </div>
            </div>
          </li>
        @empty
        <li class="mb-4">
            <div class="empty-book-item">
              <p class="empty-text">No books found</p>
              <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
            </div>
          </li>
        @endforelse
    </ul>
@endsection