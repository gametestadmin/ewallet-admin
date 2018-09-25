{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-12 text-right">
                                <a href="{{router.getRewriteUri()~'/add'}}" class="btn btn-sm btn-info">Add</a>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 col-xs-1 list-group-item">No</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">Code</li>
                          <li class="col-sm-4 col-xs-4 list-group-item">Name</li>
                          <li class="col-sm-2 col-xs-3 list-group-item">Status</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">&nbsp;</li>
                        </ul>
                        {% set i = 1 %}
                        {% for mainData in page %}
                        {% if i%2 == 0 %}
                        {% set class = "content-even" %}
                        {% else %}
                        {% set class = "content-odd" %}
                        {% endif %}
                        <ul class="list-inline {{class}} text-center">
                            <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                            <li class="col-sm-3 col-xs-3 list-group-item">{{mainData.code}}</li>
                            <li class="col-sm-4 col-xs-4 list-group-item">{{mainData.name}}</li>
                            <li class="col-sm-2 col-xs-3 list-group-item">
                                <select class="status">
                                    {% for key, value in status %}
                                        <option value="{{mainData.id~"|"~value}}" {% if mainData.status == value %}selected{% endif %}>{{key}}</option>
                                    {% endfor %}
                                </select>
                            </li>
                            <li class="col-sm-2 col-xs-2 list-group-item">
                                <a href="{{router.getRewriteUri()~'/detail/'~mainData.code|lowercase}}">
                                    <span class="fa fa-search text-danger"></span>
                                </a>
                                |
                                <a href="{{router.getRewriteUri()~'/edit/'~mainData.code|lowercase}}">
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