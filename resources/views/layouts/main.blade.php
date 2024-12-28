<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
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

<style>

</style>

@stack('scripts')

<body>
    <nav class="navbar is-fixed-top has-shadow is-spaced" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ route('home') }}">
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
                <a href="{{ route('home') }}" class="navbar-item">Home</a>
                @if (auth()->check())
                    <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}"
                        class="navbar-item">My
                        Profile</a>
                    <a href="{{ route('user.messages.list') }}" class="navbar-item">
                        Messages
                        @if (($unread = auth()->user()->messagesReceived()->where('read', '0')->count()) > 0)
                            &nbsp;<strong>({{ $unread }})</strong>
                        @endif
                    </a>

                @endif

                {{-- <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">More</a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">About</a>
                        <a class="navbar-item">Contact</a>
                        <hr class="navbar-divider" />
                        <a class="navbar-item">Report an issue</a>
                    </div>
                </div> --}}
            </div>

            <div class="navbar-end">


                @if (auth()->check())
                    <div class="navbar-item has-dropdown is-hoverable">
                        <div class="navbar-item">
                            <a class="navbar-link">

                                {{ auth()->user()->username }}
                                &nbsp;


                                <span class="navbar-headshot  is-hidden-mobile">

                                    <img class="navbar-headshot-image"
                                        src="{{ asset('images/users/' . auth()->user()->picture . '.jpg') }}"
                                        alt="Avatar Render">
                                </span>



                            </a>

                            <div class="navbar-dropdown is-boxed is-right">

                                <span class="navbar-item has-text-grey">
                                    <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->username }}
                                </span>
                                <a class="navbar-item" href="{{ route('user.settings') }}">
                                    <i class="fas fa-cog"></i>
                                    &nbsp;&nbsp;Settings
                                </a>
                                <hr class="navbar-divider">
                                <form id="form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>

                                <a class="navbar-item has-text-danger" href="javascript:void(0)"
                                    onclick="document.getElementById('form').submit()">
                                    <i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Sign Out
                                </a>

                            </div>
                        </div>
                    </div>
                @else
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

    <br><br><br><br>

    @yield('content')
</body>

</html>
