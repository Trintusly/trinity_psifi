@extends('layouts.main')

@section('content')

    <div class="container">
        <section class="section">
            <div class="columns">
                <div class="column is-4">
                    <div class="box">
                        <article class="media is-align-items-center">

                            <!-- User Headshot -->
                            <div class="media-left">
                                <figure class="image is-64x64">
                                </figure>
                            </div>

                            <!-- User Content -->
                            <div class="media-content">
                                <div class="content">
                                    <div class="is-size-5">
                                        <a class="is-link">
                                            <span>{{ auth()->user()->username }}</span>
                                        </a>
                                    </div>
                                    <div class="is-size-7 has-text-grey-light">
                                        <span class="has-text-truncate">Welcome back!</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin and Online Status -->
                            <div class="media-right is-hidden-mobile">


                            </div>

                        </article>
                        <hr>
                        <div class="title is-5">Bio</div>
                        <div class="subtitle is-grey is-7 mb-2">What's on your mind?</div>
                        <form action="{{ route('user.dashboard::updateBio') }}" method="post">
                            @csrf
                            {{-- <x-message /> --}}

                            <!-- Bio Field -->
                            <div class="field">
                                <div class="control">
                                    <textarea name="bio" class="textarea @error('bio') is-danger @enderror" placeholder="Write your message here..."
                                        maxlength="256">{{ auth()->user()->bio }}</textarea>
                                </div>
                                @error('bio')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-primary">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="column is-8">

                    <div class="columns">

                        <div class="column is-10">

                            <div class="is-size-5">
                                Make a post
                            </div>
                            <div class="is-size-7 has-text-grey-light mb-2">
                                Tell the world something!
                            </div>
                            <form method="POST" action="{{ route('user.dashboard::makePost') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Body Field -->
                                <div class="field">
                                    <div class="control">
                                        <textarea class="textarea @error('body') is-danger @enderror" name="body"
                                            placeholder="What's up, {{ auth()->user()->username }}?"></textarea>
                                    </div>
                                    @error('body')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Image Field -->
                                <div class="field">
                                    <div class="control">
                                        <div class="file">
                                            <label class="file-label">
                                                <input class="file-input @error('image') is-danger @enderror" type="file"
                                                    name="image" />
                                                <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                    </span>
                                                    <span class="file-label">Add an image</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('image')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="field">
                                    <div class="control">
                                        <button class="button is-primary" type="submit">Post</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="column is-2">

                            <div class="is-size-5">
                                BBCode
                            </div>
                            <div class="is-size-7 has-text-grey-light mb-2">
                                Formatting rules
                            </div>
                            <ul class="is-small">
                                <li class="is-size-7 mb-1"><strong>[b]</strong> Bold</li>
                                <li class="is-size-7 mb-1"><strong>[i]</strong> Italic</li>
                                <li class="is-size-7 mb-1"><strong>[u]</strong> Underline</li>
                                <li class="is-size-7 mb-1"><strong>[url]</strong> Link</li>
                                <li class="is-size-7 mb-3"><strong>[quote]</strong> Quote</li>
                            </ul>
                            <p class="is-size-7">Example: <code>[b]Bold[/b]</code> is <strong>Bold</strong></p>
                        </div>


                    </div>
                    <hr>


                    @forelse($posts as $p)
                        <div>
                            <div class="box mb-3">
                                <article class="media">
                                    <figure class="media-left">
                                        <p class="image is-32x32">
                                            {{-- <img src="{{ $q->user->thumbnail_url }}" /> --}}
                                        </p>
                                    </figure>
                                    <div class="media-content">
                                        <div class="content">
                                            <div class="title is-6 mb-1">{{ $p->user->username }}</div>
                                            {{-- <div class="help is-grey m-0">x</div> --}}
                                            <p>{!! nl2br(\App\Models\Post::parseBBCode($p->body)) !!}</p>
                                        </div>
                                        <hr class="mt-1 mb-2">
                                        <a href="{{route('post.view', ['id' => $p->id])}}" class="button is-small is-rounded">View Discussion</a>
                                        <a href="#" class="button is-small is-rounded is-danger">
                                            Like
                                        </a>
                                        <a href="#" class="button is-small is-rounded is-link">
                                            Share
                                        </a>

                                    </div>
                                    <!-- Admin and Online Status -->
                                    <div class="media-right is-hidden-mobile">

                                        <span
                                            class="subtitle is-7">{{ Carbon\Carbon::parse($p->created_at)->diffForHumans() }}</span>
                                    </div>
                                </article>
                            </div>
                        </div>
                    @empty
                        <div class="has-text-grey">No posts here...</div>
                    @endforelse


                    <div class="is-flex is-justify-content-center">
                        {{ $posts->links('pagination::bulma') }}
                    </div>


                </div>



            </div>


    </div>
    </section>
    </div>

@stop
