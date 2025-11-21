<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Demo Laravel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
          rel="stylesheet">
</head>
<body>

<main class="container py-4">
    <div class="card shadow">
        <div class="card-body">
            <h1 class="card-title hstack">
                @hasSection('back')

                    <a href="@yield('back')" class="btn btn-lg btn-link">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                @endif

                @yield('title', 'Demo Laravel')

                @hasSection('headerAppend')

                    @yield('headerAppend')

                @endif
            </h1>

            <hr>

            <div class="card-text">
                @yield('content')
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
<script>
    try {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => alert.remove(), 5 * 1_000);
        });
    } catch (e) {
        console.error(e)
    }
</script>
</body>
</html>
