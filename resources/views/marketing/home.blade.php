@extends('layouts.marketing')

@section('title', 'TradeFlow — Plumbing & HVAC Field Service Micro-SaaS')
@section('meta_description', 'Micro-SaaS for plumbing, HVAC, and trades: dispatch, estimates, invoicing, technician apps, and AI assistants built for field service owners.')

@section('content')
<section class="hero">
    <span class="badge">Field service for trades</span>
    <h1>TradeFlow</h1>
    <p>Dispatch, estimates, invoicing, technician apps, and AI assistants — modular micro-SaaS built for plumbing, HVAC, and multi-trade shop owners.</p>
    <div class="cta">
        <a class="btn" href="/admin">Open Admin</a>
        <a class="btn ghost" href="{{ route('demo') }}">Try demo users</a>
    </div>
    <div class="stats">
        <div class="stat"><strong>{{ $openJobs }}</strong><span>Open jobs</span></div>
        <div class="stat"><strong>{{ $estimates }}</strong><span>Estimates</span></div>
        <div class="stat"><strong>{{ $invoices }}</strong><span>Invoices</span></div>
        <div class="stat"><strong>{{ $enabledCount }}</strong><span>Modules on</span></div>
        <div class="stat"><strong>{{ $weeklyHours }}h</strong><span>Weekly hours saved</span></div>
    </div>
</section>

<div class="slate-band">
    <h2>Dark slate ops dashboard</h2>
    <p>Accent <code>#0F172A</code> — built for dispatch desks that live in low-light trucks and late-night emergency callouts.</p>
</div>

<section class="grid">
    @foreach($modules as $module)
        <article class="card">
            <span class="badge {{ ($module['enabled'] ?? false) ? 'on' : 'off' }}">{{ ($module['enabled'] ?? false) ? 'On' : 'Off' }}</span>
            <h3>{{ $module['name'] ?? ($module['key'] ?? 'Module') }}</h3>
            <p>{{ $module['description'] ?? '' }}</p>
        </article>
    @endforeach
</section>

@if($jobs->isNotEmpty())
    <h2 class="section-title">Live dispatch snapshot</h2>
    <table>
        <thead>
            <tr><th>Job</th><th>Customer</th><th>Trade</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->number }} — {{ $job->title }}</td>
                    <td>{{ $job->customer?->name }}</td>
                    <td>{{ $job->trade_type }}</td>
                    <td>{{ $job->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
