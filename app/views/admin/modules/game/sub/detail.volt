{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>[{{game.nm}}] Detail</h5>
                </div>
                <div class="ibox-content row">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general">General</a></li>
                            <li id="head-tab-currency" class="tab"><a data-toggle="tab" href="#tab-currency">Currency</a></li>
                        </ul>
                        <div class="tab-content padding-0">
                            <div id="tab-general" class="tab-pane">
                                <div class="panel-body">
                                    <form class="form-horizontal col-xs-12" action="#" method="post">
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Type</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Type" class="form-control" class="form-control" value="{{game.tp|gameType}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Game Provider</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Name" class="form-control" value="{{providerGame.nm}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Game</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Name" class="form-control" value="{{game.nm}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Sub-Game Code</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Name" class="form-control" value="{{game.cd}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Sub-Game Name</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Name" class="form-control" value="{{game.nm}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Status</label>
                                            <label class="col-xs-9">
                                                <select class="status form-control">
                                                    {% for key, value in status %}
                                                        <option value="{{game.id~"|"~key}}" {% if game.st == key %}selected{% endif %}>{{translate[value]}}</option>
                                                    {% endfor %}
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                                        <div class="form-group pull-right">
                                            <div class="col-xs-12">
                                                <label>
                                                    <a href="{{url('/'~module~'/'~controller)}}" class="btn btn-sm btn-danger">Back</a>
                                                </label>
                                                <label>
                                                    <a href="{{url('/'~module~'/'~controller~'/edit/'~game.id)}}" class="btn btn-sm btn-info">Edit</a>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="tab-currency" class="tab-pane">
                                {{ widget('GameCurrencyWidget', ["gameId": game.id]) }}
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
                location.href = '/game/sub/status/'+jQuery(this).val();
            });

            var url = window.location.href;
            var activeTab = url.substring(url.indexOf("#") + 1);

            if(url.includes("#") == true){
                $(".tab").removeClass("active");
                $("#head-" + activeTab).addClass("active");

                $(".tab-pane").removeClass("active");
                $("#" + activeTab).addClass("active");
            }else{
                $("#head-tab-general").addClass("active");
                $("#tab-general").addClass("active");
                {% if gameCurrencyData is not null %}
                    $("#head-tab-currency").removeClass("active");
                    $("#tab-currency").removeClass("active");

                    $("#head-tab-endpoint").removeClass("active");
                {% else %}
                    $("#head-tab-general").removeClass("active");
                    $("#tab-general").removeClass("active");

                    $("#head-tab-currency").addClass("active");
                    $("#tab-currency").addClass("active");
                {% endif %}
            }
        });
    </script>
{% endblock %}