<div class="border-bottom p-3">
    <div class="d-flex justify-content-between">
        @if (\App\Models\User::find($notification->data['follower_id'])->profile_picture)
            <img src={{url("storage/profileAssets/images/" . \App\Models\User::find($notification->data['follower_id'])->profile_picture) }} alt="" style="width: 40px; height: 40px;" class="rounded-circle object-fit">
        @else
            <div style="width: 40px; height: 40px;" class="rounded-circle d-block bg-dark"></div>
        @endif
            <button class="btn border-0 p-0  button-x-info">
                <svg viewBox="0 0 24 24" width="20px" height="20px" fill="var(--bs-secondary)" aria-hidden="true" class="p-1 content-box rounded-circle"><g><path d="M3 12c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9 2c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm7 0c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path></g></svg>                
            </button>
    </div>
    <div>
        <p class="text-muted mt-1 px-3">
            <span class="fw-bold text-dark">{{$notification->data['followed_you']}}</span>
            <span class="small">
                has Followed you.
            </span>
        </p>
    </div>
</div>