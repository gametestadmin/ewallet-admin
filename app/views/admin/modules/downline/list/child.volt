{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-12 text-left">
                            {% set type = parent.tp - 1 %}
                            [{{parent.sn}}] {{translate['level_'~type|agentType]}} {{translate['title_text_list']}}
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 hidden-xs list-group-item">{{translate['head_list_number']}}</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">{{translate['head_list_username']}}</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">[{{parent.sn}}] {{translate['head_list_status']}}</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">[{{translate['level_'~type|agentType]}}] {{translate['head_list_status']}}</li>
                          <li class="col-sm-2 col-xs-3 list-group-item">{{translate['head_list_action']}}</li>
                        </ul>
                        {% set i = 1 %}
                        {% for agentData in agent_list %}
                        {% if i%2 == 0 %}
                        {% set class = "content-even" %}
                        {% else %}
                        {% set class = "content-odd" %}
                        {% endif %}
                        <ul class="list-inline {{class}} text-center">
                            <li class="col-sm-1 hidden-xs list-group-item">{{i}}</li>
                            <li class="col-sm-3 col-xs-3 list-group-item">
                                {% if agentData.tp <> 5 %}
                                    <a href="{{url(module~'/'~controller~'/'~action~'/'~agentData.id)}}"><u>{{agentData.sn}}</u></a>
                                {% else %}
                                    {{agentData.sn}}
                                {% endif %}
                            </li>
                            <li class="col-sm-3 col-xs-3 list-group-item"><strong class="text-{{agentData.pst|agentStatus|lower}}">{{translate[agentData.pst|agentStatus|lower]}}</strong></li>
                            <li class="col-sm-3 col-xs-3 list-group-item"><strong class="text-{{agentData.ust|agentStatus|lower}}">{{translate[agentData.ust|agentStatus|lower]}}</strong></li>
                            <li class="col-sm-2 col-xs-3 list-group-item">
                                <a href="{{url(module~'/detail/'~agentData.id)}}">
                                    <i class="fa fa-search text-danger" data-toggle="tooltip" data-placement="left" title="{{translate['text_detail']}}"></i>
                                </a>
                            </li>
                        </ul>
                        {% set i = i +1 %}
                        {% endfor %}

                        <!--<div class="row text-center">
                            <div class="col-xs-12">
                                <ul class="pagination">
                                {% set totalPage = total_page%}
                                {% if totalPage != null %}
                                {% for i in 1..totalPage %}
                                  <li>
                                    <a href="{{url(router.getRewriteUri())}}?pages={{i}}" {% if i == page %}class="pagination-numb"{% endif %}>{{i}}</a>
                                  </li>
                                {% endfor %}
                                {% endif %}
                                </ul>
                            </div>
                        </div>-->
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