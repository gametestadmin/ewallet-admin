{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="loading text-center" style="width:100%;position:absolute;z-index:9; top:25%; margin:0;padding:0;">
                            <img src="{{assets_url}}admin/img/loading.gif">
                        </div>
                        <div class="ibox-title row">
                            {% set type = user.type - 1 %}
                            <h5>{{translate['text_add']}} {{translate['level_'~type|agentType]}}</h5>
                        </div>
                        <div class="ibox-content row">
                            <form method="post" action="{{router.getRewriteUri()}}" class="form-horizontal col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-12 control-label">{{translate['form_username']}}</label>
                                    {% if agent.type != 0 and agent.type != 9 %}
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control code" name="agent_code" id="agent-code" value="{{agent.username}}" readonly>
                                    </div>
                                    {% endif %}
                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                    {% if agent.type == 6 or agent.type == 5 %}
                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor%}
                                        </select>
                                    </div>
                                    {% endif %}
                                    {% if agent.type == 5 %}
                                    <div class="col-sm-1 col-xs-2">
                                        <select class="form-control code" name="code[]">
                                            {% for agentCode in code %}
                                                <option value="{{agentCode}}">{{agentCode}}</option>
                                            {% endfor%}
                                        </select>
                                    </div>
                                    {% endif %}
                                    <div class="col-xs-3">
                                        <span id="check-availablity" class="available fa"></span>
                                        <button class="btn btn-sm btn-warning" id="check-available">{{translate['button_check_available']}}</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">{{translate['form_timezone']}}</label>
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
                                    <label class="col-sm-3 control-label">{{translate['form_password']}}</label>
                                    <label class="col-sm-9">
                                        <input type="password" class="form-control" name="password" placeholder="{{translate['placeholder_password']}}">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">{{translate['form_confirm_password']}}</label>
                                    <label class="col-sm-9">
                                        <input type="password" class="form-control" name="confirm_password" placeholder="{{translate['placeholder_confirm_password']}}">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">{{translate['form_default_whitelist_ip']}}</label>
                                    <label class="col-sm-9">
                                        <input type="text" class="form-control" name="ip" placeholder="{{translate['placeholder_whitelist_ip']}}">
                                        <small>
                                            <div>{{translate['for_wild_card_ip']}}</div>
                                            <div>{{translate['example_group_ip']}}</div>
                                            <div>{{translate['example_specific_ip']}}</div>
                                        </small>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">{{translate['form_default_currency']}}</label>
                                    <label class="col-sm-9">
                                        <select name="currency" class="form-control">
                                        {% if userCurrency is not null %}
                                            {% for userCurrencyData in userCurrency %}
                                                <option value="{{userCurrencyData.currency.id}}">{{userCurrencyData.currency.name}}</option>
                                            {% endfor %}
                                        {% endif %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url(module~"/list")}}" class="btn btn-md btn-danger">{{translate['button_back']}}</a>
                                        </label>
                                        <label>
                                            <input type="submit" class="btn btn-primary" name="submit" value="{{translate['button_add']}}">
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