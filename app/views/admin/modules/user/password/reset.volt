{% block content %}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 user-background">
    <div class="row col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 height-480">
        <div class="col-md-6 col-md-push-1 col-sm-12 col-xs-12">
            <div class="row user-header-title">
                <b>{{translate['reset_password']|uppercase}}</b>
            </div>
            <form id="password-form" class="form-horizontal" method="post" action="{{url('/user/password/reset')}}">
                <div class="row">
                    <div class="pos-absolute user-option-bg height-100P width-100P" ></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-top-5">
                        <div class="form-group pos-relative">
                            <div for="password" class="col-md-12 col-sm-12 col-xs-5"><b>{{translate['username']}}</b></div>
                            <div class="col-md-6 col-sm-12 col-xs-7"><input type="text" class="form-control" id="username" name="username"></div>
                        </div>
                        <div class="form-group pos-relative">
                            <div for="password" class="col-md-12 col-sm-12 col-xs-5"><b>{{translate['password']}}</b></div>
                            <div class="col-md-6 col-sm-12 col-xs-7"><input type="password" class="form-control" id="password" name="password"></div>
                            <div class="col-md-6 hidden-sm hidden-xs">{{translate['minimum_password']}}</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4 submit-button font-size-15">{{translate['update']}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



{% endblock %}




{% block action_js %}

{% endblock %}