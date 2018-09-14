<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="{{assets_url}}thirdparty/img/profile.jpg" width="30%" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <div class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Admin</strong></span>
                        <span class="text-muted text-xs block">Game admin <b class="caret"></b></span></div>
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





            <li {%if module == ""%}class="active"{%endif%}><a href="{{url('/')}}"><i class="fa fa-th-large"></i><span class="nav-label">Dashboards</span></a></li>

                <li {%if module == "setting" and controller == "seo" %}class="active"{%endif%}>
                    <a href=""><i class="fa fa-users"></i><span class="nav-label">SEO</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li {%if module == "setting" and controller == "seo" %}class="active"{%endif%}>
                            <a href="{{url('/setting/seo')}}">List</a>
                        </li>
                    </ul>
                </li>

                <li {%if module == "setting" and controller == "game" or controller == "subgame" %}class="active"{%endif%}>
                    <a href=""><i class="fa fa-gamepad"></i><span class="nav-label">Game</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li {%if module == "setting" and controller == "game" or controller == "subgame" %}class="active"{%endif%}>
                            <a href="{{url('/setting/game')}}">List</a>
                        </li>
                    </ul>
                </li>

                <li {%if module == "setting" and controller == "referral" or module == "referral"%}class="active"{%endif%}>
                    <a href=""><i class="fa fa-link"></i><span class="nav-label">Referral</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li {%if module == "referral" and (controller is null or controller == "index" or controller == "detail") %}class="active"{%endif%}>
                            <a href="{{url('/referral')}}">List</a>
                        </li>
                        <li {%if module == "setting" and controller == "referral" %}class="active"{%endif%}>
                            <a href="{{url('/setting/referral')}}">Setting</a>
                        </li>
                    </ul>
                </li>

                <li {%if module == "setting" and controller == "language" %}class="active"{%endif%}>
                    <a href=""><i class="fa fa-language"></i><span class="nav-label">Language</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                    </ul>
                </li>



            </li>
        </ul>
    </div>
</nav>
