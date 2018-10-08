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
                            <div class="col-xs-3 control-label"><b>{{translate['nickname']|capitalize}}</b></div>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="nickname" name="nickname" placeholder="{{translate['nickname']|capitalize}}" required value="{{parameter['nickname']}}">
                            </div>
                            <div class=" col-xs-push-3 col-xs-1 control-label">
                                <button type="button" class="btn btn-sm btn-info" id="check-nickname" onclick="checkNickname()" >
                                    {{translate['check']}}
                                </button>
                            </div>
                        </div>
                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                        <div class="form-group pull-right">
                            <div class="col-xs-12">
                                <b> <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">Back</a> </b>
                                <b> <input type="submit" name="submit" class="btn btn-sm btn-primary" value="{{translate['change']}}"> </b>
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
    <script>
    /*
        $('#check-nickname').click(function(){
            $('#form').submit(function (e) {
                var dataSplit;
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '{{url('ajax/user/checknickname')}}',
                    data: $('#form').serialize(),
                    success: function(data) {
                        if(data == "error"){
                            alert(data);
                            console.log("something");
                        }else{
                            alert(data);
                            console.log("somewhere");
                        }
                    },
                });
                return false;
            });
        });
    */
    </script>


    <script>
    function checkNickname(){
            var data = {nickname:$("#nickname").val()};

            request = $.ajax({
                url: "{{url('/ajax/user/checknickname')}}",
                type: "post",
                data: data
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
            console.log(response);
                if(response.status == true){
                    $.each( response.messages , function ( key , value) {
                        successMessage(value);
                    });
                }else if(response.status == false){
                    $.each( response.messages , function ( key , value) {
                        errorMessage(value);
                    });
                }
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
            });

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
            });
        }

    </script>
{% endblock %}