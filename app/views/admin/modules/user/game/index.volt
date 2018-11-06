{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-6">
                                [{{user.username}}] {{translate['title_text_game_list']}}
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 hidden-xs list-group-item">{{translate['head_list_number']}}</li>
                          <li class="col-sm-5 col-xs-5 list-group-item">{{translate['head_list_name']}}</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">[{{translate['head_list_parent']}}] {{translate['head_list_status']}}</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">{{translate['head_list_status']}}</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">{{translate['head_list_action']}}</li>
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
                                <li class="col-sm-5 col-xs-5 list-group-item">{{myGame.game.name}}</li>
                                <li class="col-sm-2 col-xs-2 list-group-item">
                                    <strong class="text-{{myGame.parent_status|agentStatus|lower}}">
                                        {{translate[myGame.parent_status|agentStatus|lower]}}
                                    </strong>
                                </li>
                                <li class="col-sm-2 col-xs-2 list-group-item">
                                    <select class="status">
                                        {% for key, value in status %}
                                            <option value="{{myGame.game.id~"|"~key}}" {% if myGame.status == key %}selected{% endif %}>{{translate[value]}}</option>
                                        {% endfor %}
                                    </select>
                                </li>
                                <li class="col-sm-2 col-xs-2 list-group-item">
                                    <a href="{{router.getRewriteUri()~'/detail/'~myGame.id}}">
                                        <span class="fa fa-search text-danger"></span>
                                    </a>
                                    |
                                    <a href="{{router.getRewriteUri()~'/edit/'~myGame.id}}">
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
    <script>
        jQuery(document).ready(function($){
            var select = $('.status');
            var previouslySelected;
            select.focus(function(){
                previouslySelected = this.value;
            }).change(function(){
                var conf = confirm('Are You Sure?');
                if(!conf){
                    this.value = previouslySelected;
                    return;
                }
                location.href = '/{{module}}/{{controller}}/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}