{% set wholeaclstatus = 0 %}

{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5>{{childuser.username}} </h5>
                    </div>
                    <div class="ibox-content row">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general"> {{ translate['general']|upper }} </a></li>
                                <li id="head-tab-acl" class="tab"><a data-toggle="tab" href="#tab-acl"> {{ translate['acl']|upper }} </a></li>
                            </ul>
                            <div class="tab-content padding-0">
                                <div id="tab-general" class="tab-pane">
                                    <div class="panel-body">
                                        <form class="form-horizontal col-xs-12" action="#" method="post">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{ translate['username']|upper }} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Type" class="form-control uppercase" class="form-control" value="{{childuser.username}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ translate['nickname']|upper }} </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                    <input type="text" class="form-control" readonly value="********">
                                                    <div class="input-group-btn">
                                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="{{'/'~module~'/nickname/reset/'~childuser.id}}" id="reset_nickname"> {{ translate['nickname_reset']|upper }} </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ translate['password']|upper }} </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                    <input type="text" class="form-control" readonly value="********">
                                                    <div class="input-group-btn">
                                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="{{'/'~module~'/password/reset/'~childuser.id}}"> {{ translate['password_reset']|upper }} </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{ translate['status']|upper }} </label>
                                                <label class="col-xs-9">
                                                <select class="status form-control">
                                                    {% for key, value in status %}
                                                        <option value="{{childuser.id~"|"~value}}" {% if childuser.status == value %}selected{% endif %}>{{ key|upper }}</option>
                                                    {% endfor %}
                                                </select>
                                                </label>
                                            </div>
                                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                                            <div class="form-group pull-right">
                                                <div class="col-xs-12">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="tab-acl" class="tab-pane">
                                    <div class="panel-body">
                                        <form class="form-horizontal col-xs-12">
                                            {% for modulename , moduleList in aclParent %}
                                                <div class="row subaccount-border-bottom">
                                                    <div class="col-xs-4">
                                                        <input type="checkbox" disabled hidden {% if aclChild[moduleList['id']] is defined and aclChild[moduleList['id']] == 1 %}  checked="checked" {% endif %}  >
                                                        <b>{{ translate[moduleList['name']]|upper }}</b>
                                                    </div>
                                                    <div class="col-xs-8 level-2-area">
                                                        {% for  controllername , controllerList in moduleList['child'] %}
                                                        {% if controllerList['child']|length > 1 %}
                                                        <div class="row subaccount-border-bottom">
                                                             <div class="col-xs-6">
                                                                <input type="checkbox" disabled {% if aclChild[controllerList['id']] is defined and aclChild[controllerList['id']] == 1 %}  checked="checked" {% endif %} >
                                                                <b>{{ translate[controllerList['name']]|upper }}  </b>
                                                             </div>
                                                             <div class="col-xs-6 level-3-area">
                                                        {% endif %}
                                                            {% for actionkey , action in controllerList['child'] %}
                                                                {% if action != 'index' %}
                                                                    <div class="row subaccount-border-bottom">
                                                                        <div class="col-xs-12">
                                                                            <input type="checkbox" disabled {% if aclChild[action['id']] is defined and aclChild[action['id']] == 1 %}  checked="checked" {% endif %} >
                                                                            <b>{{ translate[action['name']]|upper }}</b>
                                                                        </div>
                                                                    </div>
                                                                {% endif %}
                                                            {% endfor %}
                                                        {% if controllerList['child']|length > 1 %}
                                                             </div>
                                                        </div>
                                                        {% endif %}
                                                        {% endfor %}
                                                    </div>
                                                </div>
                                            {% endfor %}
                                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                                            <div class="form-group pull-right">
                                                <div class="col-xs-12">
                                                    <label>
                                                        <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">{{translate['back']|upper}}</a>
                                                    </label>
                                                    <label>
                                                        <a href="{{url('/'~module~'/'~controller~'/edit/'~childuser.id)}}" class="btn btn-sm btn-info">{{translate['edit']|upper}}</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
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
                location.href = '/subaccount/subaccount/status/'+jQuery(this).val();
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
                $("#head-tab-general").addClass("active");
                $("#tab-general").addClass("active");
            }

            {% if wholeaclstatus == 0 %}
                $(".tab").removeClass("active");
                $(".tab-pane").removeClass("active");

                $("#head-tab-acl").addClass("active");
                $("#tab-acl").addClass("active");
            {% endif %}
        });
    </script>
{% endblock %}