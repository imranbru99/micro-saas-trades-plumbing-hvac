@extends('layouts.marketing')

@section('title', 'Features — TradeFlow Plumbing & HVAC SaaS')
@section('meta_description', 'Explore TradeFlow features: dispatch board, estimates, invoicing, technician field app, AI diagnose helpers, and plumbing/HVAC trade packs.')

@section('content')
<h1 class="section-title">Everything a trades shop needs</h1>
<p style="color:var(--muted);max-width:42rem;">From emergency burst-pipe callouts to seasonal HVAC tune-ups — TradeFlow covers office, truck, and customer touchpoints with toggleable modules.</p>

@foreach($modules as $category => $items)
    <h2 class="section-title" style="font-size:1.45rem;">{{ strtoupper($category) }}</h2>
    <section class="grid">
        @foreach($items as $module)
            <article class="card">
                <span class="badge {{ ($module['enabled'] ?? false) ? 'on' : 'off' }}">{{ ($module['enabled'] ?? false) ? 'Enabled' : 'Disabled' }}</span>
                <h3>{{ $module['name'] }}</h3>
                <p>{{ $module['description'] }}</p>
                <p style="margin-top:.6rem;font-size:.9rem;color:var(--muted);">~{{ $module['hours_saved_weekly'] ?? 0 }} hrs/week saved when on</p>
            </article>
        @endforeach
    </section>
@endforeach
@endsection
