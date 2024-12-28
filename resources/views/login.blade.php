@extends('layouts.main')
@section('content')
<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-6-tablet is-5-desktop is-5-widescreen">
                     <div class="box">
                        <div class="is-size-5">Login</div>
                        <div class="is-size-6 has-text-grey-light mb-3">Lets continue from where you left</div>
                        <form method="POST" action="{{ route('login::login') }}">
                            @csrf
                            {{-- <x-message/> --}}
                            <fieldset>
                                <div class="field">
                                    <label for="username" class="label">Username</label>
                                    <div class="control has-icons-left">
                                        <input id="username" name="username" type="text" placeholder="Username" class="input @error('username') is-danger @enderror" value="{{ old('username') }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('username'))
                                        <div class="help is-danger">{{ $errors->first('username') }}</div>
                                    @endif
                                    @if (session('error'))
                                        <div class="help is-danger">{{ session('error') }}</div>
                                    @endif
                                </div>
                                <div class="field">
                                    <label for="password" class="label">Password</label>
                                    <div class="control has-icons-left">
                                        <input id="password" name="password" type="password" placeholder="Password" class="input @error('password') is-danger @enderror">
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
                                        <button type="submit" class="button is-primary">Login</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <center><a href="{{ route('register') }}">No account?</a></center>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
