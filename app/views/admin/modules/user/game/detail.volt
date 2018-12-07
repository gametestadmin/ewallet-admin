{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>[{{user.username}} {{agentGame.game.name}}] {{translate['title_text_detail']}}</h5>
                </div>
                <div class="ibox-content row">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general">{{translate['tab_general']}}</a></li>
                            {% if agentGame.game_type == 2 %}
                            <li id="head-tab-subgame" class="tab"><a data-toggle="tab" href="#tab-subgame">{{translate['tab_subgame']}}</a></li>
                            {% endif %}
                        </ul>
                        <div class="tab-content padding-0">
                            <div id="tab-general" class="tab-pane">
                                <div class="panel-body">
                                    <form class="form-horizontal col-xs-12" action="#" method="post">
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">{{translate['form_username']}}</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="{{translate['placeholder_username']}}" class="form-control" value="{{agentGame.user.username}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">{{translate['form_game_name']}}</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="{{translate['placeholder_game_name']}}" class="form-control" value="{{agentGame.game.name}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">{{translate['form_game_type']}}</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="{{translate['placeholder_game_type']}}" class="form-control" value="{{agentGame.game_type|gameType}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Status</label>
                                            <label class="col-xs-9">
                                                <select class="status form-control">
                                                    {% for key, value in status %}
                                                        <option value="{{agentGame.game.id~"|"~key}}" {% if agentGame.status == key%}selected{% endif %}>{{translate[value]}}</option>
                                                    {% endfor %}
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                                        <div class="form-group pull-right">
                                            <div class="col-xs-12">
                                                <label>
                                                    <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">{{translate['button_back']}}</a>
                                                </label>
                                                <!--<label>
                                                    <a href="{{url('/'~module~'/edit/'~agent.id)}}" class="btn btn-sm btn-info">Edit</a>
                                                </label>-->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {% if agentGame.game_type == 2 %}
                            <div id="tab-subgame" class="tab-pane">
                                <div class="panel-body">
                                    {{ widget('UserSubGameWidget', ["agentId" : agentGame.user.id,"loginId": user.id, "game": agentGame.game.id]) }}
                                </div>
                            </div>
                            {% endif %}
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
        jQuery(document).ready(function($){
            var select = $('.status');
            var previouslySelected;
            select.focus(function(){
                previouslySelected = this.value;
            }).change(function(){
                var conf = confirm('Are You Sure?');
                if(!conf){
                    this.value = previouslySelected;
                    return;
                }
                location.href = '/{{module}}/{{controller}}/status/'+jQuery(this).val();
            });
        });

        $(document).ready(function(){
            $("a#reset_nickname").click(function(){
                var conf = confirm('Are You Sure?');
                if(!conf){
                    return false;
                }
            });
        });

        var url = window.location.href;
        var activeTab = url.substring(url.indexOf("#") + 1);

        if(url.includes("#") == true){
            {% if agentGame.game_type == 2 %}
                $(".tab").removeClass("active");
                $("#head-" + activeTab).addClass("active");

                $(".tab-pane").removeClass("active");
                $("#" + activeTab).addClass("active");
            {% else %}
                $("#head-tab-general").addClass("active");
                $("#tab-general").addClass("active");
            {% endif %}
        }else{
            $("#head-tab-general").addClass("active");
            $("#tab-general").addClass("active");

        }
    </script>
{% endblock %}