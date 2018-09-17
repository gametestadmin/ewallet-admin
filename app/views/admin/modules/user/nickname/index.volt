{% block content %}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 user-background">
    <div class="row col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 height-480">
        <div class="col-md-6 col-md-push-1 col-sm-12 col-xs-12">
            <div class="row user-header-title">
                <b>{{translate['change_nickname']|uppercase}}</b>
            </div>
            <form id="register-form" class="form-horizontal" method="post" action="{{url('/user/password')}}">
                <div class="row">
                    <div class="pos-absolute user-option-bg height-100P width-100P" ></div>
                    <div class="col-sm-12 col-xs-12 padding-top-5">
                        <div class="form-group pos-relative">
                            <div for="password" class="col-md-12 col-sm-12 col-xs-5 user-content-title"><b>{{translate['old_password']}}</b></div>
                            <div class="col-md-6 col-sm-12 col-xs-7"><input type="password" class="form-control user-content-input" id="password" name="password"></div>
                            <div class="col-md-6 hidden-sm hidden-xs user-help-text">{{translate['minimal_password']}}</div>
                        </div>
                        <div class="form-group pos-relative">
                            <div for="password1" class="col-md-12 col-sm-12 col-xs-5 user-content-title"><b>{{translate['new_password']}}</b></div>
                            <div class="col-md-6 col-sm-12 col-xs-7"><input type="password" class="form-control user-content-input" id="password1" name="password1" ></div>
                            <div class="col-md-6 hidden-sm hidden-xs user-help-text">{{translate['minimal_password']}}</div>
                        </div>
                        <div class="form-group pos-relative">
                            <div for="password2" class="col-md-12 col-sm-12 col-xs-5 user-content-title"><b>{{translate['confirm_new_password']}}</b></div>
                            <div class="col-md-6 col-sm-12 col-xs-7"><input type="password" class="form-control user-content-input" id="password2" name="password2"></div>
                            <div class="col-md-6 hidden-sm hidden-xs user-help-text">{{translate['minimal_password']}}</div>
                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4 submit-button font-size-15">{{translate['update_button']}}</button>
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