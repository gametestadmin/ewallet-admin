<div class="panel-body">
    <form class="form-horizontal col-xs-12">
        <div class="list-inline text-right">
            <div class="row">
                <div class="col-xs-4 text-left">
                    <h4>{{translate['endpoint_type']}}</h4>
                </div>
                <div class="col-xs-8">
                    <select name="endpoint_type" id="endpoint_type">
                        <option value="1">{{translate['text_select_option_transfer']}}</option>
                        <option value="2">{{translate['text_select_option_seamless']}}</option>
                    </select>
                    <button type="button" id="add_new_endpoint" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-endpoint">
                        {{translate['button_add']}}
                    </button>
                </div>
            </div>
        </div>
        <ul class="list-inline header-list text-center">
          <li class="col-xs-1 list-group-item">{{translate['head_list_number']}}</li>
          <li class="col-xs-3 list-group-item">{{translate['head_list_type']}}</li>
          <li class="col-xs-3 list-group-item">{{translate['head_list_endpoint']}}</li>
          <li class="col-xs-4 list-group-item">{{translate['head_list_authentication']}}</li>
          <li class="col-xs-1 list-group-item">&nbsp;</li>
        </ul>
        <div style="height:200px; overflow:auto;" id="transfer_data">
        {% if transfer_provider_game_endpoint is not null %}
            {% set i = 1 %}
            {% for providerGameEndpointData in transfer_provider_game_endpoint %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item"><span id="endpoint_type_{{providerGameEndpointData.id}}" class="hidden">{{providerGameEndpointData.tp}}</span>{{providerGameEndpointData.tp|endPointType}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item"><span id="endpoint_url_{{providerGameEndpointData.id}}">{{providerGameEndpointData.ep}}</span></li>
                    <li class="col-sm-4 col-xs-4 list-group-item" title="{{providerGameEndpointData.idpgea}}"><span id="endpoint_auth_{{providerGameEndpointData.id}}" class="hidden">{{providerGameEndpointData.idpgea}}</span>{{providerGameEndpointData.idpgea|endPointAuth}}</li>
                    <li class="col-sm-1 col-xs-1 list-group-item">
                        <span class="endpoint-edit fa fa-edit text-primary" data-id="{{providerGameEndpointData.id}}" data-toggle="modal" data-target="#form-edit-endpoint"></span>
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4 class="text-center">{{translate['text_no_data']}}</h4>
        {% endif %}
        </div>

        <div style="height:200px; overflow:auto;" id="seamless_data">
        {% if seamless_provider_game_endpoint is not null %}
            {% set i = 1 %}
            {% for providerGameEndpointData in seamless_provider_game_endpoint %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item"><span id="endpoint_type_{{providerGameEndpointData.id}}" class="hidden">{{providerGameEndpointData.tp}}</span>{{providerGameEndpointData.tp|endPointType}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item"><span id="endpoint_url_{{providerGameEndpointData.id}}">{{providerGameEndpointData.ep}}</span></li>
                    <li class="col-sm-4 col-xs-4 list-group-item" title="{{providerGameEndpointData.idpgea}}"><span id="endpoint_auth_{{providerGameEndpointData.id}}" class="hidden">{{providerGameEndpointData.idpgea}}</span>{{providerGameEndpointData.idpgea|endPointAuth}}</li>
                    <li class="col-sm-1 col-xs-1 list-group-item">
                        <span class="endpoint-edit fa fa-edit text-primary" data-id="{{providerGameEndpointData.id}}" data-toggle="modal" data-target="#form-edit-endpoint"></span>
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4 class="text-center">{{translate['text_no_data']}}</h4>
        {% endif %}
        </div>
    </form>
</div>


    <!--<span id="end_type-1" class="hidden">2</span>
    <span id="end_type_method-1" class="hidden">1</span>-->

{{ widget('EndpointFormAddWidget', ["gameId": game.id]) }}
{{ widget('EndpointFormEditWidget', ["gameId": game.id]) }}

<script>
    $(document).ready(function(){
        $("#transfer_type").hide();
        $("#seamless_type").hide();
        $("#seamless_data").hide();

        var endpointType = $("#endpoint_type");
        $("#endpoint_type").change(function () {
            if(endpointType.val() == 1){
                $("#seamless_data").hide();
                $("#transfer_data").show();
            }else{
                $("#transfer_data").hide();
                $("#seamless_data").show();
            }
        });
        $("#add_new_endpoint").click(function () {
            var endpointType = $("#endpoint_type option:selected");
            $(".endpoint_type_text").html(endpointType.text());
            $("#endpoint_type_value").val(endpointType.val());
            if(endpointType.val() == 1){
                $("#seamless_type").hide();
                $("#transfer_type").show();
            }else{
                $("#transfer_type").hide();
                $("#seamless_type").show();
            }
        });

        $(".endpoint-edit").click(function () {
            var endPointId = $(this).data('id');
            var type = $("#endpoint_type_"+endPointId).html();
            var auth = $("#endpoint_auth_"+endPointId).html();
            var url = $("#endpoint_url_"+endPointId).html();
            var dataSplit;
            dataSplit = url.split("//");
            var protocol = dataSplit[0]+"//";


            $(".modal-body #endpoint_id").val(endPointId);
            $(".modal-body #endpoint_type").val(type);
            //$(".modal-body #endpoint_type").html(type);
            $(".modal-body #endpoint_auth").val(auth);
            $(".modal-body #endpoint_protocol").val(protocol);
            $(".modal-body #endpoint_url").val(dataSplit[1]);
        });
    });
</script>