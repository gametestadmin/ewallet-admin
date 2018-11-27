<form class="form-horizontal col-xs-12">
    <ul class="list-inline header-list text-center">
      <li class="col-xs-1 list-group-item"> {{ translate['no']|upper }} </li>
      <li class="col-xs-3 list-group-item"> {{ translate['game']|upper }} </li>
      <li class="col-xs-2 list-group-item"> {{ translate['type']|upper }} </li>
      <li class="col-xs-3 list-group-item"> {{ translate['amount']|upper }} </li>
      <li class="col-xs-3 list-group-item"> {{ translate['transaction_date']|upper }} </li>
    </ul>
    <div style="height:200px; overflow:auto;">
        {% set i = 1 %}
        {% for key, transaction_history in transactionhistory %}
            {% set class = "content-odd" %}
            {% if i%2 == 0 %}
                {% set class = "content-even" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-1 list-group-item"> {{i}} </li>
                <li class="col-xs-3 list-group-item"> {{ game_list[transaction_history['game']] }} </li>
                <li class="col-xs-2 list-group-item"> {{ translate[transactiontype[transaction_history['type']]]|upper  }} </li>
                <li class="col-xs-3 list-group-item"> {{ transaction_history['amount']|number2dec }} </li>
                <li class="col-xs-3 list-group-item"> {{ transaction_history['transaction_date'] }} </li>
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    </div>
</form>