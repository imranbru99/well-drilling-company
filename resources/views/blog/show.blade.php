@extends('layouts.app')
@section('title', $post->title)
@section('content')
<section class="section">
    <div class="wrap" style="max-width:760px">
        <p style="color:var(--steel)">{{ optional($post->published_at)->format('M j, Y') }}</p>
        <h2>{{ $post->title }}</h2>
        @if($post->cover_image)
            <img src="{{ $post->cover_image }}" alt="" style="width:100%;max-height:420px;object-fit:cover;margin:1rem 0 1.5rem;">
        @endif
        <div class="lede" style="max-width:none">{!! nl2br(e($post->body)) !!}</div>
        <a class="btn btn-dark" href="{{ route('blog') }}">Back to blog</a>
    </div>
</section>
@endsection
