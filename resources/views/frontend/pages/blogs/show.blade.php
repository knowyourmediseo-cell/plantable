@extends('layouts.frontend.app')

@section('title', $blog->title)

@section('content')
<section class="py-16">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <article>
                @if($blog->featured_image)
                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover rounded-xl shadow-lg mb-8">
                @endif

                <div class="mb-6">
                    <h1 class="text-4xl font-bold mb-4">{{ $blog->title }}</h1>
                    <div class="flex items-center gap-6 text-gray-600">
                        <span><i class="far fa-calendar"></i> {{ $blog->published_at->format('M d, Y') }}</span>
                        <span><i class="far fa-user"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                        <span><i class="far fa-folder"></i> {{ $blog->category->name ?? 'Uncategorized' }}</span>
                        <span><i class="far fa-eye"></i> {{ $blog->views }} views</span>
                    </div>
                </div>

                <div class="prose prose-lg max-w-none">
                    {!! $blog->content !!}
                </div>
            </article>

            <!-- Related Posts -->
            @if($relatedBlogs->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold mb-8">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $related)
                    <article class="bg-white rounded-xl shadow-hover overflow-hidden">
                        @if($related->featured_image)
                        <a href="{{ $related->url }}">
                            <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                        </a>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold mb-2">
                                <a href="{{ $related->url }}" class="hover:text-primary">{{ $related->title }}</a>
                            </h3>
                            <span class="text-sm text-gray-600">{{ $related->published_at->format('M d, Y') }}</span>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
