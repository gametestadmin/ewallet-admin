<nav>
    <div class="navigation-header margin-top-20 text-center">
        <div class="dropdown">
            <div>
                <img alt="image" class="border-radius-10" src="{{assets_url}}thirdparty/img/profile.jpg" width="50%" />
            </div>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"><strong class="font-bold">Admin</strong></span>s
            </a>
            <ul class="dropdown-menu">
                <a href="#"><li class="dropdown-list" > Profile </li></a>
                <a href="#"><li class="dropdown-list" > Contacts </li></a>
                <a href="#"><li class="dropdown-list" > Mailbox </li></a>
                <a href="{{url('/logout')}}"><li class="dropdown-list" > Logout </li></a>
            </ul>
        </div>
    </div>
    <div>
    {% for module, modulelist in navigationlist %}
        <div>
            <a href="#{{module}}" data-toggle="collapse">{{module}}</a>
            {% for  controller , controllerlist in modulelist %}
                {% set controllerLink = controller %}
                {% if action == 'index' %}
                    {% set controllerLink = "" %}
                {% endif %}
                <div id="{{module}}"  class="collapse margin-left-20">
                {% if controllerlist|length > 1 %}
                    <a href="#{{controller}}" data-toggle="collapse"> {{controller}}</a>
                {% endif %}
                {% for action , value in controllerlist %}
                    {% set actionLink = action %}
                    {% if action == 'index' %}
                        {% set actionLink = "" %}
                    {% endif %}
                    {% if loop.length == 1 %}
                        <a href="{{url~module~'/'~controllerLink~'/'~actionLink}}"> {{module}}/{{controller}}/{{action}} </a>
                    {% else %}
                        <div id="{{controller}}"  class="collapse margin-left-20">
                            <a href="{{url~module~'/'~controllerLink~'/'~actionLink}}"> {{module}}/{{controller}}/{{action}} </a>
                        </div>
                    {% endif %}
                {% endfor %}
                </div>
            {% endfor %}
        </div>
    {% endfor %}
    </div>
</nav>