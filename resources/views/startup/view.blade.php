@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">{{ $startup->display_name }}</div>
                    <div class="subtitle is-grey is-7">Viewing {{ $startup->display_name }}'s startup profile </div>
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
                                {{-- @if (auth()->check())
                                    @if (auth()->user()->id !== $user->id)
                                        <a class="button is-small is-rounded is-primary"
                                            href="{{ route('user.messages.send', ['username' => $user->username]) }}">Message</a>
                                    @else
                                        <div class="tag is-primary">This is you!</div>
                                    @endif
                                @endif --}}
                            </div>
                        </article>
                    </div>

                </div>
            </div>
        </section>
    </div>

@stop
