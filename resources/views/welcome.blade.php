<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Welcome | {{ config('app.name', 'Laravel Project') }}</title>
  <!-- Revised fonts: clean & professional -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    :root{
      --bg-1: #071029;
      --bg-2: #0b1220;
      --accent: #06b6d4; /* teal */
      --accent-2: #6366f1; /* indigo */
      --muted: rgba(255,255,255,0.92);
    }
    html,body{height:100%;}
    body{
      margin:0; font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto;
      background: linear-gradient(180deg,var(--bg-1), var(--bg-2)); color:var(--muted);
      -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }

    /* very subtle decorative shape */
    .shape{position:absolute; inset:0; z-index:0; pointer-events:none;}
    .shape svg{width:120%; height:100%; transform:translateX(-8%); opacity:0.045}

    /* container */
    .card{position:relative; z-index:10; max-width:980px; margin:0 auto; padding:28px; border-radius:16px;}

    /* header */
    .brand{display:flex; gap:16px; align-items:center}
    .logo{width:56px; height:56px; border-radius:12px; object-fit:cover; box-shadow:0 8px 30px rgba(2,6,23,0.6)}
    .title{font-family:'Montserrat',sans-serif; font-weight:700}
    .subtitle{color:rgba(255,255,255,0.85); font-weight:600}

    /* headline */
    .headline{font-size:2.25rem; line-height:1.02; margin:8px 0 6px}
    .headline .accent{background:linear-gradient(90deg,var(--accent-2), var(--accent)); -webkit-background-clip:text; color:transparent}

    /* tagline (catchy description) */
    .tagline{font-size:1.05rem; color:rgba(255,255,255,0.9); max-width:70%}

    /* actions */
    .actions{display:flex; gap:12px; margin-top:18px}
    .btn{padding:10px 16px; border-radius:10px; font-weight:700; cursor:pointer; transition:transform .16s ease, box-shadow .16s ease}
    .btn-primary{background:linear-gradient(90deg,var(--accent-2), var(--accent)); color:white; border:0; box-shadow:0 10px 30px rgba(99,102,241,0.12)}
    .btn-primary:hover{transform:translateY(-5px)}
    .btn-ghost{background:transparent; color:rgba(255,255,255,0.9); border:1px solid rgba(255,255,255,0.06)}

    /* small info row */
    .info-row{display:flex; gap:12px; align-items:center; margin-top:22px; font-size:0.92rem; color:rgba(255,255,255,0.78)}
    .pill{background:rgba(255,255,255,0.04); padding:6px 10px; border-radius:999px; font-weight:600}

    /* layout */
    .grid{display:grid; grid-template-columns:1fr; gap:18px; align-items:center}
    @media(min-width:900px){ .grid{grid-template-columns:1fr 360px} }

    /* right card */
    .panel{background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02)); border-radius:12px; padding:18px; border:1px solid rgba(255,255,255,0.04)}
    .panel h3{font-weight:700; margin-bottom:8px}
    .panel p{font-size:0.95rem; color:rgba(255,255,255,0.82)}

    footer{opacity:0.9; margin-top:28px; text-align:center}
  </style>
</head>
<body>
  <div class="shape" aria-hidden="true">
    <!-- subtle geometric background for a pro look -->
    <svg viewBox="0 0 1200 400" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="g" x1="0%" x2="100%" y1="0%" y2="100%">
          <stop offset="0%" stop-color="#06b6d4" stop-opacity="1" />
          <stop offset="100%" stop-color="#6366f1" stop-opacity="1" />
        </linearGradient>
      </defs>
      <path d="M0,160 C200,80 400,220 600,180 C800,140 1000,260 1200,200 L1200,400 L0,400 Z" fill="url(#g)"/>
    </svg>
  </div>

  <main class="min-h-screen flex items-center justify-center px-6 py-12">
    <section class="card">
      <div class="grid">
        <div>
          <div class="brand">
            <img src="/icon.jpg" alt="logo" class="logo">
            <div>
              <div class="title text-2xl">{{ config('app.name', 'Your Project') }}</div>
              <div class="subtitle text-sm">Professional tools for modern brokerages</div>
            </div>
          </div>

          <h1 class="headline mt-6 font-extrabold">
            <span class="accent">MarginCall Monitor</span>
          </h1>

          <div class="tagline mt-4 flex flex-col items-center">
            <div class="flex flex-wrap gap-2 justify-center mb-3">
              <span class="px-4 py-1 rounded-full bg-gradient-to-r from-cyan-400 to-blue-500 text-white text-sm font-semibold shadow">Real-time alerts</span>
              <span class="px-4 py-1 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 text-white text-sm font-semibold shadow">Consolidated positions</span>
              <span class="px-4 py-1 rounded-full bg-gradient-to-r from-pink-400 to-yellow-400 text-white text-sm font-semibold shadow">Predictive margin forecasting</span>
            </div>
            <div class="font-bold text-lg text-accent-2 mt-1 text-center tracking-wide">Act before it matters. 🚀</div>
          </div>

          <div class="actions">
            @if (Route::has('login'))
              @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
              @else
                <a href="{{ route('login') }}" class="btn btn-primary">Log In</a>
                @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endif
              @endauth
            @endif
          </div>

          <div class="info-row">
            <span class="pill">For Brokers</span>
            <span>Trusted risk monitoring • Minimal setup</span>
          </div>
            
          
        </div>

        <aside class="panel">
          <h3>What you get</h3>
          <p>Live margin call detection, consolidated trader views, customizable alert thresholds, and historical analytics — all in a clean, professional interface designed for speed and reliability.</p>
        </aside>
      </div>
    </section>
    
  </main>
  <footer style="width:100vw;position:fixed;left:0;bottom:0;z-index:100;text-align:center;padding:14px 0;background:#071029;color:rgba(255,255,255,0.96);font-size:1.05rem;letter-spacing:0.02em;box-shadow:0 -2px 16px 0 rgba(7,16,41,0.18);font-family:'Montserrat',sans-serif;">
    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel Project') }}. All rights reserved.
  </footer>
</body>
</html>
