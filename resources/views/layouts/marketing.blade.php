<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TradeFlow — Plumbing & HVAC Micro-SaaS')</title>
    <meta name="description" content="@yield('meta_description', 'Micro-SaaS for plumbing, HVAC, and trades: dispatch, estimates, invoicing, technician apps, and AI assistants built for field service owners.')">
    <meta name="author" content="Imran Ahmed <me@imrandev.bd>">
    <meta name="theme-color" content="#0F172A">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #0F172A;
            --slate: #1e293b;
            --panel: #f1f5f9;
            --ink: #0f172a;
            --muted: #475569;
            --line: #cbd5e1;
            --sky: #38bdf8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 420px at 85% -10%, rgba(56, 189, 248, 0.18), transparent 55%),
                radial-gradient(700px 380px at 0% 20%, rgba(15, 23, 42, 0.08), transparent 50%),
                linear-gradient(165deg, #e2e8f0 0%, #f8fafc 40%, #ffffff 100%);
        }
        a { color: var(--sky); text-decoration: none; }
        .wrap { width: min(1120px, 92%); margin: 0 auto; }
        header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1.2rem 0;
        }
        .brand {
            font-family: 'Outfit', sans-serif;
            font-size: 1.7rem; font-weight: 800;
            color: var(--accent); letter-spacing: -0.02em;
        }
        nav { display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; }
        nav a { color: var(--muted); font-weight: 600; }
        .btn {
            display: inline-block; background: var(--accent); color: #f8fafc !important;
            padding: .75rem 1.15rem; border-radius: .45rem; font-weight: 700;
        }
        .btn.ghost {
            background: transparent; color: var(--accent) !important;
            border: 1px solid var(--line);
        }
        .hero { padding: 3.4rem 0 2.2rem; display: grid; gap: 1rem; max-width: 48rem; }
        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.3rem, 5vw, 3.5rem);
            line-height: 1.05; margin: 0; color: var(--accent);
        }
        .hero p { font-size: 1.12rem; color: var(--muted); margin: 0; max-width: 40rem; }
        .cta { display: flex; gap: .75rem; flex-wrap: wrap; margin-top: .7rem; }
        .stats {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: .75rem; margin: 1.5rem 0 0;
        }
        .stat {
            background: var(--accent); color: #e2e8f0;
            border-radius: .55rem; padding: 1rem 1.1rem;
        }
        .stat strong { display: block; font-family: 'Outfit', sans-serif; font-size: 1.45rem; color: #fff; }
        .stat span { font-size: .85rem; color: #94a3b8; }
        .grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem; padding: 1.5rem 0 3rem;
        }
        .card {
            background: rgba(255,255,255,.92);
            border: 1px solid var(--line);
            border-radius: .65rem; padding: 1.2rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }
        .card h3 { margin: .25rem 0 .45rem; font-size: 1.08rem; font-family: 'Outfit', sans-serif; }
        .card p { margin: 0; color: var(--muted); }
        .badge {
            display: inline-block; font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em;
            color: var(--accent); background: #e2e8f0;
            padding: .2rem .45rem; border-radius: .3rem;
        }
        .badge.on { background: #dbeafe; color: #0369a1; }
        .badge.off { background: #fee2e2; color: #b91c1c; }
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem; color: var(--accent); margin: 2rem 0 .5rem;
        }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0 2rem; }
        th, td { text-align: left; padding: .65rem .5rem; border-bottom: 1px solid var(--line); }
        th { color: var(--muted); font-size: .85rem; text-transform: uppercase; letter-spacing: .04em; }
        footer {
            border-top: 1px solid var(--line);
            padding: 2rem 0; color: var(--muted); font-size: .95rem;
        }
        .slate-band {
            background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%);
            color: #e2e8f0; border-radius: .8rem; padding: 1.5rem 1.6rem; margin: 1.5rem 0;
        }
        .slate-band h2 { font-family: 'Outfit', sans-serif; margin: 0 0 .5rem; color: #fff; }
        .slate-band p { margin: 0; color: #94a3b8; }
        @media (max-width: 720px) {
            header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <header>
        <a class="brand" href="{{ route('home') }}">TradeFlow</a>
        <nav>
            <a href="{{ route('features') }}">Features</a>
            <a href="{{ route('modules') }}">Modules</a>
            <a href="{{ route('dispatch') }}">Dispatch</a>
            <a href="{{ route('estimates') }}">Estimates</a>
            <a href="{{ route('pricing') }}">Pricing</a>
            <a href="{{ route('demo') }}">Demo</a>
            <a class="btn" href="/admin">Admin Login</a>
        </nav>
    </header>
    @yield('content')
    <footer>
        <p><strong>TradeFlow</strong> — Micro-SaaS for plumbing, HVAC &amp; trades by <a href="https://imrandev.bd">Imran Ahmed</a> · <a href="mailto:me@imrandev.bd">me@imrandev.bd</a></p>
        <p>Toggleable dispatch, estimates, invoicing, technician field app, AI assistant, and trade packs.</p>
    </footer>
</div>
</body>
</html>
