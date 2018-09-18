<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
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
                            {% for actionname , value in controllerlist %}
                              {% if actionname == "index" %}
                                  {% set actionLink = "" %}
                              {% else %}
                                  {% set actionLink = "/"~actionname %}
                              {% endif %}
                              {% if loop.length == 1 %}
                                  <li {% if action == actionname %}}class="active"{%endif%} >
                                      <a href="{{url~modulename~'/'~controllername~actionLink}}"> <span class="nav-label">{{modulename}}/{{controllername}}/{{actionname}}</span> </a>
                                  </li>
                              {% else %}
                                  <li {% if action == actionname %}}class="active"{%endif%} >
                                      <a href="{{url~modulename~'/'~controllername~actionLink}}"> <span class="nav-label">{{modulename}}/{{controllername}}/{{actionname}}</span>  </a>
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
