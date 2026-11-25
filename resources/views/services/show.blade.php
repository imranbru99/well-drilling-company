@extends('layouts.app')
@section('title', $service['title'])
@section('content')
<section class="hero" style="min-height:52vh;background:linear-gradient(105deg,rgba(12,18,25,.88),rgba(12,18,25,.35)),url('{{ $service['image'] }}') center/cover no-repeat;">
    <div class="wrap hero-inner">
        <h1>{{ $service['title'] }}</h1>
        <p>{{ $service['summary'] }}</p>
        <a class="btn btn-primary" href="{{ route('contact') }}">Request this service</a>
    </div>
</section>
<section class="section">
    <div class="wrap grid-2">
        <div>
            <h2>Scope</h2>
            <p class="lede">{{ $service['body'] }}</p>
            <a class="btn btn-dark" href="{{ route('services') }}">All services</a>
        </div>
        <div class="panel">
            <h3>Related services</h3>
            <ul style="line-height:1.9;padding-left:1.1rem">
                @foreach($services as $key => $item)
                    @if($key !== $slug)
                        <li><a href="{{ route('services.show', $key) }}">{{ $item['title'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endsection
