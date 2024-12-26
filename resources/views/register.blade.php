@extends('layouts.main')
@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-6-tablet is-5-desktop is-5-widescreen">
                        <div class="box">
                            <div class="is-size-5">Register</div>
                            <div class="is-size-6 has-text-grey-light mb-3">Create your account to get started</div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                {{-- <x-message/> --}}
                                <fieldset>
                                    <div class="field">
                                        <label for="username" class="label">Username</label>
                                        <div class="control has-icons-left">
                                            <input id="username" name="username" type="text" placeholder="Username"
                                                class="input @error('username') is-danger @enderror"
                                                value="{{ old('username') }}">
                                            <span class="icon is-small is-left">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('username'))
                                            <div class="help is-danger">{{ $errors->first('username') }}</div>
                                        @endif
                                    </div>

                                    <div class="field">
                                        <label for="email" class="label">Email</label>
                                        <div class="control has-icons-left">
                                            <input id="email" name="email" type="email" placeholder="Email"
                                                class="input @error('email') is-danger @enderror"
                                                value="{{ old('email') }}">
                                            <span class="icon is-small is-left">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="help is-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="field">
                                        <label for="password" class="label">Password</label>
                                        <div class="control has-icons-left">
                                            <input id="password" name="password" type="password" placeholder="Password"
                                                class="input @error('password') is-danger @enderror">
                                            <span class="icon is-small is-left">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="help is-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>


                                    <div class="field">
                                        <div class="buttons">
                                            <button type="submit" class="button is-info">Register</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <center><a href="{{ route('login') }}">Already have an account? Login</a></center>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
