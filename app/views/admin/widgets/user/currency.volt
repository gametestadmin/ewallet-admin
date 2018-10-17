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
        {% if loginId == agentParent %}
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-user-currency">
                Add New
            </button>
        {% endif %}
        </div>
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item list">Symbol</li>
      <li class="col-xs-3 list-group-item list">Code</li>
      <li class="col-xs-4 list-group-item list">Name</li>
      <li class="col-xs-4 list-group-item list-act">
        <div class="text">Action</div>
        <div class="text">
            <span class="col-xs-6">Default</span>
            <span class="col-xs-6">Delete</span>
        </div>
      </li>
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
                <li class="col-xs-1 list-group-item">{{userCurrencyData.currency.symbol}}</li>
                <li class="col-xs-3 list-group-item">{{userCurrencyData.currency.code}}</li>
                <li class="col-xs-4 list-group-item">{{userCurrencyData.currency.name}}</li>
                <li class="col-xs-2 list-group-item">
                    {% if userCurrencyData.default == 1 %}
                        <i class="fa fa-check text-success" data-toggle="tooltip" data-placement="right" title="Default"></i>
                    {% else %}
                        <a href="{{url('/agent/currency/edit/'~agent.id~'?default='~userCurrencyData.id~'&tab=tab-currency')}}">
                            <span class="fa fa-times text-danger"></span>
                        </a>
                    {%endif%}
                </li>
                <li class="col-xs-2 list-group-item">
                    <a href="{{url(module~'/currency/delete/'~agent.id~'?delete='~userCurrencyData.id~'&tab=tab-currency')}}" class="delete"><span class="ip-edit fa fa-ban text-danger" data-toggle="tooltip" data-placement="right" title="Delete"></span></a>
                </li>
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">-No data-</h4>
    {% endif %}
</form>
<small class="col-xs-12 text-left">
    *<span class="fa fa-times text-danger"></span> = Not Default
</small>

{{ widget('UserCurrencyFormAddWidget', ["loginId" : user.id, "agentId" : agent.id]) }}
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
