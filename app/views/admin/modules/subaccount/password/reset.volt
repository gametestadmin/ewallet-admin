{% block content %}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5>{{ translate['password_reset']|upper~' '~subaccountusername|upper }}</h5>
                    </div>
                    <div class="ibox-content row">
                        <div class="panel-body">
                            <form class="form-horizontal col-xs-12" action="{{router.getRewriteUri()}}" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label"> {{ translate['password']|upper }} </label>
                                    <label class="col-xs-9">
                                        <input type="password" placeholder="{{ translate['password']|upper }}" class="form-control" name="password">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{ translate['password_confirm']|upper }}</label>
                                    <label class="col-xs-9">
                                        <input type="password" placeholder="{{ translate['password']|upper }}" class="form-control" name="confirm_password">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                      <label>
                                          <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">{{translate['back']|upper}}</a>
                                      </label>
                                      <label>
                                          <input type="submit" name="submit" class="btn btn-sm btn-primary" value="{{translate['reset']|upper}}">
                                      </label>
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