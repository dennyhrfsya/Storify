<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="AxD">
    <meta name="description" content="For Storify">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/favicon-16x16.png') }}" type="image/x-icon">

    <!-- Bootstrap Core CSS v5.3 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

    <!-- Link CSS Storify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-base-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-admin-style.css') }}">

    <!-- Link fontGoogles -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Link Bootstrap Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}">

    <!-- Link flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <main>
        <div class="dx-container-adm">
            @include('partials.sidebar')

            <section class="dx-section d-flex flex-column min-vh-100">
                @include('partials.header')

                <div class="dx-content-wrap grow">
                    @yield('content')
                </div>

                @include('partials.footer')
            </section>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="65818a07c709d4a0ee7047e0-|49" defer=""></script>

    <!-- Javascript Customs -->
    @stack('scripts')
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tanggal", {
            disableMobile: "true",
            dateFormat: "d-m-Y"
        });
    </script>

</body>

</html>
