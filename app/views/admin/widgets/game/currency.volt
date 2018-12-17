<div class="panel-body">
    <form class="form-horizontal col-xs-12">
        <div class="list-inline text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-currency">
                {{translate['button_add']}}
            </button>
        </div>
        <ul class="list-inline header-list text-center">
          <li class="col-sm-1 col-xs-1 list-group-item">{{translate['head_list_number']}}</li>
          <li class="col-sm-1 col-xs-1 list-group-item">{{translate['head_list_symbol']}}</li>
          <li class="col-sm-3 col-xs-3 list-group-item">{{translate['head_list_code']}}</li>
          <li class="col-sm-5 col-xs-5 list-group-item">{{translate['head_list_name']}}</li>
          <li class="col-sm-2 col-xs-2 list-group-item">{{translate['head_list_default']}}</li>
        </ul>
        {% if game_currency is not null %}
            {% set i = 1 %}
            {% for gameCurrencyData in game_currency %}
                {% if i%2 == 0 %}
                {% set class = "content-even" %}
                {% else %}
                {% set class = "content-odd" %}
                {% endif %}
                <ul class="list-inline {{class}} text-center">
                    <li class="col-sm-1 col-xs-1 list-group-item">{{i}}</li>
                    <li class="col-sm-1 col-xs-1 list-group-item">{{gameCurrencyData.cu.sy}}</li>
                    <li class="col-sm-3 col-xs-3 list-group-item">{{gameCurrencyData.cu.cd}}</li>
                    <li class="col-sm-5 col-xs-3 list-group-item">{{gameCurrencyData.cu.nm}}</li>
                    <li class="col-sm-2 col-xs-2 list-group-item">
                        {% if gameCurrencyData.df == 1 %}
                            <i class="fa fa-check text-success" data-toggle="tooltip" data-placement="right" title="Default"></i>
                        {% else %}
                            <a href="{{'/game/currency/edit/'~game.id~'?idgc='~gameCurrencyData.id~'&tab=tab-currency'}}">
                                <span class="fa fa-times text-danger"></span>
                            </a>
                        {%endif%}
                    </li>
                </ul>
                {% set i = i +1 %}
            {% endfor %}
        {% else %}
            <h4 class="text-center">{{translate['text_no_data']}}</h4>
        {% endif %}
    </form>
    <small class="col-xs-12 text-left">
        *<span class="fa fa-times text-danger"></span> = Not Default
    </small>

    <!--<div class="row text-center">
        <div class="col-xs-12">
            <ul class="pagination">
            {% set page = pagination %}
            {% if page != null %}
            {% for i in 1..page %}
              <li>
                <a href="{{router.getRewriteUri()~'/?pages='~i}}#tab-currency" {% if i == pages %}class="pagination-numb"{% endif %}>{{i}}</a>
              </li>
            {% endfor %}
            {% endif %}
            </ul>
        </div>
    </div>-->
</div>

{{ widget('GameCurrencyFormAddWidget', ['gameId':game.id, 'gameParent':game.idp, 'gameType':game.tp]) }}
<script>
    $(document).ready(function(){
        if ( $('[data-toggle="tooltip"]').length ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
</script>
