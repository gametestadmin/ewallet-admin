<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
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
                            {% endfor %}
                            {% endfor %}
        </ul>
    </div>
</nav>
