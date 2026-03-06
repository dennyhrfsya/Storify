<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Denny Herfansya">
    <meta name="description" content="For Storify">
    <title>404 - Not Found</title>
    <link rel="icon" href="{{ asset('images/favicon-16x16.png') }}" type="image/x-icon">

    <!-- Bootstrap Core CSS v5.3 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

    <!-- Link CSS Fortify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-base-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-base-style.css') }}">

    <!-- Link fontGoogles -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700&amp;display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <div class="dx-container justify-content-center align-items-center dx-vh">
            <div class="text-center">
                <img src="{{ asset('images/404_notfound.png') }}" alt="404 not found" class="img-fluid w-75">
                <p class="dx-mt-5">Kembali ke <a href="{{ route('dashboard') }}"
                        class="dx-text-sm dx-font-bold dx-text-biru">Halaman
                        Utama</a></p>
            </div>
        </div>
    </main>
</body>

</html>
