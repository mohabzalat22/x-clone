

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
    {{-- <link rel="stylesheet" href="build/assets/app-Y8EbMdDv.css">
    <link rel="stylesheet" href="build/assets/app-Syctgfzh.css"> --}}
</head>
<body class="bg-white">
    {{-- loader --}}
    @include('layouts.loader')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <!-- side-bar -->
            @include('layouts.sidebar')
            <!-- center-field -->
            <div class="col col-lg-8 col-xl-6 border g-0">
                <!-- profile -->
                @include('layouts.notificationsNav')
                @foreach ($notifications as $notification)
                    @include('layouts.notification')
                @endforeach
            </div>
            <!-- right-section -->
            @include('layouts.rightSection')
        </div>
    </div>
    @vite('resources/js/app.js')
    @vite('resources/js/home.js')
    {{-- <script src="build/assets/app-NjozvkkZ.js"></script> --}}
</body>
</html>


