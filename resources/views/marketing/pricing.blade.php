@extends('layouts.marketing')

@section('title', 'Pricing — TradeFlow for Trades Shops')
@section('meta_description', 'TradeFlow pricing framed for solo plumbers, HVAC crews, and multi-trade shops. Modular modules mean you only pay for what you run.')

@section('content')
<h1 class="section-title">Pricing that matches shop size</h1>
<p style="color:var(--muted);">{{ $enabledCount }} of {{ $moduleCount }} modules enabled · ~{{ $weeklyHours }} hrs/week saved · ~${{ number_format($weeklyValue) }}/week capacity value at $55/hr.</p>

<section class="grid">
    <article class="card">
        <span class="badge">Solo / truck</span>
        <h3>Starter</h3>
        <p>Dispatch + estimates + technician tasks for a 1–3 tech plumbing or HVAC shop. Turn off multi-trade packs you do not need.</p>
    </article>
    <article class="card">
        <span class="badge on">Most shops</span>
        <h3>Crew</h3>
        <p>Full dispatch board, invoicing, parts catalog, Unicode PDFs, and AI SMS/diagnose assists for growing service companies.</p>
    </article>
    <article class="card">
        <span class="badge">Multi-branch</span>
        <h3>Enterprise</h3>
        <p>Attendance hub bridge, multi-trade packs, module governance for Super Admins, and white-label ops dashboard.</p>
    </article>
</section>

<div class="slate-band">
    <h2>ROI first</h2>
    <p>If TradeFlow returns even half of {{ $weeklyHours }} claimed weekly hours, most shops cover software cost in the first emergency call avoided or invoice closed faster.</p>
</div>

<a class="btn" href="{{ route('demo') }}">Start with demo credentials</a>
@endsection
