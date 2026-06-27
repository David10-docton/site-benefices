<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des bénéfices</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f5f5f0; color: #2c2c2a; }
        nav { background: #fff; border-bottom: 1px solid #e0e0d8; padding: 14px 24px; display: flex; align-items: center; justify-content: space-between; }
        nav .logo { font-size: 15px; font-weight: 500; }
        nav .links { display: flex; gap: 8px; }
        nav .links a { text-decoration: none; color: #5f5e5a; font-size: 13px; padding: 6px 12px; border-radius: 6px; }
        nav .links a:hover { background: #f1efe8; }
        nav .links a.active { color: #185FA5; background: #e6f1fb; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px 16px; }
        .alert-success { background: #e1f5ee; color: #085041; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
    </style>
</head>
<body>
    <nav>
        <span class="logo">Gestion des bénéfices</span>
        <div class="links">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Produits</a>
            <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">Ventes</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        </div>
    </nav>
    <div class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>