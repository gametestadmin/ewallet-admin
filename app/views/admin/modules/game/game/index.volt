{% block content %}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-xs-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title row">
                        <div class="row">
                            <label class="col-xs-6">
                                Game List
                            </label>
                            <label class="col-xs-6 text-right">
                                <a href="{{router.getRewriteUri()~'/add'}}" class="btn btn-sm btn-info">Add</a>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content row">
                        <ul class="list-inline header-list text-center">
                          <li class="col-sm-1 hidden-xs list-group-item">No</li>
                          <li class="col-sm-3 col-xs-3 list-group-item">Code</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">Name</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">Parent Status</li>
                          <li class="col-sm-2 col-xs-3 list-group-item">Status</li>
                          <li class="col-sm-2 col-xs-2 list-group-item">Action</li>
                        </ul>
                        {% if games is not null %}
                            {% set i = 1 %}
                            {% for gameData in games %}
                                {% if i%2 == 0 %}
                                    {% set class = "content-even" %}
                                {% else %}
                                    {% set class = "content-odd" %}
                                {% endif %}
                                <ul class="list-inline {{class}} text-center">
                                    <li class="col-sm-1 hidden-xs list-group-item">{{i}}</li>
                                    <li class="col-sm-3 col-xs-3 list-group-item">{{gameData.cd}}</li>
                                    <li class="col-sm-2 col-xs-2 list-group-item">{{gameData.nm}}</li>
                                    <li class="col-sm-2 col-xs-2 list-group-item">
                                        {% if gameData.st != 1 or gameData.pst != 1 or gameData.pvst != 1 %}
                                            {% set otherStatus = 'inactive' %}
                                        {% else %}
                                            {% set otherStatus = 'active' %}
                                        {% endif %}
                                        {% if gameData.pst == 0 %}
                                            {% set parentStatus = 'inactive' %}
                                        {% elseif gameData.pst == 2 %}
                                            {% set parentStatus = 'suspended' %}
                                        {% else %}
                                            {% set parentStatus = 'active' %}
                                        {% endif %}
                                        {% if gameData.st == 0 %}
                                            {% set selfStatus = 'inactive' %}
                                        {% elseif gameData.st == 2 %}
                                            {% set selfStatus = 'suspended' %}
                                        {% else %}
                                            {% set selfStatus = 'active' %}
                                        {% endif %}
                                        {% if gameData.pvst == 0 %}
                                            {% set providerStatus = 'inactive' %}
                                        {% elseif gameData.pvst == 2 %}
                                            {% set providerStatus = 'suspended' %}
                                        {% else %}
                                            {% set providerStatus = 'active' %}
                                        {% endif %}
                                        <span class="hidden pst_{{gameData.id}}">{{translate[parentStatus]}}|{{parentStatus}}</span>
                                        <span class="hidden st_{{gameData.id}}">{{translate[selfStatus]}}|{{selfStatus}}</span>
                                        <span class="hidden pvst_{{gameData.id}}">{{translate[providerStatus]}}|{{providerStatus}}</span>
                                        <strong class="text-{{otherStatus}}">{{translate[otherStatus]}}</strong>
                                        <span class="fa fa-question-circle popup_status" data-id="{{gameData.id}}" data-toggle="modal" data-target="#popup-status"></span>
                                    </li>
                                    <li class="col-sm-2 col-xs-3 list-group-item">
                                        <select class="status">
                                            {% for key, value in status %}
                                                <option value="{{gameData.id~"|"~key}}" {% if gameData.st == key %}selected{% endif %}>{{translate[value]}}</option>
                                            {% endfor %}
                                        </select>
                                    </li>
                                    <li class="col-sm-2 col-xs-2 list-group-item">
                                        <a href="{{router.getRewriteUri()~'/detail/'~gameData.id}}">
                                            <span class="fa fa-search text-danger"></span>
                                        </a>
                                        |
                                        <a href="{{router.getRewriteUri()~'/edit/'~gameData.id}}">
                                            <span class="fa fa-edit text-primary"></span>
                                        </a>
                                    </li>
                                </ul>
                                {% set i = i +1 %}
                            {% endfor %}
                        {% else %}
                            <h4 class="text-center">{{translate['text_no_data']}}</h4>
                        {% endif %}
                        <!--<div class="row text-center">
                            <div class="col-xs-12">
                                <ul class="pagination">
                                {% set page = pagination %}
                                {% if page != null %}
                                {% for i in 1..page %}
                                  <li>
                                    <a href="{{url(module~'/'~controller)}}?pages={{i}}" {% if i == pages %}class="pagination-numb"{% endif %}>{{i}}</a>
                                  </li>
                                {% endfor %}
                                {% endif %}
                                </ul>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="popup-status" tabindex="-1" role="dialog" aria-labelledby="popup-status-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="#" method="post" id="form">
                    <div class="modal-header">
                        <label class="col-xs-6">
                            <h3 class="modal-title" id="popup-status-label">Game Status</h3>
                        </label>
                        <label class="col-xs-6">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </label>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Parent Status</label>
                            <label class="col-xs-3 control-label" id="parent_status"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Status</label>
                            <label class="col-xs-3 control-label" id="status"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Provider Status</label>
                            <label class="col-xs-3 control-label" id="provider_status"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{% endblock %}

{% block action_js %}
    <script>
        $(".popup_status").click(function () {
            var id = $(this).data('id');
            var pst = $(".pst_"+id).html().split("|");
            var st = $(".st_"+id).html().split("|");
            var pvst = $(".pvst_"+id).html().split("|");

            $(".modal-body #parent_status").html('<b class="text-'+pst[1]+'">'+pst[0]+'</b>');
            $(".modal-body #status").html('<b class="text-'+st[1]+'">'+st[0]+'</b>');
            $(".modal-body #provider_status").html('<b class="text-'+pvst[1]+'">'+pvst[0]+'</b>');
        });

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
    </script>
{% endblock %}