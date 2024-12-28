@extends('layouts.main')

@section('content')
    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-7">
                    <div class="title is-4">Feed</div>
                    <div class="subtitle is-grey is-7">
                        View what others are posting
                    </div>
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

                                        @if (auth()->check())
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
                                        @endif
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
@endsection


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
