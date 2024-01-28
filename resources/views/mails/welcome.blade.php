<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mail</title>
    <link rel="stylesheet" href="build/assets/app-bOYiJRcL.css"> 
    {{-- bootstrap5 --}}
</head>
<body>
    <div class="container pt-5">
        <div class="row">
            <div class="col-8 offset-2 border rounded-2 p-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div style="width: 50px;height:50px;" class="">
                        <svg viewBox="0 0 24 24" aria-hidden="true" ><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg>
                    </div>
                    <p class="h4 text-center my-0 ms-3">Welcome to X-clone</p>
                </div>
                <p class="small fw-bold mt-3">Thanks {{$user->name}} for joining us.</p>
                <p class="small text-muted mt-1">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore, blanditiis? Laudantium, delectus molestiae, veniam eligendi, consequuntur eos qui autem aliquam ducimus ipsam reiciendis vel dolores architecto. Neque quod quae reprehenderit.
                </p>
                <button class="btn btn-dark rounded-pill">Verify Email</button>
            </div>
        </div>
    </div>
</body>
</html>