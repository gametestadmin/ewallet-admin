<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block">
                            <img alt="image" class="large-logo img-responsive" src="{{assets_url}}admin/img/login-logo.png"/>

                            <img alt="image" class="mini-logo hide" src="{{assets_url}}admin/img/icon-login-logo.png" width="65%"/>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{url('user/profile')}}">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('/logout')}}">Logout</a></li>
                    </ul>
                </div>
            </li>
            <li><hr class="header"></li>
            <li {%if module == ""%}class="active"{%endif%}>
                <a href="{{url('/')}}"><i class="fa fa-th-large"></i><span class="nav-label">Home</span>
                </a>
            </li>

            {% for modulename, modulelist in navigationlist %}
                {% if modulename != 'user' %}
                <li {%if module == modulename %}class="active"{%endif%}>
                    <a href="">
                        <i class="fa {{modulelist['icon']}}"></i>
                        <span class="nav-label">{{ translate[modulelist['name']]|upper }}</span>
                        <!--<span class="fa arrow"></span>-->
                    </a>
                    <ul class="nav nav-second-level collapse">
                {% endif %}
                        {% if modulelist['child'] is defined %}
                        {% for  controllername , controllerlist in modulelist['child'] %}
                            {% if controllerlist|length > 1 %}
                                <li {% if controller == controllername %}class="active" {%endif%}>
                                    <a href="">
                                        <i class="fa {{controllerlist['icon']}}"></i>
                                        <b>{{ translate[controllerlist['name']]|upper }}</b>
                                        <!--<i class="fa arrow"></i>-->
                                    </a>
                                    <ul class="nav nav-third-level collapse">
                            {% endif %}
                            {% for actionkey , actionname in controllerlist['child'] %}
                              {% set actionLink = "/"~actionkey %}
                              {% if actionkey == "index" %}
                                  {% set actionLink = "" %}
                              {% endif %}
                              {% if controllername == "index" %}
                                  {% set controllername = "" %}
                              {% endif %}
                              {% if loop.length == 1 %}
                                  <li {% if action == actionkey %}class="active"{%endif%}>
                                      <a href="{{url~modulename~'/'~controllername~actionLink}}">
                                        <i class="fa {{actionname['icon']}}"></i>
                                        <span class="nav-label">{{ translate[actionname['name']]|upper }}</span>
                                      </a>
                                  </li>
                              {% else %}
                                  <li {% if action == actionkey %}class="active"{%endif%}>
                                      <a href="{{url~modulename~'/'~controllername~actionLink}}">
                                        <i class="fa {{actionname['icon']}}"></i>
                                        <b>{{ translate[actionname['name']]|upper }}</b>
                                      </a>
                                  </li>
                              {% endif %}
                            {% endfor %}
                            {% if controllerlist|length > 1 %}
                                    </ul>
                                </li>
                            {% endif %}

                        {% endfor %}
                        {% endif %}
                {% if modulename != 'user' %}
                    </ul>
                </li>
                {% endif %}
            {% endfor %}
        </ul>
    </div>
</nav>
