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
                    <form class="form-horizontal col-xs-12" action="{{router.getRewriteUri()}}" method="post">
                        <div class="form-group">
                            <div class="col-xs-3 control-label"><b>{{translate['old_password']|capitalize}}</b></div>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{translate['minimum_password']|capitalize}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3 control-label"><b>{{translate['new_password']|capitalize}}</b></div>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="password1" name="password1" placeholder="{{translate['minimum_password']|capitalize}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3 control-label"><b>{{translate['confirm_new_password']|capitalize}}</b></div>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="password2" name="password2" placeholder="{{translate['minimum_password']|capitalize}}" required>
                            </div>
                        </div>
                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                        <div class="form-group pull-right">
                            <div class="col-xs-12">
                                <b> <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">Back</a> </b>
                                <b> <input type="submit" name="submit" class="btn btn-sm btn-primary" value="{{translate['change']|capitalize}}"> </b>
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