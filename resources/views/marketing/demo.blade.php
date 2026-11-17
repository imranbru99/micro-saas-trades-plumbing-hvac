@extends('layouts.marketing')

@section('title', 'Demo Access')
@section('meta_description', 'Demo credentials for TradeFlow plumbing/HVAC micro-SaaS admin panel.')

@section('content')
<section class="hero">
    <div class="eyebrow">Demo</div>
    <h1>Explore the dark-slate ops desk</h1>
    <p>Use the seeded demo user to open the Filament admin at <code>/admin</code>.</p>
</section>

<section class="section">
    <div class="card" style="max-width:520px;">
        <h3>Demo login</h3>
        <p style="margin:.6rem 0;"><strong>Email:</strong> {{ $email }}</p>
        <p style="margin:.6rem 0;"><strong>Password:</strong> {{ $password }}</p>
        <div class="cta-row" style="margin-top:1rem;">
            <a class="btn" href="/admin">Open admin</a>
        </div>
    </div>

    <div class="grid" style="margin-top:1.5rem;">
        <div class="card"><h3>Super Admin</h3><p>admin@tradeflow.test</p></div>
        <div class="card"><h3>Dispatch Manager</h3><p>dispatch@tradeflow.test</p></div>
        <div class="card"><h3>Plumbing Tech</h3><p>tech@tradeflow.test</p></div>
        <div class="card"><h3>HVAC Tech</h3><p>hvac@tradeflow.test</p></div>
    </div>
    <p style="color:var(--muted);margin-top:1rem;">All seeded users share password <code>password</code> (or <code>DEMO_USER_PASSWORD</code>).</p>
</section>
@endsection
