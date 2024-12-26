<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
</head>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const burger = document.getElementById("navbarBurger");
        const menu = document.getElementById("navbarMenu");

        burger.addEventListener("click", () => {
            burger.classList.toggle("is-active");
            menu.classList.toggle("is-active");
        });
    });
</script>

<body>
    <nav class="navbar is-fixed-top has-shadow is-spaced" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="Dashboard.html">
              <img src="{{ asset('images/logo.svg') }}" alt="Logo">

            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" id="navbarBurger">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item">Home</a>
                <a class="navbar-item">Profile</a>
                <a class="navbar-item">Settings</a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">More</a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">About</a>
                        <a class="navbar-item">Contact</a>
                        <hr class="navbar-divider" />
                        <a class="navbar-item">Report an issue</a>
                    </div>
                </div>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a href="{{ route('register') }}" class="button is-primary">
                            <strong>Register</strong>
                        </a>
                        <a href="{{ route('login') }}" class="button is-light">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <br><br><br>

    @yield('content')
</body>

</html>
