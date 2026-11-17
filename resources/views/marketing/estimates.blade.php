@extends('layouts.marketing')

@section('title', 'Estimates & Invoicing — TradeFlow')
@section('meta_description', 'Line-item plumbing and HVAC estimates that convert to invoices with Unicode PDF packs and parts catalog pricing.')

@section('content')
<h1 class="section-title">Estimates &amp; invoicing</h1>
<p style="color:var(--muted);">Quote on the truck, collect deposits, and close out jobs with balance-due tracking.</p>

<h2 class="section-title" style="font-size:1.35rem;">Recent estimates</h2>
<table>
    <thead>
        <tr><th>Number</th><th>Title</th><th>Customer</th><th>Trade</th><th>Status</th><th>Total</th></tr>
    </thead>
    <tbody>
        @forelse($estimates as $estimate)
            <tr>
                <td>{{ $estimate->number }}</td>
                <td>{{ $estimate->title }}</td>
                <td>{{ $estimate->customer?->name }}</td>
                <td>{{ $estimate->trade_type }}</td>
                <td>{{ $estimate->status }}</td>
                <td>${{ number_format((float) $estimate->total, 2) }}</td>
            </tr>
        @empty
            <tr><td colspan="6">No estimates seeded yet.</td></tr>
        @endforelse
    </tbody>
</table>

<h2 class="section-title" style="font-size:1.35rem;">Recent invoices</h2>
<table>
    <thead>
        <tr><th>Number</th><th>Title</th><th>Customer</th><th>Status</th><th>Balance due</th></tr>
    </thead>
    <tbody>
        @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->number }}</td>
                <td>{{ $invoice->title }}</td>
                <td>{{ $invoice->customer?->name }}</td>
                <td>{{ $invoice->status }}</td>
                <td>${{ number_format((float) $invoice->balance_due, 2) }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No invoices seeded yet.</td></tr>
        @endforelse
    </tbody>
</table>

@if($parts->isNotEmpty())
    <h2 class="section-title" style="font-size:1.35rem;">Parts catalog sample</h2>
    <section class="grid">
        @foreach($parts as $part)
            <article class="card">
                <span class="badge">{{ $part->trade_type }}</span>
                <h3>{{ $part->name }}</h3>
                <p>SKU {{ $part->sku }} · ${{ number_format((float) $part->unit_price, 2) }} · stock {{ $part->stock_qty }}</p>
            </article>
        @endforeach
    </section>
@endif
@endsection
