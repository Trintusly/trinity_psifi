@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-2">
                    <aside class="menu">
                        <p class="menu-label">Navigate</p>
                        <ul class="menu-list">
                            <li><a href="{{ route('startup.new') }}">New</a></li>
                            <li><a href="{{ route('startup.list') }}" class="is-active">List</a></li>
                            <li><a href="{{ route('user.dashboard') }}">Go back</a></li>
                        </ul>
                    </aside>
                </div>
                <div class="column is-8">
                    <div class="title is-4">Listing startups</div>
                    <div class="subtitle is-grey is-7 mb-3">Listing startups made by you</div>
                    <div class="box">
                        @forelse($startups as $startup)
                            <article class="media is-align-items-center">

                                <!-- User Headshot -->
                                <div class="media-left">
                                    <figure class="image is-64x64">
                                        <img src="{{ asset('images/startups/' . $startup->logo . '.jpg') }}">
                                    </figure>
                                </div>

                                <!-- User Content -->
                                <div class="media-content">
                                    <div class="content">
                                        <div class="title is-6">
                                            <a
                                                href="{{ route('startup.view', ['id' => $startup->id]) }}"><span>{{ $startup->display_name }}</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="media-right">
                                    <a href="{{route('startup.manage', ['id' => $startup->id])}}" class="button is-rounded is-small">Manage</a>
                                </div>

                            </article>
                        @empty
                            <div class="has-text-grey">No startups here...</div>
                        @endforelse
                    </div>
                    <div class="is-flex is-justify-content-center">
                        {{ $startups->links('pagination::bulma') }}
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
