{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="loading text-center" style="width:100%;position:absolute;z-index:9; top:25%; margin:0;padding:0;">
                            <img src="{{assets_url}}admin/img/loading.gif">
                        </div>
                        <div class="ibox-title row">
                            <h5> {{translate['nickname']}} </h5>
                        </div>
                        <div class="ibox-content row">
                            <form method="post" action="#" class="form-horizontal col-sm-12">
                                <div class="form-group">
                                    <label class="col-xs-2 control-label"> {{translate['nickname']}} </label>
                                    <label class="col-xs-6">
                                        <input type="text" class="form-control uppercase" name="nickname" id="nickname" >
                                    </label>
                                    <div class="col-xs-1">
                                        <span class="available fa"></span>
                                    </div>
                                    <div class="col-xs-3">
                                        <button class="btn btn-sm btn-warning" id="check-available">{{translate['check']}}</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-right">
                                        <label> <a href="{{url(module~"/"~controller)}}" class="btn btn-md btn-danger">Back</a> </label>
                                        <label> <input type="submit" class="btn btn-primary" name="submit" value="{{translate['change']}}"> </label>
                                    </div>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                            </form>
                        </div>
                        <div class="ibox-content row">
                            <form method="post" action="#" class="form-horizontal col-sm-12">
                                <div class="form-group">
                                    <label class="col-xs-2 control-label"> {{translate['nickname']}} </label>
                                    <label class="col-xs-6">
                                        <input type="text" class="form-control uppercase" name="nickname" id="nickname" >
                                    </label>
                                    <div class="col-xs-1">
                                        <span class="available fa"></span>
                                    </div>
                                    <div class="col-xs-3">
                                        <button class="btn btn-sm btn-warning" id="check-available">{{translate['check']}}</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-right">
                                        <label> <a href="{{url(module~"/"~controller)}}" class="btn btn-md btn-danger">Back</a> </label>
                                        <label> <input type="submit" class="btn btn-primary" name="submit" value="{{translate['change']}}"> </label>
                                    </div>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                            </form>
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
                    $("#check-available").attr("disabled", "disabled");
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