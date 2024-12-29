<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <!-- External CSS Libraries -->
    <link rel="stylesheet" href="https://vis.kqpa.me/style/bulma.light.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<script>
    // JavaScript to toggle the navbar burger (menu) on small screens
    document.addEventListener("DOMContentLoaded", () => {
        const burger = document.getElementById("navbarBurger");
        const menu = document.getElementById("navbarMenu");

        // Toggle the 'is-active' class on the burger and menu to show/hide the menu
        burger.addEventListener("click", () => {
            burger.classList.toggle("is-active");
            menu.classList.toggle("is-active");
        });
    });
</script>

@stack('scripts') <!-- Stack for any additional scripts pushed from child views -->

<body>
    <!-- Navbar -->
    <nav class="navbar is-fixed-top has-shadow is-spaced" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <!-- Logo Link -->
            <a class="navbar-item" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo">
            </a>

            <!-- Navbar Burger (for mobile view) -->
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" id="navbarBurger">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-start">
                <!-- Navigation Links -->
                <a href="{{ route('home') }}" class="navbar-item">Home</a>
                <a href="{{ route('feed') }}" class="navbar-item">Feed</a>
                <a href="{{ route('search') }}" class="navbar-item">Search</a>

                @if (auth()->check())
                    <!-- Check if the user is logged in -->
                    <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}"
                        class="navbar-item">My Profile</a>
                    <a href="{{ route('user.messages.list') }}" class="navbar-item">
                        Messages
                        @if (($unread = auth()->user()->messagesReceived()->where('read', '0')->count()) > 0)
                            &nbsp;<strong>({{ $unread }})</strong>
                        @endif
                    </a>
                @endif
            </div>

            <div class="navbar-end">
                @if (auth()->check())
                    <!-- Logged-in user menu -->
                    <div class="navbar-item has-dropdown is-hoverable">
                        <div class="navbar-item">
                            <a class="navbar-link">
                                <!-- Display username and profile image -->
                                {{ auth()->user()->username }}
                                &nbsp;
                                <span class="navbar-headshot is-hidden-mobile">
                                    <img class="navbar-headshot-image"
                                        src="{{ asset('images/users/' . auth()->user()->picture . '.jpg') }}"
                                        alt="Avatar Render">
                                </span>
                            </a>

                            <!-- User Dropdown Menu -->
                            <div class="navbar-dropdown is-boxed is-right">
                                <span class="navbar-item has-text-grey">
                                    <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->username }}
                                </span>
                                <a class="navbar-item" href="{{ route('user.settings') }}">
                                    <i class="fas fa-cog"></i>&nbsp;&nbsp;Settings
                                </a>
                                <hr class="navbar-divider">
                                <form id="form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>

                                <!-- Logout Option -->
                                <a class="navbar-item has-text-danger" href="javascript:void(0)"
                                    onclick="document.getElementById('form').submit()">
                                    <i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- If user is not logged in -->
                    <div class="navbar-item">
                        <div class="buttons">
                            <a href="{{ route('register') }}" class="button is-primary">
                                <strong>Register</strong>
                            </a>
                            <a href="{{ route('login') }}" class="button is-light">Login</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Spacer to account for fixed navbar -->
    <br><br><br><br>

    <!-- Main Content Area -->
    @yield('content')
    <footer class="footer">
        <div class="container">
            <div class="columns is-vcentered is-multiline">
                <div class="column is-one-third">
                    <img src="{{ asset('images/logo.svg') }}" class="image is-128x128" alt="Logo" />
                    <p class="has-text-grey">
                        Empowering startups to collaborate, innovate, and grow smarter
                        with the tools they need.
                    </p>
                </div>

                <!-- Quick Links Section -->
                <div class="column is-one-third">
                    <h3 class="title is-size-5 has-text-black">Quick Links</h3>
                    <ul>
                        <li><a href="#features" class="has-text-grey">Features</a></li>
                        <li><a href="#pricing" class="has-text-grey">Pricing</a></li>
                        <li><a href="#about" class="has-text-grey">About</a></li>
                        <li><a href="#contact" class="has-text-grey">Contact</a></li>
                    </ul>
                </div>

                <!-- Social Media Section -->
                <div class="column is-one-third">
                    <h3 class="title is-size-5 has-text-black">Follow Us</h3>
                    <div class="buttons are-small">
                        <a href="https://facebook.com" target="_blank" class="button is-link">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="button is-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="button is-link">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Text outside the container -->
        <div class="has-text-centered">
            <p class="is-size-7 has-text-grey">
                &copy; 2024 Trinity. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>
