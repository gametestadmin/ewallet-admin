{% block content %}


{{translate['user']}}
                <br>
                <br>

            {% for module, modulelist in navigationlist %}
                <div>
                    <a href="#{{module}}" data-toggle="collapse">{{module}}</a>
                    {% for  controller , controllerlist in modulelist %}
                        <div id="{{module}}"  class="collapse margin-left-20">
                        {% if controllerlist|length > 1 %}
                            <a href="#{{controller}}" data-toggle="collapse"> {{controller}}</a>
                        {% endif %}

                        {% if controllers != 'sidebar_icon'  %}
                            {% for action , value in controllerlist %}
                                {% if loop.length == 1 %}
                                    <a href="{{url~module~'/'~controller~'/'~action}}"> {{module}}/{{controller}}/{{action}} </a>
                                {% else %}
                                    <div id="{{controller}}"  class="collapse margin-left-20">
                                        <a href="{{url~module~'/'~controller~'/'~action}}"> {{module}}/{{controller}}/{{action}} </a>
                                    </div>
                                {% endif %}
                            {% endfor %}
                        {% endif %}

                        </div>
                    {% endfor %}
                </div>
            {% endfor %}


{% endblock %}

{% block action_js %}

{% endblock %}