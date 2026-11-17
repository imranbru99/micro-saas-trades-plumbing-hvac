@extends('layouts.marketing')

@section('title', 'Dispatch Board — TradeFlow')
@section('meta_description', 'Same-day plumbing and HVAC dispatch board with technician assignment, priority, ETA, and job status.')

@section('content')
<h1 class="section-title">Dispatch board preview</h1>
<p style="color:var(--muted);">Live demo jobs from the seeded TradeFlow shop — emergency plumbing, HVAC cooler calls, and scheduled tune-ups.</p>

<table>
    <thead>
        <tr>
            <th>Number</th>
            <th>Title</th>
            <th>Customer</th>
            <th>Trade</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Technician</th>
            <th>ETA</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jobs as $job)
            <tr>
                <td>{{ $job->number }}</td>
                <td>{{ $job->title }}</td>
                <td>{{ $job->customer?->name }}</td>
                <td>{{ $job->trade_type }}</td>
                <td>{{ $job->priority }}</td>
                <td>{{ $job->status }}</td>
                <td>{{ $job->technician?->name ?? '—' }}</td>
                <td>{{ optional($job->eta_at)->format('M j, H:i') ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="8">No jobs yet — run <code>php artisan db:seed</code>.</td></tr>
        @endforelse
    </tbody>
</table>

<a class="btn" href="/admin">Manage dispatch in admin</a>
@endsection
