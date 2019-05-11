<nav class="navbar navbar-expand-md navbar-dark fixed-top" id="nav">
    <a class="navbar-brand" href="#">
        <img src="{{ asset('img/icons/logo.svg') }}" alt=""> 
        <span><b>urhome</b></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
            <li class="nav-item {{Request::segment(1) == '' ? 'active' : ''}}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item dropdown {{Request::segment(1) == 'properties' ? 'active' : ''}}">
                <a href="/properties" class="nav-link">Properties</a>
            </li>
            <li class="nav-item {{Request::segment(1) == 'about' ? 'active' : ''}}">
                <a class="nav-link" href="/about">About Us</a>
            </li>
            <li class="nav-item {{Request::segment(1) == 'contact' ? 'active' : ''}}">
                <a class="nav-link" href="/contact">Contact Us</a>
            </li>
            
        </ul>
        <ul class="navbar-nav"> 
            <li class="nav-item dropdown">
                
                <a href="#" class="nav-link dropdown-toggle {{Request::segment(1) == 'account' ? 'active' : ''}}" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far right fa-user-circle"></i>
                    @if(Auth::check())
                        {{Auth::user()->user_type->UserType}}
                    @else
                        Account
                    @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="accountDropdown">
                    @if(Auth::check())
                        <a href="/logout" class="dropdown-item">Log Out</a>
                    @else
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#loginModal">Log In</a>
                        <a href="#" class="dropdown-item">Register</a>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    $(window).scroll(() => {
        if ($(window).scrollTop() > 0)
            $("body:not(.nolanding) #nav").addClass("moved");
        else
            $("body:not(.nolanding) #nav").removeClass("moved");
    })
</script>

@if(!Auth::check()) 
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModal">
                        <i class="fas fa-key"></i> &nbsp;
                        Log In
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Account Name:</label>
                            <input placeholder="Enter your account name here..." type="email" name="email" id="email" value="{{old('email')}}" required="required" autocomplete="email" class="form-control form-control-sm">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input placeholder="Enter your password here..." type="password" name="password" id="password" value="{{old('password')}}" required="required" autocomplete="password" class="form-control form-control-sm">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>

                        <div class="form-group">
                            {!! htmlFormSnippet() !!}
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" value="Continue" class="btn btn-primary">
                    </div>
                </form>

                <script>
                    $("#loginModal form").submit((e) => {
                        e.preventDefault()
                        let data = new FormData($("#loginModal form")[0])

                        $("#loginModal input").removeClass('is-invalid')
                        $("#loginModal .invalid-feedback").css('display', 'none').empty()

                        $.ajax({
                            url: $("#loginModal form").attr('action'),
                            method: $("#loginModal form").attr('method'),
                            data,
                            processData: false,
                            contentType: false,
                            success: (result) => {
                                location.reload()
                            },
                            error: (result) => {
                                if(result.responseJSON.errors) {
                                    let {email, password} = result.responseJSON.errors
                                    let captcha = result.responseJSON.errors["g-recaptcha-response"]

                                    if (email) {
                                        $("#loginModal #email").addClass('is-invalid')
                                        $("#loginModal #email+.invalid-feedback").append(email)
                                    }

                                    if (password) {
                                        $("#loginModal #password").addClass('is-invalid')
                                        $("#loginModal #password+.invalid-feedback").append(password)
                                    }

                                    if (captcha) {
                                        $("#loginModal .g-recaptcha+.invalid-feedback").css('display', 'block').append("Are you a robot??")
                                    }
                                }
                            }
                        })
                    })
                </script>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModal">
                        <i class="fas fa-key"></i> &nbsp;
                        Log In
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Account Name:</label>
                            <input placeholder="Enter your account name here..." type="email" name="email" id="email" value="{{old('email')}}" required="required" autocomplete="email" class="form-control form-control-sm">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input placeholder="Enter your password here..." type="password" name="password" id="password" value="{{old('password')}}" required="required" autocomplete="password" class="form-control form-control-sm">
                            <span class="invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" value="Continue" class="btn btn-primary">
                    </div>
                </form>

                <script>
                    $("#loginModal form").submit((e) => {
                        e.preventDefault()
                        let data = new FormData($("#loginModal form")[0])

                        $("#loginModal input").removeClass('is-invalid')
                        $("#loginModal input+.invalid-feedback").empty()

                        $.ajax({
                            url: $("#loginModal form").attr('action'),
                            method: $("#loginModal form").attr('method'),
                            data,
                            processData: false,
                            contentType: false,
                            success: (result) => {
                                location.reload()
                            },
                            error: (result) => {
                                if(result.responseJSON.errors) {
                                    let {email, password} = result.responseJSON.errors

                                    if (email) {
                                        $("#loginModal #email").addClass('is-invalid')
                                        $("#loginModal #email+.invalid-feedback").append(email)
                                    }

                                    if (password) {
                                        $("#loginModal #password").addClass('is-invalid')
                                        $("#loginModal #password+.invalid-feedback").append(password)
                                    }
                                }
                            }
                        })
                    })
                </script>
            </div>
        </div>
    </div>
@endif