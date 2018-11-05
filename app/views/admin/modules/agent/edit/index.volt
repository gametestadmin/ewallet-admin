{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>[{{agent.username}}] {{translate['title_text_edit']}}</h5>
                </div>
                <div class="ibox-content row">
                    <div class="panel-body">
                        <form class="form-horizontal col-xs-12" action="{{router.getRewriteUri()}}" method="post">
                            <div class="form-group">
                                <label class="col-xs-3 control-label">{{translate['form_username']}}</label>
                                <label class="col-xs-9">
                                    <input type="text" placeholder="{{translate['placeholder_username']}}" class="form-control" value="{{agent.username}}" readonly>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{translate['form_nickname']}}</label>
                                <label class="col-sm-9">
                                    <input type="text" class="form-control" readonly value="********" placeholder="{{translate['placeholder_nickname']}}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{translate['form_password']}}</label>
                                <label class="col-sm-9">
                                    <input type="text" class="form-control" readonly value="********" placeholder="{{translate['placeholder_password']}}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">{{translate['form_agent']}}</label>
                                <label class="col-xs-9">
                                    <input type="text" placeholder="{{translate['placeholder_agent']}}" class="form-control" value="{{agent.type|agentType}}" readonly>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">{{translate['form_timezone']}}</label>
                                <label class="col-xs-9">
                                    <select name="timezone" class="form-control">
                                        {% for gmtTime in gmt %}
                                            {% set gmtDisplay = gmtTime %}
                                            {% if gmtTime == 0%}
                                            {% set gmtDisplay = '' %}
                                            {% elseif gmtTime > 0%}
                                            {% set gmtDisplay = '+'~gmtTime %}
                                            {% endif %}
                                            <option value="{{gmtTime}}" {% if gmtTime == agent.timezone %}selected{% endif %}>GMT {{gmtDisplay}}</option>
                                        {% endfor %}
                                    </select>
                                </label>
                            </div>
                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                            <div class="form-group pull-right">
                                <div class="col-xs-12">
                                    <label>
                                        <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">{{translate['button_back']}}</a>
                                    </label>
                                    {% if user.id == agent.parent %}
                                    <label>
                                        <input type="submit" name="submit" class="btn btn-sm btn-info" value="{{translate['button_edit']}}">
                                    </label>
                                    {% endif %}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}