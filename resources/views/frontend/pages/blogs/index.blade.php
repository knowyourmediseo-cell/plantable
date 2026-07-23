@extends('layouts.frontend.app')

@section('title', 'Blog')

@section('content')
<!-- Page Header -->
<section class="py-12 bg-gradient-to-r from-primary to-primary-700">
    <div class="container-custom">
        <h1 class="text-4xl font-bold text-white mb-2">Our Blog</h1>
        <p class="text-white/90">Latest news and articles about sustainability</p>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-16">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($blogs as $blog)
            <article class="bg-white rounded-xl shadow-hover overflow-hidden">
                @if($blog->featured_image)
                <a href="{{ $blog->url }}">
                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                </a>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                        <span>{{ $blog->published_at->format('M d, Y') }}</span>
                        <span>{{ $blog->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <h2 class="text-xl font-bold mb-3">
                        <a href="{{ $blog->url }}" class="hover:text-primary">{{ $blog->title }}</a>
                    </h2>
                    <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 150) }}</p>
                    <a href="{{ $blog->url }}" class="text-primary font-medium hover:underline">Read More →</a>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600">No blog posts found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    </div>
</section>
@endsection
