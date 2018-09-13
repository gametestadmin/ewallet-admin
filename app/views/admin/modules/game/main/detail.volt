{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Type</label>
            <label>
                <input type="text" placeholder="Type" value="{{game.type|gameType}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Game Code</label>
            <label>
                <input type="text" placeholder="Name" value="{{game.code}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Game Name</label>
            <label>
                <input type="text" placeholder="Name" value="{{game.name}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select class="status">
                {% for key, value in status %}
                    <option value="{{game.id~"|"~value}}" {% if game.status == value %}selected{% endif %}>{{key}}</option>
                {% endfor %}
            </select>
        </div>
        <div class="form-group">
            <label>
                <a href="{{url('/'~module~'/'~controller)}}">Back</a>
            </label>
            <label>
                <a href="{{url('/'~module~'/'~controller~'/edit/'~game.code)}}">Edit</a>
            </label>
        </div>
    </form>

    <form class="form-horizontal">
        <div class="form-group">
            <label>Currency</label>
            <label>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModal">
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

    {{ widget('GameCurrencyWidget', []) }}

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
                location.href = '/game/category/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}