{% block content %}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5> <label class="col-xs-12"> {{translate['password_change']|upper}}
                    </label> </h5>
                </div>
                <div class="ibox-content row">
                    <form class="form-horizontal col-xs-12" action="{{router.getRewriteUri()}}" method="post">
                        <div class="form-group">
                            <div class="col-xs-3 control-label"><b>{{translate['password_old']|upper}}</b></div>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{translate['password_old']|upper}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3 control-label"><b>{{translate['password_new']|upper}}</b></div>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="password1" name="password1" placeholder="{{translate['password_new']|upper}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-3 control-label"><b>{{translate['password_confirm_new']|upper}}</b></div>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="password2" name="password2" placeholder="{{translate['password_confirm_new']|upper}}" required>
                            </div>
                        </div>
                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                        <div class="form-group pull-right">
                            <div class="col-xs-12">
                                <b> <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">{{translate['back']|upper}}</a> </b>
                                <b> <input type="submit" name="submit" class="btn btn-sm btn-primary" value="{{translate['change']|upper}}"> </b>
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