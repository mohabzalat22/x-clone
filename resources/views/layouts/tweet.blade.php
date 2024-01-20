<div class="d-flex px-2 py-3 post-x" id="tweet-id-{{$tweet->id}}"> 
    <!-- profile-img -->
    <div>
        @if ($tweet->user->profile_picture)
            <img src="{{ url( "storage/profileAssets/images/" . $tweet->user->profile_picture ) }}" alt="" style="width: 40px; height: 40px;" class="rounded-circle object-fit">
            @else 
                <div style="width: 40px; height: 40px;" class="rounded-circle d-block bg-dark"></div>
        @endif
    </div>
    <div class="flex-grow-1 ps-4">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <div class="fw-bold">{{ $tweet->user->name }}</div>
                <div class="data-muted small">
                    <div class="ms-1">
                        {{ $tweet->user->email }}
                    </div>
                </div>
                <div class="bg-secondary ms-1" style="width: 4px; height: 4px; border-radius: 50%;"></div>
                <div class="text-muted ms-1">{{App\Services\DateTimeService::tweetAge($tweet->created_at)}}</div>
            </div>
            <div class="data-muted d-flex">
                <span class="small my-auto">
                    Ad
                </span>
                <div class="dropdown">
                    <button class="btn border-0 p-0  button-x-info" data-bs-toggle="dropdown">
                        <svg viewBox="0 0 24 24" width="20px" height="20px" fill="var(--bs-secondary)" aria-hidden="true" class="p-1 content-box rounded-circle"><g><path d="M3 12c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9 2c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm7 0c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></g></svg>                
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M10 4c-1.105 0-2 .9-2 2s.895 2 2 2 2-.9 2-2-.895-2-2-2zM6 6c0-2.21 1.791-4 4-4s4 1.79 4 4-1.791 4-4 4-4-1.79-4-4zm13 4v3h2v-3h3V8h-3V5h-2v3h-3v2h3zM3.651 19h12.698c-.337-1.8-1.023-3.21-1.945-4.19C13.318 13.65 11.838 13 10 13s-3.317.65-4.404 1.81c-.922.98-1.608 2.39-1.945 4.19zm.486-5.56C5.627 11.85 7.648 11 10 11s4.373.85 5.863 2.44c1.477 1.58 2.366 3.8 2.632 6.46l.11 1.1H1.395l.11-1.1c.266-2.66 1.155-4.88 2.632-6.46z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Unfollow {{ $tweet->user->name }}
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M12 4c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM8 6c0-2.21 1.79-4 4-4s4 1.79 4 4-1.79 4-4 4-4-1.79-4-4zm4 7c-1.84 0-3.32.65-4.4 1.81-.93.98-1.61 2.39-1.95 4.19h5.85v2H3.4l.1-1.1c.27-2.66 1.16-4.88 2.64-6.46C7.63 11.85 9.65 11 12 11c.91 0 1.78.13 2.58.38l-.9 1.82c-.52-.13-1.08-.2-1.68-.2zm5-2l1.76 3.57 3.95.58-2.86 2.78.68 3.92L17 20l-3.53 1.85.68-3.92-2.86-2.78 3.95-.58L17 11z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Subscribe to {{ $tweet->user->name }}
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M5.5 4c-.28 0-.5.22-.5.5v15c0 .28.22.5.5.5H12v2H5.5C4.12 22 3 20.88 3 19.5v-15C3 3.12 4.12 2 5.5 2h13C19.88 2 21 3.12 21 4.5V13h-2V4.5c0-.28-.22-.5-.5-.5h-13zM16 10H8V8h8v2zm-8 2h8v2H8v-2zm10 7v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Add/remove {{ $tweet->user->name }}
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M18 6.59V1.2L8.71 7H5.5C4.12 7 3 8.12 3 9.5v5C3 15.88 4.12 17 5.5 17h2.09l-2.3 2.29 1.42 1.42 15.5-15.5-1.42-1.42L18 6.59zm-8 8V8.55l6-3.75v3.79l-6 6zM5 9.5c0-.28.22-.5.5-.5H8v6H5.5c-.28 0-.5-.22-.5-.5v-5zm6.5 9.24l1.45-1.45L16 19.2V14l2 .02v8.78l-6.5-4.06z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Mute {{ $tweet->user->name }}
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M12 3.75c-4.55 0-8.25 3.69-8.25 8.25 0 1.92.66 3.68 1.75 5.08L17.09 5.5C15.68 4.4 13.92 3.75 12 3.75zm6.5 3.17L6.92 18.5c1.4 1.1 3.16 1.75 5.08 1.75 4.56 0 8.25-3.69 8.25-8.25 0-1.92-.65-3.68-1.75-5.08zM1.75 12C1.75 6.34 6.34 1.75 12 1.75S22.25 6.34 22.25 12 17.66 22.25 12 22.25 1.75 17.66 1.75 12z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Block {{ $tweet->user->name }}
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M8.75 21V3h2v18h-2zM18 21V8.5h2V21h-2zM4 21l.004-10h2L6 21H4zm9.248 0v-7h2v7h-2z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    View post engagements
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M15.24 4.31l-4.55 15.93-1.93-.55 4.55-15.93 1.93.55zm-8.33 3.6L3.33 12l3.58 4.09-1.5 1.32L.67 12l4.74-5.41 1.5 1.32zm11.68-1.32L23.33 12l-4.74 5.41-1.5-1.32L20.67 12l-3.58-4.09 1.5-1.32z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Embed post
                                </p>
                            </a>
                        </li>
                        <li class="button-x p-2">
                            <a href="" class="text-decoration-none d-flex align-items-center">
                                <div class="mx-2">
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M3 2h18.61l-3.5 7 3.5 7H5v6H3V2zm2 12h13.38l-2.5-5 2.5-5H5v10z"></path></g></svg>
                                </div>
                                <p class="small text-dark data-nowrap fw-bold m-0">
                                    Report post
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- main post -->
        <div class="">
            <!-- caption -->
            <p class="">
                {{$tweet->data}}
                {{-- {{$tweet->source}} --}}
                {{-- {{ HomeController::getType($tweet->source) }} --}}
            </p>
            <!-- tweet sources -->
            @if (App\Services\SourceTypeService::getExtension($tweet->source))
                <div class="ratio mb-2 rounded-4" style="--bs-aspect-ratio: 50%;">
                    @if (App\Services\SourceTypeService::extensionIn($tweet->source, ['png', 'jpg', 'jpeg']))
                        <img src="{{ url("images/$tweet->source") }}" alt="" class="w-auto rounded-4 d-block me-auto" >
                    @elseif (App\Services\SourceTypeService::extensionIn($tweet->source, ['mp4']))
                        <video class="post-video rounded-4 d-block me-auto" id="post-source" controls>
                            <source src="{{ url("videos/$tweet->source") }}">
                        </video>
                    @endif
                    <!-- dont forget w-auto in img $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->
                </div>
            @endif

            <!-- REACTION BAR -->            
            {{-- comments --}}
           
            <div class="modal fade modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="comment-modal-{{$tweet->id}}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <div class="modal-title w-100 d-flex">
                                <button class="btn btn-close small mt-2" data-bs-dismiss="modal" id="modal-dismiss"></button>
                                <div class="w-100 d-flex justify-content-center">
                                    <div style="width: 50px; height: 50px;">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" class=""><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal comment body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        @foreach ($tweet->comments as $TweetComment)
                                            <li class="list-unstyled mb-2 px-1 button-x">
                                                <div class="d-flex align-items-center">
                                                    @if($TweetComment->user->profile_picture)
                                                        <img src="{{ url("storage/profileAssets/images/" . $TweetComment->user->profile_picture) }}" alt="" style="width: 40px; height: 40px;" class="rounded-circle object-fit">
                                                        @else  
                                                            <div style="width: 40px; height: 40px;" class="rounded-circle d-block bg-dark"></div>
                                                    @endif
                                                    <div class="d-flex flex-column flex-grow-1">
                                                        <div class="ms-2">{{ $TweetComment->user->name }}</div> 
                                                        <div class="ms-2 small text-muted">{{ $TweetComment->user->email }}</div> 
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn border-0 p-0  button-x-info" data-bs-toggle="dropdown">
                                                            <svg viewBox="0 0 24 24" width="20px" height="20px" fill="var(--bs-secondary)" aria-hidden="true" class="p-1 content-box rounded-circle"><g><path d="M3 12c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9 2c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm7 0c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></g></svg>                
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li class="button-x p-2">
                                                                Edit
                                                            </li>
                                                            <li class="button-x p-2">
                                                                Delete
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="text-bold mt-2">
                                                    <p class="text-break"> {{$TweetComment->comment}} </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <form action=" {{route('comment.store')}} " class="w-100" method="POST">
                                        @csrf
                                        <input type="text" class="d-none" value="{{ $tweet->id }}" name="tweet_id">
                                        <label for="comment" class="small text-muted">Write Something ?!</label>
                                        <input type="text" class="form-control" id="comment" name="comment">
                                        <button class="btn btn-primary rounded-pill px-3 py-1 d-block ms-auto mt-2" type="submit">Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn border-0 react-button react-button-1" data-bs-toggle="modal" data-bs-target="#comment-modal-{{$tweet->id}}">
                    <svg viewBox="0 0 24 24" fill="var(--bs-secondary)" aria-hidden="true" class="content-box rounded-circle"><g><path d="M1.751 10c0-4.42 3.584-8 8.005-8h4.366c4.49 0 8.129 3.64 8.129 8.13 0 2.96-1.607 5.68-4.196 7.11l-8.054 4.46v-3.69h-.067c-4.49.1-8.183-3.51-8.183-8.01zm8.005-6c-3.317 0-6.005 2.69-6.005 6 0 3.37 2.77 6.08 6.138 6.01l.351-.01h1.761v2.3l5.087-2.81c1.951-1.08 3.163-3.13 3.163-5.36 0-3.39-2.744-6.13-6.129-6.13H9.756z"></path></g></svg>
                    <span class="text-secondary small">{{ App\Services\ReactionsService::CountCommentsByTweetId($tweet->id) }}</span>
                </button>
                <div class="dropdown">
                    <button class="btn border-0 react-button react-button-2" data-bs-toggle="dropdown">
                        <svg viewBox="0 0 24 24" fill="var(--bs-secondary)" aria-hidden="true" class="content-box rounded-circle"><g><path d="M4.5 3.88l4.432 4.14-1.364 1.46L5.5 7.55V16c0 1.1.896 2 2 2H13v2H7.5c-2.209 0-4-1.79-4-4V7.55L1.432 9.48.068 8.02 4.5 3.88zM16.5 6H11V4h5.5c2.209 0 4 1.79 4 4v8.45l2.068-1.93 1.364 1.46-4.432 4.14-4.432-4.14 1.364-1.46 2.068 1.93V8c0-1.1-.896-2-2-2z"></path></g></svg>
                        <span class="text-secondary small">{{ App\Services\ReactionsService::CountRepostsByTweetId($tweet->id) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end p-1">
                        <li class="p-2 button-x">
                            <a href="" class="text-dark text-decoration-none d-flex align-items-center">
                                <div>
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M4.5 3.88l4.432 4.14-1.364 1.46L5.5 7.55V16c0 1.1.896 2 2 2H13v2H7.5c-2.209 0-4-1.79-4-4V7.55L1.432 9.48.068 8.02 4.5 3.88zM16.5 6H11V4h5.5c2.209 0 4 1.79 4 4v8.45l2.068-1.93 1.364 1.46-4.432 4.14-4.432-4.14 1.364-1.46 2.068 1.93V8c0-1.1-.896-2-2-2z"></path></g></svg>
                                </div>
                                <p class="m-0 fw-bold ms-2">
                                    Repost
                                </p>
                            </a>
                        </li>
                        <li class="p-2 button-x">
                            <a href="" class="text-dark text-decoration-none d-flex align-items-center">
                                <div>
                                    <svg viewBox="0 0 24 24" height="20px" width="20px" aria-hidden="true" class=""><g><path d="M14.23 2.854c.98-.977 2.56-.977 3.54 0l3.38 3.378c.97.977.97 2.559 0 3.536L9.91 21H3v-6.914L14.23 2.854zm2.12 1.414c-.19-.195-.51-.195-.7 0L5 14.914V19h4.09L19.73 8.354c.2-.196.2-.512 0-.708l-3.38-3.378zM14.75 19l-2 2H21v-2h-6.25z"></path></g></svg>
                                </div>
                                <p class="m-0 fw-bold ms-2">
                                    Repost
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
                <form action="{{route('reaction.heart')}}" method="post">
                    @csrf
                    <input type="text" value="{{$tweet->id}}" name="tweet_id" hidden>
                    <button type="submit" class="btn border-0 react-button react-button-3" id="heart-button" tweetId="{{$tweet->id}}">
                        <svg viewBox="0 0 24 24" fill="var(--bs-secondary)" aria-hidden="true" class="content-box rounded-circle"><g><path d="M16.697 5.5c-1.222-.06-2.679.51-3.89 2.16l-.805 1.09-.806-1.09C9.984 6.01 8.526 5.44 7.304 5.5c-1.243.07-2.349.78-2.91 1.91-.552 1.12-.633 2.78.479 4.82 1.074 1.97 3.257 4.27 7.129 6.61 3.87-2.34 6.052-4.64 7.126-6.61 1.111-2.04 1.03-3.7.477-4.82-.561-1.13-1.666-1.84-2.908-1.91zm4.187 7.69c-1.351 2.48-4.001 5.12-8.379 7.67l-.503.3-.504-.3c-4.379-2.55-7.029-5.19-8.382-7.67-1.36-2.5-1.41-4.86-.514-6.67.887-1.79 2.647-2.91 4.601-3.01 1.651-.09 3.368.56 4.798 2.01 1.429-1.45 3.146-2.1 4.796-2.01 1.954.1 3.714 1.22 4.601 3.01.896 1.81.846 4.17-.514 6.67z"></path></g></svg>
                        <span class="text-secondary small">{{ App\Services\ReactionsService::CountHeartsByTweetId($tweet->id) }}</span>
                    </button>
                </form>
                <form action="{{route('reaction.viewed')}}" method="post">
                    @csrf
                    <input type="text" value="{{$tweet->id}}" name="tweet_id" hidden >
                    <button class="btn border-0 react-button react-button-4">
                        <svg viewBox="0 0 24 24" fill="var(--bs-secondary)" aria-hidden="true" class="content-box rounded-circle"><g><path d="M8.75 21V3h2v18h-2zM18 21V8.5h2V21h-2zM4 21l.004-10h2L6 21H4zm9.248 0v-7h2v7h-2z"></path></g></svg>
                        <span class="text-secondary small">{{ App\Services\ReactionsService::CountViewsByTweetId($tweet->id) }}</span>
                    </button>
                </form>
                <button class="btn border-0 react-button">
                    <svg viewBox="0 0 24 24" fill="var(--bs-secondary)" aria-hidden="true" class="mx-1 content-box rounded-circle button-x-fill"><g><path d="M4 4.5C4 3.12 5.119 2 6.5 2h11C18.881 2 20 3.12 20 4.5v18.44l-8-5.71-8 5.71V4.5zM6.5 4c-.276 0-.5.22-.5.5v14.56l6-4.29 6 4.29V4.5c0-.28-.224-.5-.5-.5h-11z"></path></g></svg>
                    <svg viewBox="0 0 24 24" fill="var(--bs-secondary)" aria-hidden="true" class="mx-1 content-box rounded-circle button-x-fill"><g><path d="M12 2.59l5.7 5.7-1.41 1.42L13 6.41V16h-2V6.41l-3.3 3.3-1.41-1.42L12 2.59zM21 15l-.02 3.51c0 1.38-1.12 2.49-2.5 2.49H5.5C4.11 21 3 19.88 3 18.5V15h2v3.5c0 .28.22.5.5.5h12.98c.28 0 .5-.22.5-.5L19 15h2z"></path></g></svg>
                </button>
            </div>
        </div>
    </div>
</div>