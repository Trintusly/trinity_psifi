@extends('layouts.main')
@section('content')
    <title>Home</title>
    <style>
        /* Hero section background with an image */
        .hero.is-primary {
            background: url("{{ asset('images/background.png') }}") center center / cover no-repeat;
            background-color: transparent;
            height: 120vh;
            /* Full height of the viewport */
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(0deg, #00000088 30%);

        }
    </style>
    </head>

    <body>
        <section class="hero is-primary is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column is-12">
                            <div class="container has-text-centered">
                                <h1 class="title is-size-5 has-text-black">
                                    Think bigger. Launch smarter.
                                </h1>
                                <h2 class="subtitle is-size-8 is-size-8-tablet has-text-black">
                                    We empower startups and organizations to plan, collaborate, and
                                    accelerate<br />
                                    growth—together.
                                </h2>
                                <a href="{{route('register')}}" class="button is-black is-large has-text-white">
                                    Get started for free
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
@endsection
