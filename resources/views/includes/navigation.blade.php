<nav class="navigation">
    <div class="logo">
        <div>
            <img src="{{ asset('img/icons/logo.svg')}}" alt="UrHome Logo"> 
            <span> urhome </span>
        </div>

        <div onclick="toggleExpandable('nav_expandable')">
            <i class="mobile-only fas fa-bars"></i>
        </div>
    </div>
    <div class="expandable" id="nav_expandable">
        <ul class="links">
            <li><a href="/">Home</a></li>
            <li class="dropdown">
                <div>
                    <a href="/properties">Properties <i class="wide-only inline fas fa-caret-down"></i> </a>
                    <i class="fas fa fa-caret-down mobile-only" onclick="toggleExpandable('properties')"></i>
                </div>
    
                <ul id="properties">
                    <li><a href="">View Properties</a></li>
                    <li><a href="">Search Properties</a></li>
                </ul>
            </li>
            <li><a href="/about">About Us</a></li>
            <li><a href="/contact">Contact Us</a></li>
        </ul>
    
        <ul class="account">
            <li class="dropdown">
                <div>
                    <a><i class="far fa-user-circle"></i> Account </a>
                    <i class="fas fa fa-caret-down mobile-only" onclick="toggleExpandable('account')"></i>
                </div>
                <ul id="account">
                    <li><a href=""><i class="fas fa-sign-in-alt"></i> Log In</a></li>
                    <li><a href=""><i class="far fa-clipboard"></i> Register</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<script>
    $(window).scroll(() => {
        if ($(window).scrollTop() > 0 && $(window).width() >= 640)
            $(".navigation").addClass("moved");
        else 
            $(".navigation").removeClass("moved");
    })
</script>

<script>
        function toggleExpandable(id) {
            $("#" + id).toggleClass("expanded");
        }
    </script>