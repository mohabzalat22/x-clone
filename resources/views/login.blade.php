<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>twitter | clone</title>
    <script>
        document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector("body").style.visibility = "hidden";
            document.querySelector("#loader").style.visibility = "visible";
        } else {
            document.querySelector("#loader").style.display = "none";
            document.querySelector("body").style.visibility = "visible";
        }
    };
    </script>
    @vite('resources/css/login.css')
    {{-- <link rel="stylesheet" href="build/assets/app-Y8EbMdDv.css">
    <link rel="stylesheet" href="build/assets/app-Syctgfzh.css"> --}}
</head>
<body>
    {{-- loader --}}
    @include('layouts.loader')

    <div class="position-fixed top-0 end-0">
        @include('layouts.errors')
    </div>
    <!-- home -->
    <div class="container-xxl mt-lg-5 pb-5">
        <div class="row flex-column flex-lg-row">
            <div class="col-3 col-xl-4 offset-xl-1 ps-lg-5 py-5 mt-5">
                <div class="x-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class=""><g><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></g></svg></div>
                </div>
            <div class="col offset-xl-1 ps-lg-5">
                <div class="text-dark mb-4">
                    <h1 class="display-2 fw-bolder mb-5">Happening now</h1>
                    <h2 class="fw-bold">Join today.</h2>
                </div>
            <div class="row">
                <div class="col col-md-8 col-xl-6">
                    <div class="btn-group flex-column">
                        <button class="btn border rounded-pill px-5 mb-1">
                            <img src="{{asset('assets/google.svg')}}" class="" alt="" style="width: 20px;">
                            Sign up with Google
                        </button>
                        <button class="btn border rounded-pill px-5">
                            <img src="{{asset('assets/apple.svg')}}" class="" alt="" style="width: 20px;">
                            Sign up with Apple
                        </button>
                        <div class="position-relative">
                            <hr class="text-body-tertiary">
                            <p class="position-absolute top-50 start-50 translate-middle p-1 bg-light">or</p>
                        </div>
                        <button class="btn btn-primary rounded-pill mb-2" data-bs-toggle="modal" data-bs-target="#sign-up-modal">Create account</button>
                        <small class="text-muted mb-5">
                            By signing up, you agree to the <span class="text-primary">Terms of Service</span> and <span class="text-primary"> Privacy Policy </span>, including <span class="text-primary"> Cookie Use. </span>
                        </small>
                        <p class="h5">
                            Already have an account?
                        </p>
                        <a role="button" class="btn btn-outline-primary rounded-pill mb-5" data-bs-toggle="modal" data-bs-target="#login-modal">Sign in</a>
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </div>
    <!-- modal login -->
    <div class="modal fade modal-lg " tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="login-modal">
        <div class="modal-dialog">
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
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-lg-8 offset-2 px-lg-5">
                            <div class="h1 text-dark fw-bold mb-5" class="hide-sign-in-body">
                                Sign in to X
                            </div>
                            <div class="d-flex flex-column hide-sign-in-body">
                                <button class="btn border rounded-pill px-4 py-2 mb-4">
                                    <img src="{{asset('assets/google.svg')}}" class="" alt="" style="width: 25px;">
                                    Sign in with Google
                                </button>
                                <button class="btn border rounded-pill px-4 py-2 mb-1">
                                    <img src="{{asset('assets/apple.svg')}}" class="" alt="" style="width: 25px;">
                                    Sign in with Apple
                                </button>
                            </div>
                            <div class="position-relative mb-4 hide-sign-in-body">
                                <hr>
                                <p class="position-absolute top-50 start-50 translate-middle p-2 bg-light">or</p>
                            </div>
                            <div action="" class="form-floating mb-5 hide-sign-in-body">
                                <input type="email" class="form-control mb-4" id="sign-in-email-first" placeholder="email">
                                <div class="alert alert-danger invisible" id="sign-in-email-first-error">Error</div>
                                <label for="email" class="text-primary">Phone, email, or username</label>
                                <button class="btn btn-dark rounded-pill px-3 d-block w-100 my-3" id="sign-in-next"><div class="h5 m-0">Next</div></button>
                                <a class="btn border rounded-pill px-3 d-block w-100" ><div class="h5 m-0">Forgot Password?</div></a>
                            </div>
                            <form action="{{ route('login') }}" method="POST" class="d-none" id="hidden-form">
                                @csrf
                                <div class="form-floating mb-1">
                                    <input type="email" class="form-control mb-2 bg-secondary-subtle" id="email" placeholder="email" name="email" readonly>
                                    <label for="email" class="text-primary">Phone, email, or username</label>
                                </div>
                                <div class="form-floating mb-5">
                                    <input type="password" class="form-control mb-1" id="password" placeholder="Password" name="password">
                                    <label for="password" class="text-primary">Password</label>
                                    <a class="ms-1 link-primary-subtle small text-decoration-none">Forgot password?</a>
                                </div>
                                <div class="py-5"></div>
                                <button class="btn btn-dark rounded-pill px-3 d-block w-100 mt-0" type="submit"><div class="h5 m-0">Login</div></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-block col col-lg-8 offset-2 px-lg-5 border-top-0">
                    <p>Don't have an account? <span class="text-primary">Sign up</span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- modal sign-up -->
    <div class="modal fade modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" id="sign-up-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <div class="modal-title w-100 d-flex align-items-center align-self-center">
                        <button class="btn btn-close small" data-bs-dismiss="modal"></button>
                        <div class="h5 w-100 ms-5">
                            <p class="m-0 pt-1 fw-bold">Step 1 of 5</p>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-lg-8 offset-1 offset-lg-2">
                            <div class="h2 fw-bold">
                                Create your account
                            </div>
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-floating">
                                    <input type="text" class="form-control mb-3" placeholder="name" id="name-sign-up" name="name">
                                    <label for="name-sign-up" class="text-primary">Name</label>
                                </div>
                                <div class="form-floating">
                                    <input type="email" class="form-control mb-4" placeholder="email" id="email-sign-up" name="email">
                                    <div class="alert alert-danger d-none" id="email-sign-up-error">Error</div>
                                    <label for="email-sign-up" class="text-primary">Email</label>
                                </div>
                                {{-- password --}}
                                <div class="form-floating">
                                    <input type="password" class="form-control mb-4" placeholder="password" id="password-sign-up" name="password">
                                    <div class="alert alert-danger d-none" id="password-sign-up-error">Error</div>
                                    <label for="email-sign-up" class="text-primary">Password</label>
                                </div>
                                {{-- end password --}}
                                <div>
                                    <p class="text-dark fw-bold mb-1">Date of birth</p>
                                    <p class="text-secondary lh-sm small">
                                        This will not be shown publicly. Confirm your own age, even if this account is for a business, a pet, or something else.
                                    </p>
                                </div>
                                <div class="d-flex mb-4">
                                    <select name="month" id="" class="form-select">
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                    
                                    <select name="day" id="" class="form-select mx-2 w-25">
                                        @for ($i = 1; $i<=31; $i++)
                                            <option value="{{$i}}">{{$i}}</option>           
                                        @endfor
                                    </select>

                                    <select name="year" id="" class="form-select w-50">
                                        @for ($i = 1950; $i<=2024; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-secondary w-100 py-2 rounded-pill" id="sign-up-next"><div class="h5 m-0">Next</div></button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0"></div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer class="container-fluid">
        <ul class="nav nav-underline list-unstyled small justify-content-center">
            <li><a href="" class="text-decoration-none px-1 text-secondary">About</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Download the X app</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Help Center</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Terms of Service</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Privacy Policy</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Cookie Policy</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Accessibility</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Ads info</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Blog</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Status</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Careers</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Brand Resources</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Advertising</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Marketing</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">X for Business</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Developers</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">Settings</a></li>
            <li><a href="" class="text-decoration-none px-1 text-secondary">© 2023 X Corp.</a></li>
        </ul>
    </footer>
    @vite(['resources/js/app.js','resources/js/login.js']);
    {{-- <script src="build/assets/app-NjozvkkZ.js"></script> --}}
</body>
</html>
