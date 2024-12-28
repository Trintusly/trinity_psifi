@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">{{ $startup->display_name }}</div>
                    <div class="subtitle is-grey is-7">Viewing {{ $startup->display_name }}'s startup profile </div>
                    <x-message />
                    <div class="box">
                        <article class="media">

                            <!-- User Headshot -->
                            <div class="media-left">
                                <figure class="image is-128x128">
                                    <img src="{{ asset('images/startups/' . $startup->logo . '.jpg') }}">
                                </figure>
                            </div>

                            <!-- User Content -->
                            <div class="media-content">
                                <div class="content">
                                    <div class="is-size-5">
                                        <span>{{ $startup->display_name }}</span>
                                    </div>
                                    <div class="is-size-7 has-text-grey-light">
                                        <span class="has-text-truncate"> {{ $startup->description }} </span>
                                    </div>
                                    <br>
                                    <div class="subtitle is-grey is-7 mb-2">Industry:</div>

                                    <div class="tags">
                                        @foreach ($startup->industries as $industry)
                                            <span class="tag is-info">{{ ucwords(trim($industry)) }}</span>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                            <div class="media-right">
                                @if (auth()->check())
                                    @if ($isOwner)
                                        <div class="tag is-primary">Owner</div>
                                    @endif
                                @endif
                            </div>
                        </article>
                    </div>
                    <hr>
                    <div class="columns">
                        <div class="column is-6">
                            <div class="title is-6 mt-2 mb-2">Actions</div>

                            <div class="box">
                                @if (auth()->check())
                                    @if ($isOwner)
                                        <a class="button is-primary is-fullwidth mb-2"
                                            href="{{ route('startup.manage', ['id' => $startup->id]) }}">Manage</a>
                                    @endif
                                    @if ($isMember)
                                        @if ($isPrimaryStartup)
                                            <!-- Button to remove this startup as the primary startup -->
                                            <form
                                                action="{{ route('startup.view::setPrimaryStartup', ['id' => $startup->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="button is-danger is-fullwidth">Remove as
                                                    primary startup</button>
                                            </form>
                                        @else
                                            <!-- Button to set this startup as the primary startup -->
                                            <form
                                                action="{{ route('startup.view::setPrimaryStartup', ['id' => $startup->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="button is-primary is-fullwidth">Set as primary
                                                    startup</button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('startup.view::sendJoinRequest', ['id' => $startup->id]) }}"
                                            method="POST">
                                            @csrf
                                            @if ($hasPendingRequest)
                                                <button type="submit" class="button is-danger is-fullwidth">Cancel Join
                                                    Request</button>
                                            @else
                                                <button type="submit" class="button is-primary is-fullwidth">Send Join
                                                    Request</button>
                                            @endif
                                        </form>

                                    @endif
                                @else
                                    <div class="subtitle is-grey is-7 mb-2">Login or register to interact with this startup.
                                    </div>


                                @endif
                            </div>
                        </div>

                        <div class="column is-6">
                            <div class="title is-6 mt-2 mb-2">Startup Creator</div>

                            <div class="box">
                                <article class="media is-align-items-center">
                                    <!-- User Headshot -->
                                    <div class="media-left">
                                        <figure class="image is-32x32">
                                            <!-- Access the picture of the creator directly -->
                                            <img src="{{ asset('images/users/' . $startup->creator->picture . '.jpg') }}"
                                                alt="User Profile Picture" class="profile-image">
                                        </figure>
                                    </div>

                                    <!-- User Content -->
                                    <div class="media-content">
                                        <div class="content">
                                            <div class="is-size-5">
                                                <a href="{{ route('user.profile', ['username' => $startup->creator->username]) }}"
                                                    class="is-link">
                                                    <span>{{ $startup->creator->username }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

@stop
