@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">
                        @if ($message->receiver_id == auth()->user()->id)
                            Viewing message sent to you by <a
                                href="{{ route('user.profile', ['username' => $message->sender->username]) }}">{{ $message->sender->username }}</a>
                        @elseif ($message->sender_id == auth()->user()->id)
                            Viewing message sent by you to <a
                                href="{{ route('user.profile', ['username' => $message->receiver->username]) }}">{{ $message->receiver->username }}</a>
                        @endif

                    </div>

                    <div class="subtitle is-grey is-7">

                        {{-- Send a personal message to <a
                            href="{{ route('user.profile', ['username' => $user->username]) }}">{{ $user->username }}</a> --}}
                        @if ($message->receiver_id == auth()->user()->id)
                            Message received
                        @elseif ($message->sender_id == auth()->user()->id)
                            Message sent
                        @endif
                        <strong> {{ Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</strong>
                    </div>
                    <hr>
                    <article class="media">

                        <!-- User Headshot -->
                        <div class="media-left">
                            <figure class="image is-64x64">
                                <img src="{{ asset('images/users/' . ($message->receiver_id == auth()->user()->id ? $message->receiver->picture : $message->sender->picture) . '.jpg') }}"
                                    alt="User Profile Picture" class="profile-image">

                            </figure>
                        </div>

                        <!-- User Content -->
                        <div class="media-content">
                            <div class="box">
                                <div class="content">
                                    @if ($message->is_reply != 0)
                                        <a class="button is-small mb-2 is-rounded"
                                            href="{{ route('user.messages.view', ['id' => $message->reply_to]) }}">This
                                            message is a
                                            reply to
                                            a previous message. View the original
                                            message here.</a>
                                    @endif
                                    <div class="subtitle is-grey is-7 ">Title</div>
                                    <div class="title is-5 mb-5"> {{ $message->title }}</div>

                                    <div class="subtitle is-grey is-7 mt-2">Message body</div>
                                    <div class="title is-5"> {{ $message->body }}</div>
                                </div>
                            </div>
                        </div>
                    </article>


                    <hr>

                    <form method="POST"
                        action="{{ route('user.messages.send', ['username' => $message->sender_id == auth()->id() ? $message->receiver->username : $message->sender->username]) }}">
                        @csrf

                        <!-- Post Body Field -->
                        <div class="field">
                            <div class="control">
                                <div class="subtitle is-grey is-7 mb-4">This is the title of your reply</div>
                                <input name="title" class="input @error('title') is-danger @enderror" type="text"
                                    placeholder="Reply title" value="RE: {{ $message->title }}">

                            </div>
                            @error('body')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Post Body Field -->
                        <div class="field">
                            <div class="control">
                                <div class="subtitle is-grey is-7 mb-4">This is the content of your reply</div>
                                <textarea class="textarea @error('body') is-danger @enderror" name="body" placeholder="Message body"></textarea>
                            </div>
                            @error('body')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="reply_to" value="{{ $message->id }}">


                        <!-- Submit Button -->
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Send</button>
                                @if ($message->receiver_id == auth()->user()->id)
                                    <!-- If the message is received, show the return to received messages button -->
                                    <a href="{{ route('user.messages.list', ['show' => 'received']) }}" class="button">
                                        Return to received messages
                                    </a>
                                @elseif ($message->sender_id == auth()->user()->id)
                                    <!-- If the message is sent, show the return to sent messages button -->
                                    <a href="{{ route('user.messages.list', ['show' => 'sent']) }}" class="button">
                                        Return to sent messages
                                    </a>
                                @endif

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@stop
