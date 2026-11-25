@extends('layouts.app')
@section('title', 'Well Drilling Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">Stonebore drills and finishes residential, farm, and commercial water wells — plus pumps, hydrofracturing, and water quality testing across Northeast Oklahoma.</p>
        <div class="grid-3">
            @foreach([
                ['residential-wells','Residential Wells','https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80'],
                ['agricultural-wells','Agricultural Wells','https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=1200&q=80'],
                ['commercial-wells','Commercial Wells','https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80'],
                ['pump-systems','Pump Systems','https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1200&q=80'],
                ['hydrofracturing','Hydrofracturing','https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1200&q=80'],
                ['water-testing','Water Testing','https://images.unsplash.com/photo-1582719471384-894fbb16e074?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
