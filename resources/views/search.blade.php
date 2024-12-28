@extends('layouts.main')

@section('content')
    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">Search</div>
                    <div class="subtitle is-grey is-7">Search through Trinity</div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('search') }}">
                        <div class="field">
                            <label class="label">Search For</label>
                            <div class="control">
                                <div class="select">
                                    <select name="type" required>
                                        <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User
                                        </option>
                                        <option value="startup" {{ request('type') === 'startup' ? 'selected' : '' }}>
                                            Startup</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Search Query</label>
                            <div class="control">
                                <input class="input" type="text" name="query" placeholder="Enter search query"
                                    value="{{ request('query') }}" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- Search Results -->
                    @if (isset($results))
                        <div class="box mt-5">
                            <h2 class="title is-5">Search Results for "<strong>{{ $query }}</strong>" in
                                {{ ucfirst($type) }}</h2>
                            @if ($results->isEmpty())
                                <p>No results found.</p>
                            @else
                                <ul>
                                    @foreach ($results as $result)
                                        @if ($type === 'user')
                                            <li>
                                                <a href="{{ route('user.profile', ['username' => $result->username]) }}">
                                                    {{ $result->username }}
                                                </a>
                                            </li>
                                        @elseif($type === 'startup')
                                            <li>
                                                <a href="{{ route('startup.view', ['id' => $result->id]) }}">
                                                    {{ $result->display_name }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
