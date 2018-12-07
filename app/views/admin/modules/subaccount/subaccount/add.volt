{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5> <label class="col-xs-12"> {{ translate[subaccounttitle]|upper }} </label> </h5>
                    </div>
                    <div class="ibox-content row">
                        <form class="form-horizontal col-xs-12" action="#" method="post">
                            <div class="form-group">
                                <label class="col-xs-3 control-label">{{translate['username']|upper }}</label>

                                <label class="col-xs-2">
                                    <input type="text" disabled class="form-control uppercase" value="{{user.username}}SUB">
                                </label>
                                {% for counteri in 1..3 %}
                                <div class="col-xs-1">
                                    <select class="form-control code" name="code[]">
                                        {% for agentCode in code %}
                                            <option value="{{agentCode}}">{{agentCode}}</option>
                                        {% endfor %}
                                    </select>
                                </div>
                                {% endfor %}
                                <!--
                                <label class="col-xs-7">
                                    <input type="text" class="form-control uppercase" name="username" placeholder="{{translate['username']|upper }}">
                                </label>
                                -->
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">{{translate['password']|upper }}</label>
                                <label class="col-xs-9">
                                    <input type="password" class="form-control" name="password" placeholder="{{translate['password']|upper }}">
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 control-label">{{translate['password_confirm']|upper }}</label>
                                <label class="col-xs-9">
                                    <input type="password" class="form-control" name="password_confirm" placeholder="{{translate['password_confirm']|upper }}">
                                </label>
                            </div>
                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                            <div class="form-group pull-right">
                                <div class="col-xs-12">
                                    <label>
                                        <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">{{translate['back']|upper }}</a>
                                    </label>
                                    <label>
                                        <input type="submit" name="submit" class="btn btn-sm btn-primary" value=" {{translate['add']|upper }}">
                                    </label>
                                </div>
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