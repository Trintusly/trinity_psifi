@extends('layouts.main')
@section('content')

    <div class="container">
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <a href="/">Go back</a>
                    <div class="box mt-2">
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-32x32">
                                    {{-- <img src="{{ $q->user->thumbnail_url }}" /> --}}
                                </p>
                            </figure>
                            <div class="media-content">
                                <div class="content">
                                    <div class="title is-6 mb-1">{{ $post->user->username }}</div>
                                    {{-- <div class="help is-grey m-0">x</div> --}}
                                    <p>{!! nl2br(\App\Models\Post::parseBBCode($post->body)) !!}</p>
                                </div>
                                <hr class="mt-1 mb-2">
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
                                    class="subtitle is-7">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                            </div>
                        </article>


                    </div>

                    <div class="is-size-5">
                        Comments
                    </div>
                    <div class="is-size-7 has-text-grey-light mb-2">
                        Join in on the discussion
                    </div>

                    <form method="POST" action="{{ route('post.interact::comment', ['id' => $post->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Body Field -->
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

                    <hr>


                    @forelse($comments as $c)
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
                                            <div class="title is-6 mb-1">{{ $c->user->username }}</div>
                                            {{-- <div class="help is-grey m-0">x</div> --}}
                                            <p>{!! nl2br(\App\Models\Post::parseBBCode($c->body)) !!}</p>
                                        </div>
                                        {{-- <hr class="mt-1 mb-2">
                                        
                                        <a href="#" class="button is-small is-rounded is-danger">
                                            Like
                                        </a>
                                        <a href="#" class="button is-small is-rounded is-link">
                                            Share
                                        </a> --}}

                                    </div>
                                    <!-- Admin and Online Status -->
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
                    <div class="is-flex is-justify-content-center">
                        {{ $comments->links('pagination::bulma') }}
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
