<form class="form-horizontal col-xs-12">
    <div class="list-inline">
        <div class="text-right">
        {% if realParent == 1 or realParent == 3 %}
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-agent-add-game">
                {{translate['button_add']}}
            </button>
        {% endif %}
        </div>
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item list">{{translate['head_list_number']}}</li>
      <li class="col-xs-3 list-group-item list">{{translate['head_list_game']}}</li>
      <li class="col-xs-2 list-group-item list">{{translate['head_list_game_type']}}</li>
      <li class="col-xs-2 list-group-item list">[Parent] {{translate['head_list_status']}}</li>
      <li class="col-xs-2 list-group-item list">[{{translate['text_game']}}] {{translate['head_list_status']}}</li>
      <li class="col-xs-2 list-group-item list">{{translate['head_list_action']}}</li>
    </ul>
    {% if user_games is not null %}
        {% set i = 1 %}
        {% for userGame in user_games %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-1 list-group-item">{{i}}</li>
                <li class="col-xs-3 list-group-item">{{userGame.gm.nm}}</li>
                <li class="col-xs-2 list-group-item">{{userGame.gmtp|gameType}}</li>
                <li class="col-xs-2 list-group-item">
                    {% if userGame.pst == 0 or userGame.st == 0 or userGame.agst == 0 or userGame.gmst == 0  or userGame.cust == 0 %}
                        {% set otherStatus = 'inactive' %}
                    {% else %}
                        {% set otherStatus = 'active' %}
                    {% endif %}

                    {% if userGame.pst == 0 %}{% set parentStatus = 'inactive' %}{% elseif userGame.pst == 2 %}{% set parentStatus = 'suspended' %}{% else %}{% set parentStatus = 'active' %}{% endif %}
                    {% if userGame.st == 0 %}{% set selfStatus = 'inactive' %}{% elseif userGame.st == 2 %}{% set selfStatus = 'suspended' %}{% else %}{% set selfStatus = 'active' %}{% endif %}
                    {% if userGame.agst == 0 %}{% set agentStatus = 'inactive' %}{% elseif userGame.agst == 2 %}{% set agentStatus = 'suspended' %}{% else %}{% set agentStatus = 'active' %}{% endif %}
                    {% if userGame.gmst == 0 %}{% set gameStatus = 'inactive' %}{% elseif userGame.gmst == 2 %}{% set gameStatus = 'suspended' %}{% else %}{% set gameStatus = 'active' %}{% endif %}
                    {% if userGame.cust == 0 %}{% set currencyStatus = 'inactive' %}{% elseif userGame.cust == 2 %}{% set currencyStatus = 'suspended' %}{% else %}{% set currencyStatus = 'active' %}{% endif %}

                    <span class="hidden pst_{{userGame.id}}">{{translate[parentStatus]}}|{{parentStatus}}</span>
                    <span class="hidden st_{{userGame.id}}">{{translate[selfStatus]}}|{{selfStatus}}</span>
                    <span class="hidden agst_{{userGame.id}}">{{translate[agentStatus]}}|{{agentStatus}}</span>
                    <span class="hidden gmst_{{userGame.id}}">{{translate[gameStatus]}}|{{gameStatus}}</span>
                    <span class="hidden cust_{{userGame.id}}">{{translate[currencyStatus]}}|{{currencyStatus}}</span>
                    <strong class="text-{{otherStatus}}">{{translate[otherStatus]}}</strong>
                    <span class="fa fa-question-circle popup_status" data-id="{{userGame.id}}" data-toggle="modal" data-target="#popup-status"></span>
                </li>
                <li class="col-xs-2 list-group-item"><strong class="text-{{userGame.st|gameStatus|lower}}">{{translate[userGame.st|gameStatus]}}</strong></li>
                <li class="col-xs-2 list-group-item">
                    <a href="{{url(module~'/game/detail/'~userGame.id)}}">
                        <i class="fa fa-search text-danger" data-toggle="tooltip" data-placement="right" title="{{translate['text_detail']}}"></i>
                    </a>
                </li>
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">{{translate['text_no_data']}}</h4>
    {% endif %}
</form>
<!-- Modal -->
    <div class="modal fade" id="popup-status" tabindex="-1" role="dialog" aria-labelledby="popup-status-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" action="#" method="post" id="form">
                    <div class="modal-header">
                        <label class="col-xs-6">
                            <h3 class="modal-title" id="popup-status-label">Sub-Game Status</h3>
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
                            <label class="col-xs-3 control-label">Agent Status</label>
                            <label class="col-xs-3 control-label" id="agent_status"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Game Status</label>
                            <label class="col-xs-3 control-label" id="game_status"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Currency Status</label>
                            <label class="col-xs-3 control-label" id="currency_status"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{ widget('UserGameFormAddWidget', ["loginId" : user.id, "agentId" : agent.id]) }}

<script>
    $(".popup_status").click(function () {
        var id = $(this).data('id');
        var pst = $(".pst_"+id).html().split("|");
        var st = $(".st_"+id).html().split("|");
        var agst = $(".agst_"+id).html().split("|");
        var gmst = $(".gmst_"+id).html().split("|");
        var cust = $(".cust_"+id).html().split("|");

        $(".modal-body #parent_status").html('<b class="text-'+pst[1]+'">'+pst[0]+'</b>');
        $(".modal-body #status").html('<b class="text-'+st[1]+'">'+st[0]+'</b>');
        $(".modal-body #agent_status").html('<b class="text-'+agst[1]+'">'+agst[0]+'</b>');
        $(".modal-body #game_status").html('<b class="text-'+gmst[1]+'">'+gmst[0]+'</b>');
        $(".modal-body #currency_status").html('<b class="text-'+cust[1]+'">'+cust[0]+'</b>');
    });
</script>