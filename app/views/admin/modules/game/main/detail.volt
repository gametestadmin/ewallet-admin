{% block content %}
        {{ widget('MenuWidget', []) }}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>General</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Type</label>
                                    <label class="col-xs-9">
                                        <input type="text" placeholder="Type" class="form-control" value="{{game.type|gameType}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Game Code</label>
                                    <label class="col-xs-9">
                                        <input type="text" placeholder="Name" class="form-control" value="{{game.code}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Game Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" placeholder="Name" class="form-control" value="{{game.name}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status</label>
                                    <label class="col-xs-9">
                                        <select class="status form-control">
                                            {% for key, value in status %}
                                                <option value="{{game.id~"|"~value}}" {% if game.status == value %}selected{% endif %}>{{key}}</option>
                                            {% endfor %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url('/'~module~'/'~controller)}}" class="btn btn-sm btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <a href="{{url('/'~module~'/'~controller~'/edit/'~game.code)}}" class="btn btn-sm btn-info">Edit</a>
                                        </label>
                                    </div>
                                </div>
                            </form>

                            <form class="form-horizontal col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-3">Currency</label>
                                    <label class="col-xs-9">
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
                                            Add New
                                        </button>
                                    </label>
                                </div>
                                <table>
                                    <tr bgcolor="#000">
                                        <td>Code</td>
                                        <td>Name</td>
                                        <td>Symbol</td>
                                        <td></td>
                                    </tr>
                                    {% if gameCurrency is null %}
                                        no currency
                                    {% else %}
                                        {% for gameCurrencyData in gameCurrency %}
                                        <tr>
                                            <td>{{gameCurrencyData.currency.code}}</td>
                                            <td>{{gameCurrencyData.currency.name}}</td>
                                            <td>{{gameCurrencyData.currency.symbol}}</td>
                                            <td>
                                                {% if gameCurrencyData.default == 1 %}
                                                    Default
                                                {% else %}
                                                    <a href="{{'/game/currency/edit/'~game.id~'|'~gameCurrencyData.id}}">Make Default</a>
                                                {%endif%}
                                            </td>
                                        </tr>
                                        {% endfor %}
                                    {% endif %}
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{ widget('GameCurrencyWidget', []) }}
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
                location.href = '/game/category/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}