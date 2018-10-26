{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="loading text-center" style="width:100%;position:absolute;z-index:9; top:25%; margin:0;padding:0;">
                            <img src="{{assets_url}}admin/img/loading.gif">
                        </div>
                        {% if real_user.resetnickname == 1 %}
                            <div class="ibox-content row padding-0">
                                <div class="profile-title col-xs-1 text-orange" >
                                    <b> {{translate['nickname']|upper}} </b>
                                </div>
                                <form method="post" action="#" class="form-horizontal col-xs-11 left-vr-line-dashed padding-top-20">
                                    <div class="form-group">
                                        <label class="col-xs-1 control-label"> {{translate['nickname']|upper}} </label>
                                        <label class="col-xs-6">
                                            <input type="text" class="form-control uppercase" name="nickname" id="nickname" >
                                        </label>
                                        <label class="col-xs-5">
                                            <span id="check-availablity" class="available fa"></span>
                                            <button class="btn btn-sm btn-warning profile-btn" id="check-available">{{translate['check']|upper}}</button>
                                            <input type="submit" class="btn btn-primary profile-btn" name="submit" value="{{translate['change']|upper}}">
                                        </label>
                                    </div>

                                    <div class="form-group text-red">
                                        <ul>
                                            <li> Create your personal login id {nickname} for easy login </li>
                                            <li> Nickname must contain 6-15 characters without space and special characters </li>
                                            <li> Once nickname is created, no further change is allowed </li>
                                            <li> Once created , user can only use nickname to login </li>
                                        </ul>

                                    </div>
                                </form>
                            </div>
                        {% endif %}
                        <div class="ibox-content row padding-0 margin-top-5">
                            <div class="profile-title col-xs-1 text-orange" >
                                <b> {{translate['about_me']|upper}} </b>
                            </div>
                            <div class="col-xs-11 left-vr-line-dashed padding-20-0  " >
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <b>{{translate['nickname']|upper}}</b>
                                            <input type="text" class="form-control uppercase margin-top-5" disabled value="{{real_user.nickname}}" >
                                        </div>
                                        <div class="col-xs-6">
                                            <b>{{translate['last_login']|upper}}</b>
                                            <input type="text" class="form-control uppercase margin-top-5" disabled value="{{time}}" >
                                        </div>
                                    </div>
                                    <div class="row  margin-top-20">
                                        <div class="col-xs-6">
                                            <b>{{translate['username']|upper}}</b>
                                            <input type="text" class="form-control uppercase margin-top-5" disabled value="{{real_user.username}}" >
                                        </div>
                                        <div class="col-xs-6">
                                            <b>{{translate['login_ip']|upper}}</b>
                                            <input type="text" class="form-control uppercase margin-top-5" disabled value="{{login_ip}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3 ">
                                    <div class="profile-password-box">
                                        <b>{{translate['password']|upper}}</b>
                                        <input type="password" class="form-control uppercase margin-top-5" name="password" id="password" disabled value="******" >
                                        <b> <a href="{{url('user/password/change')}}" class="btn btn-sm btn-danger margin-top-10 width-100P"> {{translate['password_change']|upper}} </a> </b>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="profile-password-box">
                                        <div class="row" > <b class="col-xs-12" > {{translate['security']|upper}}  </b>  </div>
                                        <div class="row margin-top-5" > <b class="col-xs-12" > <a href="{{url('user/password/change')}}" class="btn btn-sm btn-danger width-100P"> {{translate['manage_whitelist_ip']|upper}} </a>  </b> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{% endblock %}

{% block action_js %}

<script>
    $('#nickname').change(function(){
        $("#check-available").removeAttr("disabled","disabled");
        $(".available").removeClass("fa-check");
        $(".available").removeClass("fa-times");
    });
    $('.loading').hide();
    $("#check-available").click(function(e) {
        e.preventDefault();
        var nickname = $('#nickname').val() ;
        $('.loading').show();

        $.ajax({
            type: "POST",
            url: '{{url('ajax/user/checkNickname')}}',
            data: {
                "nickname" : nickname,
            },
            dataType : "json",
            success: function(result) {
                if(result.status == true){
                    $("#check-available").removeAttr("disabled","disabled");
                    $('.loading').hide();
                    $(".available").removeClass("fa-times");
                    $(".available").addClass("fa-check");
                } else {
                    $("#check-available").removeAttr("disabled","disabled");
                    $('.loading').hide();
                    $(".available").removeClass("fa-check");
                    $(".available").addClass("fa-times");
                }
            },
            error: function(result) {
                $("#check-available").attr("disabled", "disabled");
                $('.loading').hide();
                $(".available").removeClass("fa-check");
                $(".available").addClass("fa-times");
                //console.clear();
            }
        });
        return false;


    });
</script>
{% endblock %}