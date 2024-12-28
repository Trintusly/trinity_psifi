@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">Send message to {{ $user->username }}</div>
                    <div class="subtitle is-grey is-7">Send a personal message to <a
                            href="{{ route('user.profile', ['username' => $user->username]) }}">{{ $user->username }}</a>
                    </div>
                    <hr>

                    <form method="POST" action="{{ route('user.messages.send::send', ['username' => $user->username]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Post Body Field -->
                        <div class="field">
                            <div class="control">
                                <div class="subtitle is-grey is-7 mb-4">This is the title of your message</div>
                                <input name="title" class="input @error('title') is-danger @enderror" type="text"
                                    placeholder="Message title">

                            </div>
                            @error('body')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Post Body Field -->
                        <div class="field">
                            <div class="control">
                                <div class="subtitle is-grey is-7 mb-4">This is the content of your message</div>
                                <textarea class="textarea @error('body') is-danger @enderror" name="body" placeholder="Message body"></textarea>
                            </div>
                            @error('body')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Submit Button -->
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Send</button>
                                <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="button">Return
                                    to profile</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@stop
