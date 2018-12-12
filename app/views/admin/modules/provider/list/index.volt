{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-6">
                                {{translate['title_text_game_provider_list']}}
                            </label>
                            <label class="col-xs-6 text-right">
                                <a href="{{url(module~'/add')}}" class="btn btn-sm btn-info">{{translate['button_add']}}</a>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 col-xs-1 list-group-item">{{translate['head_list_number']}}</li>
                          <li class="col-sm-3 col-xs-2 list-group-item">{{translate['head_list_timezone']}}</li>
                          <li class="col-sm-4 col-xs-4 list-group-item">{{translate['head_list_name']}}</li>
                          <li class="col-sm-2 col-xs-3 list-group-item">{{translate['head_list_status']}}</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">{{translate['head_list_action']}}</li>
                        </ul>
                        {% if provider is not null %}
                            {% set i = 1 %}
                            {% for providerData in provider %}
                                {% if i%2 == 0 %}
                                    {% set class = "content-even" %}
                                {% else %}
                                    {% set class = "content-odd" %}
                                {% endif %}
                                <ul class="list-inline {{class}} text-center">
                                    <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                                    <li class="col-sm-3 col-xs-2 list-group-item">
                                        {% set gmtDisplay = providerData.tz %}
                                        {% if providerData.tz == 0%}
                                        {% set gmtDisplay = '' %}
                                        {% elseif providerData.tz > 0%}
                                        {% set gmtDisplay = '+'~providerData.tz %}
                                        {% endif %}
                                        GMT {{gmtDisplay}}
                                    </li>
                                    <li class="col-sm-4 col-xs-4 list-group-item">{{providerData.nm}}</li>
                                    <li class="col-sm-2 col-xs-3 list-group-item">
                                        <select class="status">
                                            {% for key, value in status %}
                                                <option value="{{providerData.id~"|"~key}}" {% if providerData.st == key %}selected{% endif %}>{{translate[value]}}</option>
                                            {% endfor %}
                                        </select>
                                    </li>
                                    <li class="col-sm-2 col-xs-2 list-group-item text-center">
                                        <a href="{{url(module~'/detail/'~providerData.id)}}">
                                            <i class="fa fa-search text-danger" data-toggle="tooltip" data-placement="left" title="{{translate['text_detail']}}"></i>
                                        </a>
                                        |
                                        <a href="{{url(module~'/edit/'~providerData.id)}}">
                                            <i class="fa fa-edit text-primary" data-toggle="tooltip" data-placement="right" title="{{translate['text_edit']}}"></i>
                                        </a>
                                    </li>
                                </ul>
                            {% set i = i +1 %}
                            {% endfor %}
                        {% else %}
                            <h4 class="text-center">{{translate['text_no_data']}}</h4>
                        {% endif %}

                        <!--<div class="row text-center">
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
                location.href = '/{{module}}/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}