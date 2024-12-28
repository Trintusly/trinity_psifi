@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-2">
                    <aside class="menu">
                        <p class="menu-label">Navigate</p>
                        <ul class="menu-list">
                            <li><a href="{{route('startup.new')}}" class="is-active">New</a></li>
                            <li><a href="{{route('startup.list')}}">List</a></li>
                            <li><a href="{{ route('user.dashboard') }}">Go back</a></li>
                        </ul>
                    </aside>
                </div>
                <div class="column is-8">

                    <div class="title is-4">Create new startup</div>
                    <div class="subtitle is-grey is-7 mb-3">Initialise a new startup here</div>
                    <div class="box">

                        <form method="POST" action="{{ route('startup.new::create') }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <!-- Logo Field -->
                                <div class="field">
                                    <label for="logo" class="label">Logo</label>
                                    <div class="control">
                                        <input id="logo" name="logo" type="file"
                                            class="input @error('logo') is-danger @enderror">
                                    </div>
                                    @if ($errors->has('logo'))
                                        <div class="help is-danger">{{ $errors->first('logo') }}</div>
                                    @endif
                                </div>

                                <!-- Display Name Field -->
                                <div class="field">
                                    <label for="display_name" class="label">Display Name</label>
                                    <div class="control">
                                        <input id="display_name" name="display_name" type="text"
                                            placeholder="Enter startup name"
                                            class="input @error('display_name') is-danger @enderror"
                                            value="{{ old('display_name') }}">
                                    </div>
                                    @if ($errors->has('display_name'))
                                        <div class="help is-danger">{{ $errors->first('display_name') }}</div>
                                    @endif
                                </div>

                                <!-- Description Field -->
                                <div class="field">
                                    <label for="description" class="label">Description</label>
                                    <div class="control">
                                        <textarea id="description" name="description" placeholder="Describe your startup"
                                            class="textarea @error('description') is-danger @enderror">{{ old('description') }}</textarea>
                                    </div>
                                    @if ($errors->has('description'))
                                        <div class="help is-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>

                                <!-- Industries Field -->
                                <div class="field">
                                    <label for="industries" class="label">Industries</label>
                                    <div class="control">
                                        <input id="industries" name="industries" type="text"
                                            placeholder="E.g., Tech, Finance"
                                            class="input @error('industries') is-danger @enderror"
                                            value="{{ old('industries') }}">
                                    </div>
                                    @if ($errors->has('industries'))
                                        <div class="help is-danger">{{ $errors->first('industries') }}</div>
                                    @endif
                                </div>

                                <!-- Funding Raised Field -->
                                <div class="field">
                                    <label for="funding_raised" class="label">Funding Raised (in PKR)</label>
                                    <div class="control">
                                        <input id="funding_raised" name="funding_raised" type="number"
                                            placeholder="Amount raised (e.g., 500,000)"
                                            class="input @error('funding_raised') is-danger @enderror"
                                            value="{{ old('funding_raised') }}">
                                    </div>
                                    @if ($errors->has('funding_raised'))
                                        <div class="help is-danger">{{ $errors->first('funding_raised') }}</div>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <div class="field">
                                    <div class="buttons">
                                        <button type="submit" class="button is-primary">Create Startup</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </div>

@stop
