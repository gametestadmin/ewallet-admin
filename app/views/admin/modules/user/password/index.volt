{% block content %}
    <div id="page-wrappers" class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <form method="post" action="#" enctype="multipart/form-data" class="form-horizontal">
                            <div class="ibox-title">
                                <h5>Change Password {{user.username}}</h5>
                                <div class="ibox-tools">
                                    <a href="{{url('/user/detail?username='~user.username)}}" class="btn btn-sm btn-default margin-right-10">Back</a>
                                    <input type="submit" class="btn btn-sm btn-primary" value="Change Password">
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="form-group col-xs-12">
                                    <label class="col-md-2 control-label">Username</label>
                                    <div class="col-md-10">
                                        <input type="text" id="username" name="username" class="form-control" readonly="readonly" value="{{user.username}}">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-2 control-label">Nickname</label>
                                    <div class="col-md-10">
                                        <input type="text" id="nickname" name="nickname" class="form-control" readonly="readonly" value="{{user.nickname}}">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-2 control-label">Avatar</label>
                                    <div class="col-md-10">
                                        <img class="small-thumbnail" src="/assets/system/images/avatar/user/{{user.avatar}}" />
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-2 control-label">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" id="password" name="password" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-2 control-label">Confirm Password</label>
                                    <div class="col-md-10">
                                        <input type="password" id="confirm-password" name="confirm_password" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="col-md-2 control-label">Reason</label>
                                    <div class="col-md-10">
                                        <input type="text" id="reason" name="reason" class="form-control" />
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group col-xs-12">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-sm btn-primary pull-right" value="Change Password">
                                        <a href="{{url('/user/detail?username='~user.username)}}" class="btn btn-sm btn-default pull-right margin-right-10">Back</a>
                                    </div>
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