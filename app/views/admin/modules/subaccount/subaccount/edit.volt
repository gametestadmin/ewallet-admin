{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <h5>{{controller|capitalize}} {{module|capitalize}}</h5>
                    </div>
                    <div class="ibox-content row">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li id="head-tab-general" class="tab"><a data-toggle="tab" href="#tab-general"> {{translate['general']}} </a></li>
                                <li id="head-tab-acl" class="tab"><a data-toggle="tab" href="#tab-acl"> {{translate['acl']}} </a></li>
                            </ul>
                            <div class="tab-content padding-0">
                                <div id="tab-general" class="tab-pane">
                                    <div class="panel-body">
                                        <form class="form-horizontal col-xs-12" action="#" method="post">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{translate['username']}} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Type" class="form-control" class="form-control" value="{{childuser.username}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{translate['nickname']}} </label>
                                                <label class="col-xs-9">
                                                    <input type="text" placeholder="Name" class="form-control" value="{{childuser.nickname}}" readonly>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label"> {{translate['status']}} </label>
                                                <label class="col-xs-9">
                                                <select class="status form-control">
                                                    {% for key, value in status %}
                                                        <option value="{{childuser.id~"|"~value}}" {% if childuser.status == value %}selected{% endif %}>{{key}}</option>
                                                    {% endfor %}
                                                </select>
                                                </label>
                                            </div>
                                            <div class="form-group"><div class="hr-line-dashed"></div></div>

                                        </form>
                                    </div>
                                </div>
                                <div id="tab-acl" class="tab-pane">
                                    <div class="panel-body">
                                        <form class="form-horizontal col-xs-12" action="#tab-acl" method="post">
                                            {% for key , value in aclParent %}
                                                {% if aclChild[value.module][value.controller][value.action]['id'] is not defined %}
                                                    {% set aclID = value.id %}
                                                    {% set aclname = "aclParent[]" %}
                                                    {% set aclstatus = 0 %}
                                                {% else %}
                                                    {% set aclID = aclChild[value.module][value.controller][value.action]['id'] %}
                                                    {% set aclname = "aclChild[]" %}
                                                    {% set aclstatus = aclChild[value.module][value.controller][value.action]['status'] %}
                                                {% endif %}
                                                <div class="row">
                                                    <div class="col-xs-4 {% if value.action != null %} col-xs-push-4 {% elseif value.controller != null and value.action == null  %} col-xs-push-2 {% endif %}">
                                                        <input type="checkbox" name="{{ aclname }}" value="{{ aclID }}"
                                                        {% if aclstatus == 1 %} checked="checked" {% endif %}
                                                        {% if value.action != null %} level="subchild" {% elseif value.controller != null and value.action == null  %} level="child" {% else %} level="parent" {% endif %} >
                                                        {{value.sidebar_name}}
                                                    </div>
                                                </div>
                                            {% endfor %}
                                            <div class="form-group"><div class="hr-line-dashed"></div></div>
                                            <div class="form-group pull-right">
                                                <div class="col-xs-12">
                                                    <label>
                                                        <a href="{{url('javascript:history.go(-1)')}}" class="btn btn-sm btn-danger">Back</a>
                                                    </label>
                                                    <label>
                                                        <input type="submit" class="btn btn-sm btn-info" value="Edit">
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
        });
    </script>


    <script>
        $('input[@type=checkbox][level="child"]').click(function (event) {
            var checked = $(this).is(':checked');
            if (checked) {
                $(this).closest('td').parent().children('td').first('td').children('input[@type=checkbox][level="parent"]').attr('checked', true);
            }
        });
    </script>



{% endblock %}