@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">Managing <a href="{{route('startup.view', ['id' => $startup->id])}}">{{ $startup->display_name }}</a></div>
                    <div class="subtitle is-grey is-7">Managing {{ $startup->display_name }} </div>
                    <x-message />

                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Accept</th>
                                <th>Deny</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingRequests as $request)
                                <tr>
                                    <td>{{ $request->user->username }}</td>
                                    <td>
                                        <form
                                            action="{{ route('startup.manage::acceptRequest', ['startupId' => $startup->id, 'requestId' => $request->id]) }}"
                                            method="POST">
                                            @csrf
                                            <select name="role" required>
                                                <option value="OWNER">Owner</option>
                                                <option value="EDITOR">Editor</option>
                                                <option value="VIEWER">Viewer</option>
                                            </select>

                                    </td>
                                    <td>
                                        <button type="submit" class="button is-primary">Accept</button>

                                    </td>
                                    </form>

                                    <td>
                                        <form
                                            action="{{ route('startup.manage::denyRequest', ['startupId' => $startup->id, 'requestId' => $request->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="button is-danger">Deny</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@stop
