@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">View Messages</div>
                    <div class="subtitle is-grey is-7">
                        Viewing {{ $show === 'sent' ? 'sent' : 'received' }} messages
                    </div>
                    <div class="tabs is-toggle is-centered is-small is-toggle-rounded">
                        <ul>
                            <li class="{{ $show === 'received' ? 'is-active' : '' }}">
                                <a href="{{ route('user.messages.list', ['show' => 'received']) }}">
                                    Received
                                    @if ($unread > 0)
                                        &nbsp;({{ $unread }})
                                    @endif
                                </a>
                            </li>
                            <li class="{{ $show === 'sent' ? 'is-active' : '' }}">
                                <a href="{{ route('user.messages.list', ['show' => 'sent']) }}">Sent</a>
                            </li>
                        </ul>
                    </div>


                    <div class="box">
                        @if ($messages->isEmpty())
                            <p>No {{ $show }} messages available.</p>
                        @else
                            @foreach ($messages as $message)
                                <article class="media is-align-items-center">

                                    <!-- User Headshot -->
                                    <div class="media-left">
                                        <figure class="image is-32x32">
                                            <img src="{{ asset('images/users/' . ($message->receiver_id == auth()->user()->id ? $message->receiver->picture : $message->sender->picture) . '.jpg') }}"
                                                alt="User Profile Picture" class="profile-image">

                                        </figure>
                                    </div>

                                    <!-- User Content -->
                                    <div class="media-content">
                                        <div class="is-size-7">
                                            @if ($message->receiver_id == auth()->user()->id && $message->read == 0)
                                                <span class="tag is-danger is-small">Unread by you</span>
                                            @elseif ($message->receiver_id == auth()->user()->id && $message->read == 1)
                                                <span class="tag is-success is-small">Read by you</span>
                                            @elseif ($message->read == 0)
                                                <span class="tag is-danger is-small">Unread</span>
                                            @else
                                                <span class="tag is-success is-small">Read</span>
                                            @endif

                                            Message
                                            {{ $message->receiver_id == auth()->user()->id ? 'sent to you by' : 'sent by you to' }}
                                            <a
                                                href="{{ route('user.profile', ['username' => $message->receiver_id == auth()->user()->id ? $message->sender->username : $message->receiver->username]) }}">
                                                {{ $message->receiver_id == auth()->user()->id ? $message->sender->username : $message->receiver->username }}
                                            </a>
                                        </div>

                                        <div class="title is-5 mb-5">


                                            <a href="{{ route('user.messages.view', ['id' => $message->id]) }}">
                                                {{ $message->title }}</a>
                                        </div>

                                    </div>

                                    <div class="media-left">
                                        <div class="is-size-7">
                                            @if ($message->receiver_id == auth()->user()->id)
                                                Message received
                                            @elseif ($message->sender_id == auth()->user()->id)
                                                Message sent
                                            @endif
                                            <strong>
                                                {{ Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</strong>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                    <div class="is-flex is-justify-content-center">
                        {{ $messages->links('pagination::bulma') }}
                    </div>
                </div>

            </div>
        </section>
    </div>

@stop
