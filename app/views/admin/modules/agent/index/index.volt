{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-12 text-right">
                                <a href="{{url(module~'/add/')}}" class="btn btn-sm btn-info">Add</a>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 col-xs-1 list-group-item">No</li>
                          <li class="col-sm-4 col-xs-4 list-group-item">Username</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">Nickname</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">Type</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">&nbsp;</li>
                        </ul>
                        {% set i = 1 %}
                        {% for agentData in agent_list %}
                        {% if i%2 == 0 %}
                        {% set class = "content-even" %}
                        {% else %}
                        {% set class = "content-odd" %}
                        {% endif %}
                        <ul class="list-inline {{class}} text-center">
                            <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                            <li class="col-sm-4 col-xs-4 list-group-item"><a href="{{url(router.getRewriteUri()~'/child/'~agentData.id)}}">{{agentData.username}}</a></li>
                            <li class="col-sm-3 col-xs-3 list-group-item">{{agentData.nickname}}</li>
                            <li class="col-sm-2 col-xs-2 list-group-item text-center">{{agentData.type|agentType}}</li>
                            <li class="col-sm-2 col-xs-2 list-group-item text-center">
                                <a href="{{url('user/'~module~'/detail/'~agentData.id)}}">
                                    <span class="fa fa-search text-danger"></span>
                                </a>
                                |
                                <a href="{{url('user/'~module~'/edit/'~agentData.id)}}">
                                    <span class="fa fa-edit text-primary"></span>
                                </a>
                            </li>
                        </ul>
                        {% set i = i +1 %}
                        {% endfor %}

                        <div class="row text-center">
                            <div class="col-xs-12">
                                <ul class="pagination">
                                {% set totalPage = total_page%}
                                {% if totalPage != null %}
                                {% for i in 1..totalPage %}
                                  <li>
                                    <a href="{{url(module~'/'~controller)}}?pages={{i}}" {% if i == page %}class="pagination-numb"{% endif %}>{{i}}</a>
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