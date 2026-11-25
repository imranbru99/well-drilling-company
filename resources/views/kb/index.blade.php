@extends('layouts.app')
@section('title', 'Knowledge Base')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Knowledge Base</h2>
        <p class="lede">Common issues, drill-day guides, admin manual notes, and troubleshooting for Stonebore water well systems.</p>
        @foreach($articles as $category => $items)
            <h3 style="font-family:var(--font-display);text-transform:uppercase;margin:2rem 0 .8rem">{{ str_replace('_',' ', ucfirst($category)) }}</h3>
            <div class="grid-2">
                @foreach($items as $article)
                    <a class="panel" href="{{ route('knowledge.show', $article->slug) }}">
                        <h3>{{ $article->title }}</h3>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection
