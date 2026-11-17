@extends('layouts.marketing')

@section('title', 'Modules — TradeFlow Toggle Catalog')
@section('meta_description', 'Toggle TradeFlow modules on or off: dispatch, estimates, invoicing, technician app, AI assistant, plumbing and HVAC packs.')

@section('content')
<h1 class="section-title">Toggleable module catalog</h1>
<p style="color:var(--muted);">Enabled modules currently reclaim about <strong>{{ $weeklyHours }} hours/week</strong> of office + field capacity.</p>

<table>
    <thead>
        <tr>
            <th>Key</th>
            <th>Module</th>
            <th>Category</th>
            <th>Status</th>
            <th>Hrs/wk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modules as $module)
            <tr>
                <td><code>{{ $module['key'] }}</code></td>
                <td>{{ $module['name'] }}</td>
                <td>{{ $module['category'] ?? '—' }}</td>
                <td>
                    <span class="badge {{ ($module['enabled'] ?? false) ? 'on' : 'off' }}">
                        {{ ($module['enabled'] ?? false) ? 'ON' : 'OFF' }}
                    </span>
                </td>
                <td>{{ $module['hours_saved_weekly'] ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="slate-band">
    <h2>Flip modules in Filament</h2>
    <p>Use the Modules resource or <code>.env</code> / <code>config/modules.php</code> flags. Disabled modules hide from navigation and block resource access.</p>
</div>
@endsection
