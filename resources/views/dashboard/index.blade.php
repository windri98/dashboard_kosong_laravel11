<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estetik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/stylie.css') }}">
</head>

<body>
    <div class="overlay"></div>
    <div class="container">
        @include('dashboard.partials.sidebar')

        @include('dashboard.partials.header')
        <main class="main">
            @yield('content')
        </main>
        {{-- @include('dashboard.partials.main') --}}

        @include('dashboard.partials.footer')
    </div>

    <!-- Chart.js untuk grafik -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
</body>
</html>
