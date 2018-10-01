{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="loading text-center" style="width:100%;position:absolute;z-index:9; top:25%; margin:0;padding:0;">
                            <img src="{{assets_url}}admin/img/loading.gif">
                        </div>
                        <div class="ibox-title row">
                            <h5>General</h5>
                        </div>
                        <div class="ibox-content row">
                            <form method="post" action="{{router.getRewriteUri()}}" class="form-horizontal col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">Username</label>

                                    <div class="col-xs-2">
                                        <input type="text" class="form-control code" name="agent_code" id="agent-code" value="{{agent.username}}" readonly>
                                    </div>

                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]" id="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                    <!--
                                        9 = company
                                        8 = ssma
                                        7 = sma
                                        6 = ma
                                        5 = a
                                    -->
                                    {% if agent.type == 7 or agent.type == 6 or agent.type == 5 %}
                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]" id="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor%}
                                        </select>
                                    </div>
                                    {% endif %}
                                    {% if agent.type == 5 %}
                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]" id="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor%}
                                        </select>
                                    </div>
                                    {% endif %}
                                    <div class="col-xs-2">
                                        <button class="btn btn-sm btn-warning" id="check-available">{{translate['check']}}</button>
                                    </div>
                                    <div class="col-sm-1 col-xs-2">
                                        <span class="available fa"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Timezone</label>
                                    <label class="col-sm-9">
                                        <select name="timezone" class="form-control">
                                            {% for gmtTime in gmt %}
                                                {% set gmtDisplay = gmtTime %}
                                                {% if gmtTime == 0%}
                                                {% set gmtDisplay = '' %}
                                                {% elseif gmtTime > 0%}
                                                {% set gmtDisplay = '+'~gmtTime %}
                                                {% endif %}
                                                <option value="{{gmtTime}}" {% if gmtTime == 0 %}selected{% endif %}>GMT {{gmtDisplay}}</option>
                                            {% endfor %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Password</label>
                                    <label class="col-sm-9">
                                        <input type="text" class="form-control" name="password">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url(module~"/"~controller)}}" class="btn btn-md btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <input type="submit" class="btn btn-primary" name="submit" value="Add">
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

<script>
    $('.code').change(function(){
        $("#check-available").removeAttr("disabled","disabled");
        $(".available").removeClass("fa-check");
        $(".available").removeClass("fa-times");
    });
    $('.loading').hide();
    $("#check-available").click(function(e) {
        var code = [];
        $(".code").each(function(){
            code.push($(this).val());
        });
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            type: "POST",
            url: '{{url('ajax/agent/check')}}',
            data: {
                "code" : code,
            },
            dataType : "json",
            success: function(result) {
                var response = JSON.stringify(result);
                $('.loading').hide();
                if(response == 0){
                    $("#check-available").attr("disabled", "disabled");
                    $(".available").removeClass("fa-times");
                    $(".available").addClass("fa-check");
                }else{
                    $("#check-available").attr("disabled", "disabled");
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