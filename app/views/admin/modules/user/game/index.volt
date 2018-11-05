{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-6">
                                My Game List
                            </label>
                            <label class="col-xs-6 text-right">
                                <a href="{{router.getRewriteUri()~'/add'}}" class="btn btn-sm btn-info">Add</a>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 hidden-xs list-group-item">No</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">Code</li>
                          <li class="col-sm-4 col-xs-4 list-group-item">Name</li>
                          <li class="col-sm-2 col-xs-3 list-group-item">Status</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">Action</li>
                        </ul>
                        {% if page is not null %}
                        {% set i = 1 %}
                        {% for myGame in page %}
                            {% if i%2 == 0 %}
                                {% set class = "content-even" %}
                            {% else %}
                                {% set class = "content-odd" %}
                            {% endif %}
                            <ul class="list-inline {{class}} text-center">
                                <li class="col-sm-1 hidden-xs list-group-item">{{i}}</li>
                                <li class="col-sm-3 col-xs-3 list-group-item">{{myGame.game.code}}</li>
                                <li class="col-sm-4 col-xs-4 list-group-item">{{myGame.game.name}}</li>
                                <li class="col-sm-2 col-xs-3 list-group-item">
                                    <select class="status">
                                        {% for key, value in status %}
                                            <option value="{{myGame.id~"|"~value}}" {% if myGame.status == value %}selected{% endif %}>{{key}}</option>
                                        {% endfor %}
                                    </select>
                                </li>
                                <li class="col-sm-2 col-xs-2 list-group-item">
                                    <a href="{{router.getRewriteUri()~'/detail/'~myGame.game.id}}">
                                        <span class="fa fa-search text-danger"></span>
                                    </a>
                                    |
                                    <a href="{{router.getRewriteUri()~'/edit/'~myGame.game.id}}">
                                        <span class="fa fa-edit text-primary"></span>
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
                        {% else %}
                        <h4 class="text-center">No Data</h4>
                        {% endif %}
                    </div>
                </div>
            </div>
        </div>
    </div>
{% endblock %}

{% block action_js %}

{% endblock %}