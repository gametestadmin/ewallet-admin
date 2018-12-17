<style>
    .list{
        line-height:50px;
        vertical-align: middle;
    }
    .list-act{
        line-height:25px;
        border-bottom: 1px;
    }
    .text{
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>
<form class="form-horizontal col-xs-12">
    <div class="list-inline">
        <div class="text-right">
        {% if realParent == 1 or realParent == 3 %}
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-user-currency">
                {{translate['button_add']}}
            </button>
        {% endif %}
        </div>
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item list">{{translate['head_list_number']}}</li>
      <li class="col-xs-1 list-group-item list">{{translate['head_list_symbol']}}</li>
      <li class="col-xs-2 list-group-item list">{{translate['head_list_code']}}</li>
      <li class="col-xs-4 list-group-item list">{{translate['head_list_name']}}</li>
      {% if realParent == 1 or realParent == 3 %}
      <li class="col-xs-4 list-group-item list-act">
        <div class="text">{{translate['head_list_action']}}</div>
        <div class="text">
            <span class="col-xs-6">{{translate['head_list_default']}}</span>
            <span class="col-xs-6">{{translate['head_list_delete']}}</span>
        </div>
      </li>
      {% else %}
      <li class="col-xs-4 list-group-item list">{{translate['head_list_default']}}</li>
      {% endif %}
    </ul>
    {% if user_currency is not null %}
        {% set i = 1 %}
        {% for userCurrencyData in user_currency %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-1 list-group-item">{{i}}</li>
                <li class="col-xs-1 list-group-item">{{userCurrencyData.cu.sy}}</li>
                <li class="col-xs-2 list-group-item">{{userCurrencyData.cu.cd}}</li>
                <li class="col-xs-4 list-group-item">{{userCurrencyData.cu.nm}}</li>
                {% if realParent == 1 or realParent == 3 %}
                    <li class="col-xs-2 list-group-item">
                        {% if userCurrencyData.df == 1 %}
                            <i class="fa fa-check text-success" data-toggle="tooltip" data-placement="right" title="{{translate['text_default']}}"></i>
                        {% else %}
                            <a href="{{url('/downline/currency/edit/'~agent.id~'?default='~userCurrencyData.id~'&tab=tab-currency')}}">
                                <i class="fa fa-times text-danger"></i>
                            </a>
                        {%endif%}
                    </li>
                    <li class="col-xs-2 list-group-item">
                        <a href="{{url(module~'/currency/delete/'~agent.id~'?delete='~userCurrencyData.id~'&tab=tab-currency')}}" class="delete"><span class="ip-edit fa fa-ban text-danger" data-toggle="tooltip" data-placement="right" title="Delete"></span></a>
                    </li>
                {% else %}
                    <li class="col-xs-4 list-group-item">
                        {% if userCurrencyData.df == 1 %}
                            <i class="fa fa-check text-success" data-toggle="tooltip" data-placement="right" title="{{translate['text_default']}}"></i>
                        {% else %}
                            <i class="fa fa-times text-danger" data-toggle="tooltip" data-placement="right" title="{{translate['text_not_default']}}"></i>
                        {%endif%}
                    </li>
                {% endif %}
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">{{translate['text_no_data']}}</h4>
    {% endif %}
</form>
<small class="col-xs-12 text-left">
    *<span class="fa fa-times text-danger"></span> = {{translate['important_text_not_default']}}
</small>

{{ widget('UserCurrencyFormAddWidget', ["loginId" : user.id, "agentId" : agent.id]) }}
<script>

</script>
