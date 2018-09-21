<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="{{assets_url}}thirdparty/img/profile.jpg" width="30%" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <div class="clear">
                        <span class="block m-t-xs">
                            <strong class="font-bold">Admin</strong> <b class="caret"></b>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('/logout')}}">Logout</a></li>
                    </ul>
                </div>
            </li>
            <li {%if module == ""%}class="active"{%endif%}>
                <a href="{{url('/')}}"><i class="fa fa-th-large"></i><span class="nav-label">Home</span>
                </a>
            </li>


            {% for modulename, modulelist in navigationlist %}
                <li {%if module == modulename %}class="active"{%endif%}>
                    <a href="">
                        <i class="fa fa-language"></i>
                        <span class="nav-label">{{modulename}}</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        {% for  controllername , controllerlist in modulelist %}
                            {% if controllerlist|length > 1 %}
                                <li {% if controller == controllername %}class="active" {%endif%}>
                                    <a href="">
                                        <b>{{controllername}} </b>
                                        <i class="fa arrow"></i>
                                    </a>
                                    <ul class="nav nav-third-level collapse">
                            {% endif %}
                            {% for key , value in controllerlist %}
                              {% if value.sidebar_name == "index" %}
                                  {% set actionLink = "" %}
                              {% else %}
                                  {% set actionLink = "/"~value.sidebar_name %}
                              {% endif %}
                              {% if loop.length == 1 %}
                                  <li {% if action == actionname %}}class="active"{%endif%} >
                                      <a href="{{url~modulename~'/'~controllername~actionLink}}"> <b>{{modulename}}/{{controllername}}{{value.sidebar_icon}}</b> </a>
                                  </li>
                              {% else %}
                                  <li {% if action == actionname %}}class="active"{%endif%} >
                                      <a href="{{url~modulename~'/'~controllername~actionLink}}"> <b>{{modulename}}/{{controllername}}{{value.sidebar_icon}}</b>  </a>
                                  </li>
                              {% endif %}
                            {% endfor %}
                            {% if controllerlist|length > 1 %}
                                    </ul>
                                </li>
                            {% endif %}

                        {% endfor %}
                    </ul>
                </li>
            {% endfor %}

            </li>
        </ul>
    </div>
</nav>
