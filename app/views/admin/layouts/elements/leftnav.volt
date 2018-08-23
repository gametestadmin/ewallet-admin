<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="{{assets_url}}thirdparty/img/profile.jpg" width="30%" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Admin</strong></span>
                        <span class="text-muted text-xs block">Game admin <b class="caret"></b></span></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('/logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element"><img alt="image" class="img-circle " src="{{assets_url}}thirdparty/img/profile.jpg" width="50%" /></div>
            </li>
        </ul>
    </div>
</nav>