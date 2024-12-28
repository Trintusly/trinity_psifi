@extends('layouts.main')

@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <!-- Profile Header -->
                    <div class="title is-4">{{ $user->username }}'s profile</div>
                    <div class="subtitle is-grey is-7">View what {{ $user->username }} is up to</div>

                    <!-- User Info Box -->
                    <div class="box">
                        <article class="media is-align-items-center">

                            <!-- User Profile Picture -->
                            <div class="media-left">
                                <figure class="image is-64x64">
                                    <!-- Display user's profile picture -->
                                    <img src="{{ asset('images/users/' . $user->picture . '.jpg') }}"
                                        alt="User Profile Picture" class="profile-image">
                                </figure>
                            </div>

                            <!-- User Information -->
                            <div class="media-content">
                                <div class="content">
                                    <!-- Display username -->
                                    <div class="is-size-5">
                                        <span>{{ $user->username }}</span>
                                    </div>
                                    <!-- Display email -->
                                    <div class="is-size-7 has-text-grey-light">
                                        <span class="has-text-truncate">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="media-right">
                                @if (auth()->check())
                                    <!-- Check if the user is logged in -->
                                    @if (auth()->user()->id !== $user->id)
                                        <!-- Prevent sending message to oneself -->
                                        <!-- Button to send a message to the user -->
                                        <a class="button is-small is-rounded is-primary"
                                            href="{{ route('user.messages.send', ['username' => $user->username]) }}">Message</a>
                                    @else
                                        <!-- Display tag if the user is viewing their own profile -->
                                        <div class="tag is-primary">This is you!</div>
                                    @endif
                                @endif
                            </div>
                        </article>
                    </div>

                    <!-- Bio Section -->
                    <div class="columns">
                        <div class="column is-6">
                            <div class="title is-6 mb-2">Bio</div>

                            <!-- Display Bio -->
                            {{ $user->bio }}

                        </div>
                        <div class="column is-6">
                            <div class="title is-6 mt-2 mb-2">Primary Startup</div>

                            @if (!$primaryStartup)
                                This user has their primary startup unset.
                            @else
                                <div class="box p-2">
                                    <article class="media is-align-items-center">

                                        <!-- User Headshot -->
                                        <div class="media-left">
                                            <figure class="image is-64x64">
                                                <img src="{{ asset('images/startups/' . $primaryStartup->logo . '.jpg') }}"
                                                    alt="User Profile Picture" class="profile-image">
                                            </figure>
                                        </div>

                                        <!-- User Content -->
                                        <div class="media-content">
                                            <div class="content">
                                                <div class="is-size-5">
                                                    <a href="{{ route('startup.view', ['id' => $primaryStartup->id]) }}"
                                                        class="is-link">
                                                        <span>{{ $primaryStartup->display_name }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
