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
                    Account
                </a>
                <div class="dropdown-menu" aria-labelledby="accountDropdown">
                    <a href="#" class="dropdown-item">Log In</a>
                    <a href="#" class="dropdown-item">Register</a>
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