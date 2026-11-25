@extends('layouts.app')

@section('title', 'Stonebore Well Co.')
@section('meta_description', 'Stonebore Well Co. drills residential, agricultural, and commercial water wells across Tulsa and Northeast Oklahoma — pumps, hydrofracturing, and certified water testing.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>Stonebore<br>Well Co.</h1>
        <p>Reliable groundwater for Oklahoma acreages, farms, and facilities — drilled right, cased clean, and finished with pumps that last.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a site survey</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">View well services</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Well drilling services</h2>
        <p class="lede">From first borehole to pump startup — residential, agricultural, and commercial groundwater systems built for Northeast Oklahoma geology.</p>
        <div class="grid-3">
            @foreach([
                ['residential-wells','Residential Wells','Domestic water wells sized for acreages and rural homes.','https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80'],
                ['agricultural-wells','Agricultural Wells','Livestock, irrigation feed, and ranch supply wells.','https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=1200&q=80'],
                ['commercial-wells','Commercial Wells','Community, industrial, and campus groundwater systems.','https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why Stonebore</h2>
        <p class="lede">Tulsa-area crews who treat aquifer depth, casing integrity, and pump curves as non-negotiable — because wells fail from the borehole out.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Survey-first drilling</h3>
                <p>Every job starts with site access notes, expected yield, and a casing plan matched to local formations — not guesswork.</p>
            </div>
            <div class="panel">
                <h3>Pump-ready finishes</h3>
                <p>Submersible installs, pressure tanks, and control panels sized for real household and livestock demand.</p>
            </div>
            <div class="panel">
                <h3>ERP-run jobs</h3>
                <p>Quotes, drill logs, invoices, and service calls live in one operations stack — fewer dropped balls.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the Stonebore ERP used to schedule rigs, track casing inventory, and close invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>18</strong> Active jobs</div>
                    <div class="metric"><strong>$286k</strong> Pipeline</div>
                    <div class="metric"><strong>14</strong> Surveys booked</div>
                </div>
                <div class="bars">
                    <span style="height:40%"></span><span style="height:65%"></span><span style="height:50%"></span>
                    <span style="height:80%"></span><span style="height:55%"></span><span style="height:90%"></span>
                    <span style="height:70%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Jobs & rig scheduling</li>
                    <li>Casing / pump inventory</li>
                    <li>Invoices & payments</li>
                    <li>AI content + troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the field</h2>
        <p class="lede">Guides and notes for homeowners, ranchers, and facilities managers.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
