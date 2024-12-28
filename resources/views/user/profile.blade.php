@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">{{ $user->username }}'s profile</div>
                    <div class="subtitle is-grey is-7">View what {{ $user->username }} is up to</div>
                    <div class="box">
                        <article class="media is-align-items-center">

                            <!-- User Headshot -->
                            <div class="media-left">
                                <figure class="image is-64x64">
                                    <img src="{{ asset('images/users/' . $user->picture . '.jpg') }}"
                                        alt="User Profile Picture" class="profile-image">
                                </figure>
                            </div>

                            <!-- User Content -->
                            <div class="media-content">
                                <div class="content">
                                    <div class="is-size-5">
                                        <span>{{ $user->username }}</span>
                                    </div>
                                    <div class="is-size-7 has-text-grey-light">
                                        <span class="has-text-truncate">{{ $user->email }}</span>
                                    </div>   
                                </div>
                            </div>

                            <div class="media-right">
                                @if (auth()->check())
                                    @if (auth()->user()->id !== $user->id)
                                        <a class="button is-small is-rounded is-primary"
                                            href="{{ route('user.messages.send', ['username' => $user->username]) }}">Message</a>
                                    @else
                                        <div class="tag is-primary">This is you!</div>
                                    @endif
                                @endif
                            </div>
                        </article>
                    </div>

                    <div class="columns">
                        <div class="column is-6">
                            <div class="box">
                                                                    
                                <strong>Bio:</strong>
                                <div class="is-size-6 has-text-grey">
                                    <span class="has-text-truncate">{{ $user->bio }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
