<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf">
    <title>home</title>
    <script>
        document.onreadystatechange  = function() {
        if (document.readyState !== "complete") {
            document.querySelector("body").style.visibility = "hidden";
            document.querySelector("#loader").style.visibility = "visible";
        } else {
            document.querySelector("#loader").style.display = "none";
            document.querySelector("body").style.visibility = "visible";
        }
    };
    </script>
    @vite('resources/css/home.css')
</head>
<body class="bg-white">
    {{-- loader --}}
    @include('layouts.loader')
    @include('layouts.errors')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <!-- side-bar -->
            @include('layouts.sidebar')
            <!-- center-feed -->
            <div class="col col-lg-8 col-xl-6 border g-0">
                <!-- post navbar -->
                @include('layouts.topNav')
                <!-- post bottom navbar -->
                @include('layouts.bottomNav')
                <!-- make-new-post -->
                @include('layouts.create')
                <!-- post -->
                @foreach ($tweets as $tweet)
                    @include('layouts.tweet')
                @endforeach
            </div>
            <!-- right-section -->
            @include('layouts.rightSection')
        </div>
    </div>
    @vite('resources/js/app.js')
    @vite('resources/js/home.js')
</body>
</html>