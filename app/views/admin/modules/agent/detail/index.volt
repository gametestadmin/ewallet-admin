{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>[{{agent.username}}] Detail</h5>
                </div>
                <div class="ibox-content row">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general">General</a></li>
                            <li id="head-tab-currency" class="tab"><a data-toggle="tab" href="#tab-currency">Currency</a></li>
                            <li id="head-tab-game" class="tab"><a data-toggle="tab" href="#tab-game">Game</a></li>
                            <li id="head-tab-ip" class="tab"><a data-toggle="tab" href="#tab-ip">Whitelist IP</a></li>
                        </ul>
                        <div class="tab-content padding-0">
                            <div id="tab-general" class="tab-pane">
                                <div class="panel-body">
                                    <form class="form-horizontal col-xs-12" action="#" method="post">
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Username</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Username" class="form-control" value="{{agent.username}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nickname</label>
                                            <label class="col-sm-9">
                                            {% if realParent is false %}
                                                <input type="text" class="form-control" readonly value="********">
                                            {% else %}
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly value="********">
                                                    <div class="input-group-btn">
                                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="{{'/'~module~'/nickname/reset/'~agent.id}}" id="reset_nickname">
                                                                    Reset Nickname
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            {% endif %}
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Password</label>
                                            <label class="col-sm-9">
                                            {% if realParent is false %}
                                                <input type="text" class="form-control" readonly value="********">
                                            {% else %}
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly value="********">
                                                    <div class="input-group-btn">
                                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="{{'/'~module~'/password/reset/'~agent.id}}">
                                                                    Reset Password
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            {% endif %}
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Agent</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Nickname" class="form-control" value="{{agent.type|agentType}}" readonly>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Timezone</label>
                                            <label class="col-xs-9">
                                                {% set gmtDisplay = agent.timezone %}
                                                {% if agent.timezone == 0%}
                                                {% set gmtDisplay = '' %}
                                                {% elseif agent.timezone > 0%}
                                                {% set gmtDisplay = '+'~agent.timezone %}
                                                {% endif %}
                                                <input type="text" placeholder="Code" class="form-control" value="GMT {{gmtDisplay}}" readonly>
                                            </label>
                                        </div>
                                        {% if realParent is not false %}
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Status</label>
                                            <label class="col-xs-9">
                                                <select class="status form-control">
                                                    {% for key, value in status %}
                                                        <option value="{{agent.id~"|"~value}}" {% if agent.status == value %}selected{% endif %}>{{key}}</option>
                                                    {% endfor %}
                                                </select>
                                            </label>
                                        </div>
                                        {% else %}
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Status</label>
                                            <label class="col-xs-9">
                                                <input type="text" placeholder="Code" class="form-control" value="{{agent.status|agentStatus}}" readonly>
                                            </label>
                                        </div>
                                        {% endif %}
                                        <div class="form-group"><div class="hr-line-dashed"></div></div>
                                        <div class="form-group pull-right">
                                            <div class="col-xs-12">
                                                <label>
                                                    <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">Back</a>
                                                </label>
                                                {% if user.id == agent.parent %}
                                                <label>
                                                    <a href="{{url('/'~module~'/edit/'~agent.id)}}" class="btn btn-sm btn-info">Edit</a>
                                                </label>
                                                {% endif %}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="tab-currency" class="tab-pane">
                                <div class="panel-body">
                                    {{ widget('UserCurrencyWidget', ["id": agent.id,"loginId": user.id,"agentParent": agent.parent]) }}
                                </div>
                            </div>
                            <div id="tab-game" class="tab-pane">
                                <div class="panel-body">
                                    3
                                </div>
                            </div>
                            <div id="tab-ip" class="tab-pane">
                                <div class="panel-body">
                                    {{ widget('UserWhitelistIpWidget', ["id" : agent.id,"loginId": user.id,"agentParent": agent.parent]) }}
                                </div>
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
            $(".tab").removeClass("active");
            $("#head-" + activeTab).addClass("active");

            $(".tab-pane").removeClass("active");
            $("#" + activeTab).addClass("active");
        }else{
            {% if userCurrencyData != 0 %}
                $("#head-tab-currency").removeClass("active");
                $("#tab-currency").removeClass("active");

                $("#head-tab-general").addClass("active");
                $("#tab-general").addClass("active");
            {% else %}
                $("#head-tab-general").removeClass("active");
                $("#tab-general").removeClass("active");

                $("#head-tab-currency").addClass("active");
                $("#tab-currency").addClass("active");
            {% endif %}
        }
    </script>
{% endblock %}