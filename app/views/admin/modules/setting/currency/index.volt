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

                <select class="status">
                    {% for key, value in status %}
                        <option value="{{currencyData.code~"|"~value}}" {% if currencyData.status == value %}selected{% endif %}>{{key}}</option>
                    {% endfor %}
                </select>
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
                location.href = document.URL+'/status/'+jQuery(this).val();
            });
        });
    </script>

{% endblock %}