@extends('layouts.main')

@section('content')
    <div class="container">
        <section class="section">
            <div class="columns">
                <!-- User Panel -->
                <div class="column is-4">
                    <div class="box">
                        <article class="media is-align-items-center">

                            <!-- User Headshot -->
                            <div class="media-left">
                                <figure class="image is-64x64">
                                    <img src="{{ asset('images/users/' . auth()->user()->picture . '.jpg') }}"
                                        alt="User Profile Picture" class="profile-image">
                                </figure>
                            </div>

                            <!-- User Content -->
                            <div class="media-content">
                                <div class="content">
                                    <div class="is-size-5">
                                        <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}"
                                            class="is-link">
                                            <span>{{ auth()->user()->username }}</span>
                                        </a>
                                    </div>
                                    <div class="is-size-7 has-text-grey-light">
                                        <span class="has-text-truncate">Welcome back!</span>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <hr>

                        <!-- Bio Section -->
                        <div class="title is-5">Bio</div>
                        <div class="subtitle is-grey is-7 mb-2">What's on your mind?</div>
                        <form action="{{ route('user.dashboard::updateBio') }}" method="post">
                            @csrf

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

                    <!-- Startup Panel -->
                    <div class="box startup-box">
                        <div class="title is-5 has-text-white">Startup Panel</div>
                        <div class="subtitle has-text-white is-7 mb-5">Manage your startups</div>
                        <div class="columns mb-2">
                            <div class="column">
                                <a href="{{ route('startup.new') }}"
                                    class="button is-primary is-rounded is-fullwidth">New</a>
                            </div>
                            <div class="column">
                                <a href="{{ route('user.startup.manage') }}"
                                    class="button is-light is-rounded is-fullwidth">Manage</a>
                            </div>
                        </div>

                        <hr class="m-2">
                        <div class="subtitle is-grey has-text-white is-7 mb-2">Primary startup unset.</div>
                    </div>
                </div>

                <!-- Post Section -->
                <div class="column is-8">
                    <div class="columns">
                        <!-- Post Creation -->
                        <div class="column is-10">
                            @if ($sharing)
                                <div class="is-size-5">Sharing a post</div>
                                <div class="is-size-7 has-text-grey-light mb-2">You are now sharing a post by
                                    <strong>{{ $post->user->username }}</strong>
                                </div>
                                <hr>
                                <div class="box">
                                    <article class="media">
                                        <figure class="media-left">
                                            <p class="image is-32x32">
                                                <img src="{{ asset('images/users/' . $post->user->picture . '.jpg') }}"
                                                    alt="User Profile Picture" class="profile-image">
                                            </p>
                                        </figure>
                                        <div class="media-content">
                                            <div class="content">
                                                <div class="title is-6 mb-1"><a
                                                        href="{{ route('user.profile', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a>
                                                </div>
                                                <p>{!! nl2br(\App\Models\Post::parseBBCode($post->body)) !!}</p>
                                            </div>
                                            @if ($post->image != 0)
                                                <span class="is-size-7">
                                                    <a href="{{ route('post.view', ['id' => $post->id]) }}"
                                                        class="button is-small is-rounded">This post has an image attached.
                                                        You can view the image here</a></span>
                                            @endif
                                            <hr class="mt-2 mb-2">
                                            <form
                                                action="{{ route('user.dashboard.share::sharePost', ['post' => $post->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="field">
                                                    <div class="control">
                                                        <div class="subtitle is-grey is-7 mb-2">What are your thoughts on
                                                            this?</div>
                                                        <textarea class="textarea @error('body') is-danger @enderror" name="body"
                                                            placeholder="What do you think about this post? This can be left empty"></textarea>
                                                    </div>
                                                    @error('body')
                                                        <p class="help is-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="field">
                                                    <div class="control">
                                                        <button class="button is-primary" type="submit">Share</button>

                                                        <a href="{{ route('user.dashboard') }}"
                                                            class="button is-light">Exit</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="media-right is-hidden-mobile">
                                            <span
                                                class="subtitle is-7">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </article>
                                </div>
                            @else
                                <div class="is-size-5">Make a post</div>
                                <div class="is-size-7 has-text-grey-light mb-2">Tell the world something!</div>
                                <hr>
                                <form method="POST" action="{{ route('user.dashboard::makePost') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- Post Body Field -->
                                    <div class="field">
                                        <div class="control">
                                            <div class="title is-6">Post body</div>
                                            <div class="subtitle is-grey is-7 mb-4">This content of your post</div>
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
                                            <div class="title is-6">Add a picture to your post</div>
                                            <div class="subtitle is-grey is-7 mb-4">This picture will be shown alongside
                                                your
                                                post. This is optional.</div>
                                            <div
                                                class="file is-primary has-name is-fullwidth {{ $errors->has('picture') ? 'is-danger' : '' }}">
                                                <label class="file-label">
                                                    <input class="file-input" type="file" name="picture"
                                                        accept="image/*" id="fileInput">
                                                    <span class="file-cta">
                                                        <span class="file-icon">
                                                            <i class="fas fa-upload"></i>
                                                        </span>
                                                        <span class="file-label">Choose a picture</span>
                                                    </span>
                                                    <span class="file-name" id="fileName">No picture chosen</span>
                                                </label>
                                            </div>
                                            @if ($errors->has('picture'))
                                                <p class="help is-danger mt-1">{{ $errors->first('picture') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="field">
                                        <div class="control">
                                            <button class="button is-primary" type="submit">Post</button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                        </div>
                        <!-- BBCode Guide -->
                        <div class="column is-2">
                            <div class="is-size-5">BBCode</div>
                            <div class="is-size-7 has-text-grey-light mb-2">Formatting rules</div>
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

                    <!-- Display Posts -->
                    @forelse($posts as $post)
                        <div>
                            <div class="box mb-3">
                                <article class="media is-align-items-center">
                                    <figure class="media-left">
                                        <p class="image is-32x32">
                                            <img src="{{ asset('images/users/' . $post->user->picture . '.jpg') }}"
                                                alt="User Profile Picture" class="profile-image">
                                        </p>
                                    </figure>
                                    <div class="media-content">
                                        <div class="content mb-2">
                                            <div class="title is-6 mb-1"><a
                                                    href="{{ route('user.profile', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a>
                                            </div>
                                            <p>{!! nl2br(\App\Models\Post::parseBBCode($post->body)) !!}</p>
                                        </div>
                                        @if ($post->is_share != 0 && $post->share_of)
                                            <article class="media m-3">

                                                <figure class="media-left">
                                                    <p class="image is-32x32">
                                                        <img src="{{ asset('images/users/' . $post->originalPostUser->user->picture . '.jpg') }}"
                                                            alt="User Profile Picture" class="profile-image">
                                                    </p>
                                                </figure>
                                                <div class="media-content">
                                                    <div class="is-size-7">Sharing post by <strong>
                                                            <a
                                                                href="{{ route('user.profile', ['username' => $post->originalPostUser->user->username]) }}">{{ $post->originalPostUser->user->username }}</a></strong>
                                                    </div>

                                                    <div class="is-size-7">
                                                        <p>{!! nl2br(\App\Models\Post::parseBBCode($post->originalPost->body)) !!}</p>

                                                    </div>

                                                    @if ($post->originalPost->image != 0)
                                                        <figure class="image is-128x128">
                                                            <img src="{{ asset('images/posts/' . $post->originalPost->image . '.jpg') }}"
                                                                alt="Post Image">
                                                        </figure>
                                                        <span class="is-size-7 mb-2">
                                                            <a href="{{ route('post.view', ['id' => $post->id]) }}">This
                                                                post has an image
                                                                attached.
                                                                You can view the full image here</a></span>
                                                    @else
                                                        <span class="is-size-7">
                                                            <a href="{{ route('post.view', ['id' => $post->id]) }}">View
                                                                full
                                                                discussion</a></span>
                                                    @endif



                                                </div>
                                            </article>
                                        @endif
                                        @if ($post->image != 0)
                                            <figure class="image">
                                                <img src="{{ asset('images/posts/' . $post->image . '.jpg') }}"
                                                    alt="Post Image">
                                            </figure>
                                        @endif

                                        <hr class="mt-1 mb-2">
                                        <a href="{{ route('post.view', ['id' => $post->id]) }}"
                                            class="button is-small is-rounded">View Discussion</a>
                                        <a href="javascript:void(0)" class="button is-danger is-small is-rounded"
                                            id="like-btn-{{ $post->id }}" onclick="likePost({{ $post->id }})">
                                            @if ($post->likedByUser(auth()->user()))
                                                Unlike
                                            @else
                                                Like
                                            @endif
                                        </a>

                                        <a href="{{ route('user.dashboard.share::sharePost', ['post' => $post->id]) }}"
                                            class="button is-small is-rounded is-link">Share</a>
                                    </div>
                                    <div class="media-right is-hidden-mobile">
                                        <span
                                            class="subtitle is-7">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                        <br>
                                        <span id="like-count-{{ $post->id }}" class="is-size-7 mt-1">
                                            {{ $post->likes->count() }} Likes
                                        </span>
                                        <br>
                                        <span id="comment-count-{{ $post->id }}" class="is-size-7 mt-1">
                                            {{ $post->comments->count() }} Comments
                                        </span>

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
        </section>
    </div>

@stop

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File input change event listener
            const fileInput = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');

            fileInput.addEventListener('change', function(event) {
                fileName.textContent = event.target.files.length > 0 ? event.target.files[0].name :
                    'No picture chosen';
            });
        });

        function likePost(postId) {
            const likeBtn = document.getElementById('like-btn-' + postId);

            fetch(`/post/interact/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.liked) {
                        likeBtn.innerText = 'Unlike';
                    } else {
                        likeBtn.innerText = 'Like';
                    }

                    // Update the like count dynamically (if necessary)
                    const likeCountElement = document.getElementById('like-count-' + postId);
                    likeCountElement.innerText = `${data.like_count} Likes`;
                })
                .catch(error => console.log(error));
        }
    </script>
@endpush
