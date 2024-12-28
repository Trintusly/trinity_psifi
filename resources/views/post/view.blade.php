@extends('layouts.main')

@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <!-- Main content column -->
                <div class="column is-6">

                    <!-- Display post or shared post details -->
                    @if ($post->is_share != 0 && $post->share_of)
                        <div class="title is-4">View share</div>
                        <div class="subtitle is-grey is-7">
                            Viewing share by [<strong>{{ $post->user->username }}</strong>
                            <span
                                class="subtitle is-7">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>]
                            on [<strong>{{ $post->originalPostUser->user->username }}</strong>'s post
                            <span
                                class="subtitle is-7">{{ Carbon\Carbon::parse($post->originalPost->created_at)->diffForHumans() }}</span>]
                        </div>
                    @else
                        <div class="title is-4">View post</div>
                        <div class="subtitle is-grey is-7">
                            Viewing post by <strong>{{ $post->user->username }}</strong>
                            made <strong> <span
                                    class="subtitle is-7">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span></strong>
                        </div>
                    @endif

                    <!-- Post content box -->
                    <div class="box mt-2 mb-1">
                        <!-- If the post is a share, display the original post -->
                        @if ($post->is_share != 0 && $post->share_of)
                            <article class="media">
                                <!-- Original post user profile picture -->
                                <figure class="media-left">
                                    <p class="image is-32x32">
                                        <img src="{{ asset('images/users/' . $post->originalPostUser->user->picture . '.jpg') }}"
                                            alt="User Profile Picture" class="profile-image">
                                    </p>
                                </figure>

                                <div class="media-content">
                                    <!-- Display details of the original post -->
                                    <div class="is-size-7">Original post by <strong>
                                            <a>{{ $post->originalPostUser->user->username }}</a></strong>
                                    </div>

                                    <div class="is-size-7 mb-2">
                                        <p>{!! nl2br(\App\Models\Post::parseBBCode($post->originalPost->body)) !!}</p>
                                    </div>

                                    <!-- Display the image attached to the original post -->
                                    @if ($post->originalPost->image != 0)
                                        <figure class="image">
                                            <img src="{{ asset('images/posts/' . $post->originalPost->image . '.jpg') }}"
                                                alt="Post Image">
                                        </figure>
                                    @endif

                                    <!-- Link to view the full original post -->
                                    <span class="is-size-7">
                                        <a href="{{ route('post.view', ['id' => $post->originalPost->id]) }}">View full
                                            discussion</a>
                                    </span>
                                </div>
                            </article>
                        @endif

                        <!-- Current post content -->
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-32x32">
                                    <img src="{{ asset('images/users/' . $post->user->picture . '.jpg') }}"
                                        alt="User Profile Picture" class="profile-image">
                                </p>
                            </figure>
                            <div class="media-content">
                                <div class="content">
                                    <!-- Post title and body -->
                                    <div class="title is-6 mb-1">{{ $post->user->username }}</div>
                                    <p>{!! nl2br(\App\Models\Post::parseBBCode($post->body)) !!}</p>

                                    <!-- Post image (if any) -->
                                    @if ($post->image != 0)
                                        <figure class="image">
                                            <img src="{{ asset('images/posts/' . $post->image . '.jpg') }}"
                                                alt="Post Image">
                                        </figure>
                                    @endif
                                </div>

                                @if (auth()->check())
                                    <!-- Buttons for like and share actions -->
                                    <hr class="mt-1 mb-2">
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
                                @endif
                            </div>
                        </article>
                    </div>

                    <!-- Like and comment counts -->
                    <span id="like-count-{{ $post->id }}" class="is-size-7 ">
                        <strong>{{ $post->likes->count() }}</strong> Likes,
                    </span>
                    <span id="comment-count-{{ $post->id }}" class="is-size-7">
                        <strong>{{ $post->comments->count() }}</strong> Comments
                    </span>

                    <!-- Comment Section -->
                    <div class="is-size-5 mt-3">
                        Comments
                    </div>
                    <div class="is-size-7 has-text-grey-light mb-2">
                        Join in on the discussion
                    </div>

                    @if (auth()->check())
                        <!-- Comment Form -->
                        <form method="POST" action="{{ route('post.interact::comment', ['id' => $post->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Body Field for Comment -->
                            <div class="field">
                                <div class="control">
                                    <textarea class="textarea @error('body') is-danger @enderror" name="body"
                                        placeholder="What do you think about this post?" rows="2"></textarea>
                                </div>
                                @error('body')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="field">
                                <div class="control">
                                    <button class="button is-primary" type="submit">Comment</button>
                                </div>
                            </div>
                        </form>
                    @else
                        Login or register to comment.
                    @endif

                    <hr>

                    <!-- Display Comments -->
                    @forelse($comments as $c)
                        <div>
                            <div class="box mb-3">
                                <article class="media is-align-items-center">
                                    <figure class="media-left">
                                        <p class="image is-32x32">
                                            <img src="{{ asset('images/users/' . $c->user->picture . '.jpg') }}"
                                                alt="User Profile Picture" class="profile-image">
                                        </p>
                                    </figure>
                                    <div class="media-content">
                                        <div class="content">
                                            <div class="title is-6 mb-1">{{ $c->user->username }}</div>
                                            <p>{!! nl2br(\App\Models\Post::parseBBCode($c->body)) !!}</p>
                                        </div>
                                    </div>
                                    <!-- Display comment timestamp -->
                                    <div class="media-right is-hidden-mobile">
                                        <span
                                            class="subtitle is-7">{{ Carbon\Carbon::parse($c->created_at)->diffForHumans() }}</span>
                                    </div>
                                </article>
                            </div>
                        </div>
                    @empty
                        <div class="has-text-grey">No comments here...</div>
                    @endforelse

                    <!-- Pagination for Comments -->
                    <div class="is-flex is-justify-content-center">
                        {{ $comments->links('pagination::bulma') }}
                    </div>
                </div>

                <!-- Sidebar for Likes -->
                <div class="column is-3">
                    <div class="title is-6">Like list</div>
                    <div class="subtitle is-grey is-7">View who liked this post
                    </div>

                    <!-- Display users who liked the post -->
                    @forelse($likes as $like)
                        <div>
                            <div class="box mb-3 p-2">
                                <article class="media is-align-items-center">
                                    <div class="media-content">
                                        <div class="content">
                                            <div class="is-size-7">{{ $like->username }}</div>
                                        </div>
                                    </div>
                                    <!-- Display user profile picture -->
                                    <figure class="media-right">
                                        <p class="image is-32x32">
                                            <img src="{{ asset('images/users/' . $like->picture . '.jpg') }}"
                                                alt="User Profile Picture" class="profile-image">
                                        </p>
                                    </figure>
                                </article>
                            </div>
                        </div>
                    @empty
                        <div class="has-text-grey">No likes here...</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

@stop

@push('scripts')
    <script>
        // JavaScript function to handle like button click
        function likePost(postId) {
            const likeBtn = document.getElementById('like-btn-' + postId);

            // Send a POST request to toggle like status
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
                    window.location.reload(); // Reload the page after like/unlike action
                })
                .catch(error => console.log(error));
        }
    </script>
@endpush
