@extends('layouts.app')
@section('title', $article->title)
@section('content')
<section class="section">
    <div class="wrap" style="max-width:760px">
        <p style="color:var(--steel);text-transform:uppercase;letter-spacing:.06em;font-size:.8rem">{{ $article->category }}</p>
        <h2>{{ $article->title }}</h2>
        <div class="lede" style="max-width:none">{!! nl2br(e($article->body)) !!}</div>
        <a class="btn btn-dark" href="{{ route('knowledge') }}">Back to knowledge base</a>
    </div>
</section>
@endsection
