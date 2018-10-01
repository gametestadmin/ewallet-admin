{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5> <label class="col-xs-12">
                            {{module|capitalize}}
                            {% if controller != "index" %}
                                >
                                {{controller|capitalize}}
                            {% endif %}
                            {% if action != "index" %}
                                >
                                {{action|capitalize}}
                            {% endif %}
                        </label> </h5>
                    </div>


                            <div class="ibox-content row">
                                <form class="form-horizontal col-xs-12" action="#" method="post">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">{{translate['username']}}</label>
                                        <label class="col-xs-9">
                                            <input type="text" class="form-control" name="username" placeholder="{{translate['username']}}">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">{{translate['password']}}</label>
                                        <label class="col-xs-9">
                                            <input type="password" class="form-control" name="password"placeholder="{{translate['password']}}">
                                        </label>
                                    </div>
                                    <div class="form-group"><div class="hr-line-dashed"></div></div>
                                    <div class="form-group pull-right">
                                        <div class="col-xs-12">
                                            <label>
                                                <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">Back</a>
                                            </label>
                                            <label>
                                                <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Add">
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