{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>{{controller|capitalize}} {{module|capitalize}}</h5>
                </div>
                <div class="ibox-content row">
                    <div class="panel-body">
                        <form class="form-horizontal col-xs-12" action="#" method="post">
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Username</label>
                                <label class="col-xs-9">
                                    <input type="text" placeholder="Username" class="form-control" value="{{agent.username}}" readonly>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nickname</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                    <input type="text" class="form-control" readonly value="********">
                                    <div class="input-group-btn">
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="{{'/'~module~'/nickname/reset/'~agent.id}}" id="reset_nickname">
                                                    Reset Nickname
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                    <input type="text" class="form-control" readonly value="********">
                                    <div class="input-group-btn">
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="{{'/'~module~'/password/reset/'~agent.id}}">
                                                    Reset Password
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Agent</label>
                                <label class="col-xs-9">
                                    <input type="text" placeholder="Nickname" class="form-control" value="{{agent.type|agentType}}" readonly>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Timezone</label>
                                <label class="col-xs-9">
                                    {% set gmtDisplay = agent.timezone %}
                                    {% if agent.timezone == 0%}
                                    {% set gmtDisplay = '' %}
                                    {% elseif agent.timezone > 0%}
                                    {% set gmtDisplay = '+'~agent.timezone %}
                                    {% endif %}
                                    <input type="text" placeholder="Code" class="form-control" value="GMT {{gmtDisplay}}" readonly>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">Status</label>
                                <label class="col-xs-9">
                                    <select class="status form-control">
                                        {% for key, value in status %}
                                            <option value="{{agent.id~"|"~value}}" {% if agent.status == value %}selected{% endif %}>{{key}}</option>
                                        {% endfor %}
                                    </select>
                                </label>
                            </div>
                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                            <div class="form-group pull-right">
                                <div class="col-xs-12">
                                    <label>
                                        <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">Back</a>
                                    </label>
                                    {% if user.id == agent.parent %}
                                    <label>
                                        <a href="{{url('/'~module~'/edit/'~agent.id)}}" class="btn btn-sm btn-info">Edit</a>
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