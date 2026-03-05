<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maison Dune - Sign In</title>


    <link rel="stylesheet" href="http://maison.test/wp-content/themes/maison_dune/style.css">
    <style>
        /* CSS PLANO - SIN ANIDACIÓN PARA EVITAR ERRORES */
        body.login-page {
            background-color: #000 !important;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }

        section.login-section {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            min-height: 100vh !important;
            background: url('http://maison.test/wp-content/themes/maison_dune/assets/img/grain.png') !important;
        }

        .login-box {
            background: rgba(32, 32, 32, 0.8) !important;
            padding: 40px !important;
            border: 1px solid rgba(255, 207, 123, 0.2) !important;
            width: 100% !important;
            max-width: 450px !important;
            text-align: center !important;
        }

        .login-box h1 {
            color: rgb(255, 207, 123) !important;
            font-family: 'Playfair Display', serif !important;
            font-size: 2.5rem !important;
            margin-bottom: 20px !important;
        }

        .login-box input {
            width: 100% !important;
            background: transparent !important;
            border: 1px solid rgba(255, 207, 123, 0.3) !important;
            color: white !important;
            padding: 12px !important;
            margin-bottom: 15px !important;
        }

        .login-box button {
            background: rgb(99, 0, 0) !important;
            color: rgb(255, 207, 123) !important;
            width: 100% !important;
            padding: 15px !important;
            border: none !important;
            text-transform: uppercase !important;
            letter-spacing: 2px !important;
            cursor: pointer !important;
        }
    </style>
</head>

<body class="login">

    <header>
        <nav>
            <ul>
                <li><a href="http://maison.test/rooms-suites">Rooms & Suites</a></li>
                <li><a href="http://maison.test/restaurant">Restaurant</a></li>

                <li class="logo">
                    <a href="http://maison.test" title="Maison Dune - Home">
                        <span class="screen-reader-text">Home</span>
                    </a>
                </li>

                <li><a href="http://maison.test/events">Events</a></li>
                <li><a href="http://maison.test/contact">Contact</a></li>

                <li class="login-icon">
                    <a href="{{ route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

</body>

</html>
