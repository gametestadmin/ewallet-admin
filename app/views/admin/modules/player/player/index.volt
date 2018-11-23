{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title row">
                                <h5> <label class="col-xs-12">
                                    {{module|capitalize}}
                                    {% if controller != "index" %}
                                        >
                                        {{controller|capitalize}}
                                    {% endif %}
                                    {% if action != "index" %}
                                        >
                                        {{action|capitalize}}
                                    {% endif %}
                                </label> </h5>
                            </div>
                            <div class="ibox-content row">
                                <ul class="list-inline header-list text-center">
                                  <li class="col-sm-1 col-xs-1 list-group-item">{{ translate['no']|upper }}</li>
                                  <li class="col-sm-4 col-xs-4 list-group-item">{{ translate['code']|upper }}</li>
                                  <li class="col-sm-4 col-xs-4 list-group-item">{{ translate['username']|upper }}</li>
                                  <li class="col-sm-3 col-xs-3 list-group-item">{{ translate['status']|upper }}</li>
                                </ul>
                                {% set i = 1 %}
                                {% for player in user_player %}
                                    {% if i%2 == 0 %}
                                        {% set class = "content-even" %}
                                    {% else %}
                                        {% set class = "content-odd" %}
                                    {% endif %}
                                    <ul class="list-inline {{class}} text-center">
                                        <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                                        <li class="col-sm-4 col-xs-4 list-group-item"> {{player['username']}} </li>
                                        <li class="col-sm-4 col-xs-4 list-group-item"> {{player['code']}} </li>
                                        <li class="col-sm-3 col-xs-3 list-group-item">
                                            <a href="{{url(module~'/'~controller~'/detail/'~player['id'])}}">
                                                <span class="fa fa-search text-danger"></span>
                                            </a>
                                        </li>
                                    </ul>
                                    {% set i = i +1 %}
                                {% endfor %}

                                <div class="row text-center">
                                    <div class="col-xs-12">
                                        <ul class="pagination">
                                        {% set page = pagination %}
                                        {% if page != null %}
                                        {% for i in 1..page %}
                                          <li>
                                            <a href="{{url(module~'/'~controller)}}?pages={{i}}" {% if i == pages %}class="pagination-numb"{% endif %}>{{i}}</a>
                                          </li>
                                        {% endfor %}
                                        {% endif %}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{% endblock %}

{% block action_js %}

{% endblock %}