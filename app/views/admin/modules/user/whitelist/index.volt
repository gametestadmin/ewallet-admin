{% block content %}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title row">
                    <h5>
                        <label class="col-xs-12">
                            {{ translate['manage_whitelist_ip']|upper }}
                        </label>
                    </h5>
                </div>
                <div class="ibox-content row">

                    <div class="list-inline text-right">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-add-user-ip">
                            {{ translate['add_new']|upper }}
                        </button>
                    </div>
                    <form class="form-horizontal col-xs-12">
                        <div class="col-xs-6 col-xs-offset-3">
                            <ul class="list-inline header-list text-center">
                                <li class="col-xs-10 list-group-item list"> {{translate['ip']|upper }}  </li>
                                <li class="col-xs-2 list-group-item list"> {{translate['action']|upper }} </li>
                            </ul>
                            {% set i = 1 %}
                            {% for listip in iplist %}
                                {% if i%2 == 0 %}
                                    {% set class = "content-even" %}
                                {% else %}
                                    {% set class = "content-odd" %}
                                {% endif %}
                                <ul class="list-inline {{class}} text-center">
                                    <li class="col-xs-10 list-group-item"> {{ listip.ip|upper }} </li>
                                    <a href="{{url(module~'/whitelist/delete/'~listip.id)}}" class="delete">
                                        <li class="col-xs-2 list-group-item" data-toggle="tooltip" title="Delete">
                                                <span class="text-danger ip-edit fa fa-ban"data-placement="right" ></span>
                                        </li>
                                    </a>
                                </ul>
                                {% set i = i +1 %}
                            {% endfor %}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="form-add-user-ip" tabindex="-1" role="dialog" aria-labelledby="form-add-user-ip-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="{{url('user/whitelist/add')}}" method="post" id="form">
            <div class="modal-header">
                <label class="col-xs-6">
                    <span class="modal-title" id="modalLabel">{{ translate['add_whitelist_ip']|upper }} </span>
                </label>
                <label class="col-xs-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </label>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-xs-3 control-label">{{ translate['ip']|upper }}</label>
                    <label class="col-xs-9">
                        <input type="hidden" name="user" value="{{agent.id}}">
                        <input type="hidden" name="tab" value="tab-ip">
                        <input type="text" name="ip" class="form-control">
                    </label>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate['close']|upper }}</button>
                    <button type="submit" class="btn btn-primary" id="submit">{{ translate['add']|upper }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}

{% block action_js %}
<script>
    $(document).ready(function(){
        $(".delete").click(function(){
            var conf = confirm('{{ translate['are_you_sure_?']|upper }}');
            if(!conf){
                return false;
            }
        });
    });
</script>
{% endblock %}