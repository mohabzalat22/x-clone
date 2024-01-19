<!-- profile-update -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="profile-modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" action="{{route('profile.update',['profile'=>auth()->user()->id])}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-header">
                <button class="btn btn-close" data-bs-dismiss="modal"></button>
                <div class="modal-title h5 fw-bolder flex-grow-1 ms-4">Edit Profile</div>
                <button type="submit" class="btn btn-dark fw-bold rounded-pill px-3">save</button>
            </div>
            <div class="modal-body">
                <div class="main-profile">
                    <div class="border-top border-bottom position-relative">
                        <!-- back-ground -->
                        <div class="profile-background position-relative">
                            @if ($user->background_picture)
                                <img src="{{url("storage/profileAssets/images/$user->background_picture")}}" class="w-100 h-100 object-fit">
                            @endif
                            <input type="file" name="background_picture" id="backgroundimg" class="d-none">
                            <button type="button" class="btn bg-dark rounded-circle p-2  position-absolute top-50 start-50 translate-middle" id="background_img_button">
                                <svg viewBox="0 0 25 25" style="width:25px;height:25px;" fill="white" aria-hidden="true" class=""><g><path d="M9.697 3H11v2h-.697l-3 2H5c-.276 0-.5.224-.5.5v11c0 .276.224.5.5.5h14c.276 0 .5-.224.5-.5V10h2v8.5c0 1.381-1.119 2.5-2.5 2.5H5c-1.381 0-2.5-1.119-2.5-2.5v-11C2.5 6.119 3.619 5 5 5h1.697l3-2zM12 10.5c-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2-.895-2-2-2zm-4 2c0-2.209 1.791-4 4-4s4 1.791 4 4-1.791 4-4 4-4-1.791-4-4zM17 2c0 1.657-1.343 3-3 3v1c1.657 0 3 1.343 3 3h1c0-1.657 1.343-3 3-3V5c-1.657 0-3-1.343-3-3h-1z"></path></g></svg>
                            </button>
                        </div>
                        <!-- profile img -->
                        <div class="position-absolute start-0 w-100 translate-middle-y">
                            <div class="d-flex justify-content-between align-items-end px-3">
                                <div class="profile-picture rounded-circle bg-light overflow-hidden position-relative">
                                    @if ($user->profile_picture)
                                        <img src="{{url("storage/profileAssets/images/$user->profile_picture")}}" class="w-100 h-100 object-fit">
                                    @endif
                                    <input type="file" name="profile_picture" id="profileimg" class="d-none">
                                    <button type="button" class="btn bg-dark rounded-circle p-2 position-absolute top-50 start-50 translate-middle" id="profile_img_button">
                                        <svg viewBox="0 0 25 25" class="opacity-50" style="width:25px;height:25px;" fill="white" aria-hidden="true"><g><path d="M9.697 3H11v2h-.697l-3 2H5c-.276 0-.5.224-.5.5v11c0 .276.224.5.5.5h14c.276 0 .5-.224.5-.5V10h2v8.5c0 1.381-1.119 2.5-2.5 2.5H5c-1.381 0-2.5-1.119-2.5-2.5v-11C2.5 6.119 3.619 5 5 5h1.697l3-2zM12 10.5c-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2-.895-2-2-2zm-4 2c0-2.209 1.791-4 4-4s4 1.791 4 4-1.791 4-4 4-4-1.791-4-4zM17 2c0 1.657-1.343 3-3 3v1c1.657 0 3 1.343 3 3h1c0-1.657 1.343-3 3-3V5c-1.657 0-3-1.343-3-3h-1z"></path></g></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- data -->
                        <div class="mt-80">
                            <!-- name -->
                            <div class="form-floating">
                                <input type="text" class="form-control" id="profile-name-input" name="name" value = {{$user->name}} placeholder="name">
                                <label for="profile-name-input" class="text-primary">name</label>
                            </div>
                            <!-- bio -->
                            <div class="form-floating mt-4">
                                <textarea type="text" class="form-control bio-text-area" id="profile-name-input" name="bio" placeholder="Bio">{{ $user->bio }}</textarea>
                                <label for="profile-name-input" class="text-primary">Bio</label>
                            </div>
                            <!-- location -->
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="profile-name-input" name="location" placeholder="Location">
                                <label for="profile-name-input" class="text-primary">Location</label>
                            </div>
                            <!-- website -->
                            <div class="form-floating mt-3">
                                <input type="text" class="form-control" id="profile-name-input" name="website" placeholder="Website">
                                <label for="profile-name-input" class="text-primary">Website</label>
                            </div>
                            <!-- date of birth -->
                            <div class="mt-2">
                                <span class="text-muted">Birth date . </span>
                                <span class="small text-primary mt-1">Edit</span>
                                <div class="h5 fw-bold">April 10, 2003</div>
                            </div>
                            <!-- end -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- main-profile -->
<div class="main-profile">
    <div class="border-top border-bottom position-relative">
        <!-- back-ground -->
        <div class="profile-background">
            @if ($user->background_picture)
                <img src="{{ url("storage/profileAssets/images/$user->background_picture") }}" class="w-100 h-100 object-fit">
            @endif        
        </div>
        <!-- profile img -->
        <div class="position-absolute start-0 w-100 translate-middle-y">
            <div class="d-flex justify-content-between align-items-end px-3">
                <div class="profile-picture rounded-circle bg-light overflow-hidden">
                    @if ($user->profile_picture)
                        <img src="{{ url("storage/profileAssets/images/$user->profile_picture") }}" class="w-100 h-100 object-fit">
                    @endif
                </div>
                @if(auth()->user()->id === $user->id)
                    <div class="mb-1 p-1">
                        <button class="btn btn-outline-dark rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#profile-modal">
                            edit profile
                        </button>
                    </div>
                @endif
            </div>
        </div>
         <!-- username -->
         <div class="px-3 mt-80">
            <div class="my-1">
                <p class="fw-bold h4 m-0">{{$user->name}}</p>
                <p class="small text-muted mt-1">{{$user->email}}</p>
            </div>
            <div class="d-flex">
                <div class="">
                    <span class="fw-bold">5</span>
                    <span class="text-muted small">Following</span>
                </div>
                <div class="ms-2">
                    <span class="fw-bold">5</span>
                    <span class="text-muted small">Followers</span>
                </div>
            </div>
        </div>
        <!-- navbar -->
        <div class="d-flex mt-3 mb-0 overflow-hidden">
            <div class="flex-grow-1 text-center pt-2 mt-1 more-light-hover">
                <p class="d-inline px-2 py-2  m-0">Posts</p>
                <div class="profile-border bg-primary mx-auto mt-1 my-0"></div>
            </div>
            <div class="flex-grow-1 text-center pt-2 mt-1 more-light-hover">
                <p class="d-inline px-2 py-2  m-0">Replies</p>
                {{-- <div class="profile-border bg-primary mx-auto mt-1 my-0"></div> --}}
            </div>
            <div class="flex-grow-1 text-center pt-2 mt-1 more-light-hover">
                <p class="d-inline px-2 py-2  m-0">Highlights</p>
                {{-- <div class="profile-border bg-primary mx-auto mt-1 my-0"></div> --}}
            </div>
            <div class="flex-grow-1 text-center pt-2 mt-1 more-light-hover">
                <p class="d-inline px-2 py-2  m-0">Media</p>
                {{-- <div class="profile-border bg-primary mx-auto mt-1 my-0"></div> --}}
            </div>
            <div class="flex-grow-1 text-center pt-2 mt-1 more-light-hover">
                <p class="d-inline px-2 py-2 m-0">Likes</p>
                {{-- <div class="profile-border bg-primary mx-auto mt-1"></div> --}}
            </div>
        </div>
    </div>
</div>