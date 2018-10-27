{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>
                                <label class="col-xs-12">
                                    {{ translate['user_whitelist_list']|upper }}
                                </label>
                            </h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="{{'/'~module~'/'~controller~'/add'}}" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label"> {{translate['ip']|upper }} </label>
                                    <label class="col-xs-5">
                                        <input type="text" class="form-control" name="ip" placeholder="{{translate['ip']|upper }}">
                                    </label>
                                    <input class="btn btn-sm btn-primary" type="submit" name="submit" value="{{translate['add']|upper }}">
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="col-xs-6 col-xs-offset-3">
                                    <ul class="list-inline header-list text-center">
                                        <li class="col-xs-10 list-group-item list"> {{translate['ip']|upper }}  </li>
                                        <li class="col-xs-2 list-group-item list"> {{translate['action']|upper }} </li>
                                    </ul>
                                    {% set i = 1 %}
                                    {% for listip in iplist %}
                                        {% if i%2 == 0 %}
                                            {% set class = "content-even" %}
                                        {% else %}
                                            {% set class = "content-odd" %}
                                        {% endif %}
                                        <ul class="list-inline {{class}} text-center">
                                            <li class="col-xs-10 list-group-item"> {{ listip.ip|upper }} </li>
                                            <a href="{{url(module~'/whitelist/delete/'~listip.id)}}" class="delete">
                                                <li class="col-xs-2 list-group-item" data-toggle="tooltip" title="Delete">
                                                        <span class="text-danger ip-edit fa fa-ban"data-placement="right" ></span>
                                                </li>
                                            </a>
                                        </ul>
                                        {% set i = i +1 %}
                                    {% endfor %}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{% endblock %}

{% block action_js %}

{% endblock %}