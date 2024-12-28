@extends('layouts.main')

@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <!-- Settings Header -->
                    <div class="title is-4">Settings</div>
                    <div class="subtitle is-grey is-7">Change and view your account settings here</div>

                    <!-- Display success notification if there is any -->
                    @if (session('success'))
                        <div class="notification is-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display errors if there are any -->
                    @if ($errors->any())
                        <div class="notification is-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Profile Picture and Form for updating -->
                    <div class="box">
                        <article class="media">

                            <!-- User Profile Picture -->
                            <div class="media-left">
                                <figure class="image is-64x64">
                                    <img src="{{ asset('images/users/' . auth()->user()->picture . '.jpg') }}"
                                         alt="User Profile Picture" class="profile-image">
                                </figure>
                            </div>

                            <!-- User Information and Form -->
                            <div class="media-content">
                                <div class="content">
                                    <!-- Display User Information (Username and Email) -->
                                    <div class="is-size-5">
                                        <span>{{ auth()->user()->username }}</span>
                                    </div>
                                    <div class="is-size-7 has-text-grey-light">
                                        <span class="has-text-truncate">{{ auth()->user()->email }}</span>
                                    </div>
                                    <hr class="mb-2">

                                    <!-- Form for updating profile picture -->
                                    <form action="{{ route('user.settings::updatePicture') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="field">
                                            <div class="control">
                                                <!-- Section for updating profile picture -->
                                                <div class="title is-6">Update your picture</div>
                                                <div class="subtitle is-grey is-7 mb-4">
                                                    This picture will be shown on your posts, profile, etc.
                                                </div>
                                                <div class="file is-primary has-name is-fullwidth {{ $errors->has('picture') ? 'is-danger' : '' }}">
                                                    <label class="file-label">
                                                        <!-- File Input for choosing image -->
                                                        <input class="file-input" type="file" name="picture" accept="image/*" required id="fileInput">
                                                        <span class="file-cta">
                                                            <span class="file-icon">
                                                                <i class="fas fa-upload"></i>
                                                            </span>
                                                            <span class="file-label">Choose a picture</span>
                                                        </span>
                                                        <span class="file-name" id="fileName">No picture chosen</span>
                                                    </label>
                                                </div>
                                                
                                                <!-- Display validation error for picture input -->
                                                @if ($errors->has('picture'))
                                                    <p class="help is-danger mt-1">{{ $errors->first('picture') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Submit button for updating profile picture -->
                                        <div class="field">
                                            <div class="control mt-2">
                                                <button type="submit" class="button is-primary is-fullwidth is-rounded">Update</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </article>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
@stop

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener to show the selected file name after choosing a picture
            const fileInput = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');

            fileInput.addEventListener('change', function(event) {
                // Display file name or default message if no file is selected
                if (event.target.files.length > 0) {
                    fileName.textContent = event.target.files[0].name;
                } else {
                    fileName.textContent = 'No picture chosen';
                }
            });
        });
    </script>
@endpush
