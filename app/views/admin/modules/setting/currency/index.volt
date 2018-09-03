{% block content %}
<div id="wrapper" style="color:white;">
    <div>
        <a href="{{router.getRewriteUri()~'/add'}}">Add</a>
    </div>
    <table>
        <tr bgcolor="#000">
            <td>ID</td>
            <td>Code</td>
            <td>Name</td>
            <td>Symbol</td>
            <td></td>
            <td></td>
        </tr>
        {% set i = 1 %}
        {% for currencyData in currency %}
        <tr>
            <td>{{i}}</td>
            <td>{{currencyData.code}}</td>
            <td>{{currencyData.name}}</td>
            <td>{{currencyData.symbol}}</td>
            <td>
                {% if currencyData.status == 1 %}
                    <a href="{{router.getRewriteUri()~'/status/'~currencyData.code|lowercase}}">Active</a>
                {%else%}
                    <a href="{{router.getRewriteUri()~'/status/'~currencyData.code|lowercase}}">Inactive</a>
                {% endif %}
            </td>
            <td><a href="{{router.getRewriteUri()~'/detail/'~currencyData.code|lowercase}}">Detail</a></td>
        </tr>
        {% set i = i +1 %}
        {% endfor %}
    </table>
</div>
<a href="/" >homepage</a>
{% endblock %}

{% block action_js %}

{% endblock %}