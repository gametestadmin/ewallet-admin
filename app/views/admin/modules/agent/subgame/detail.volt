{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>[{{agentGame.user.username}} {{agentGame.game.name}}] {{agentGame.game_type|gameType}} Detail</h5>
                </div>
                <div class="ibox-content row">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general">General</a></li>
                            {% if agentGame.game_type == 2 %}
                            <li id="head-tab-subgame" class="tab"><a data-toggle="tab" href="#tab-subgame">Sub Game</a></li>
                            {% endif %}
                        </ul>
                        <div class="tab-content padding-0">
                            <div id="tab-general" class="tab-pane">
                                <div class="panel-body">
                                    <form class="form-horizontal col-xs-12" action="#" method="post">
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Username</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Username" class="form-control" value="{{agentGame.user.username}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Game Name</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Game Name" class="form-control" value="{{agentGame.game.name}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Type</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Type" class="form-control" value="{{agentGame.game_type|gameType}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Position Taking</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Position Taking" class="form-control" value="{{agentGame.user_game_historical_position_taking}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                                        <div class="form-group pull-right">
                                            <div class="col-xs-12">
                                                <label>
                                                    <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">Back</a>
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
                location.href = '/{{module}}/status/'+jQuery(this).val();
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