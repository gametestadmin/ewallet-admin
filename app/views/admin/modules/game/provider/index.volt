{% block content %}
<div id="wrapper" class="col-xs-12">
    <div>
        <a href="{{router.getRewriteUri()~'/add'}}">Add</a>
    </div>
    <table>
        <tr bgcolor="#000">
            <td>ID</td>
            <td>Timezone</td>
            <td>Name</td>
            <td>App Id</td>
            <td>App Secret</td>
            <td></td>
            <td></td>
        </tr>
        {% set i = 1 %}
        {% for providerData in provider %}
        <tr>
            <td>{{i}}</td>
            <td>
                {% set gmtDisplay = providerData.timezone %}
                {% if providerData.timezone == 0%}
                {% set gmtDisplay = '' %}
                {% elseif providerData.timezone > 0%}
                {% set gmtDisplay = '+'~providerData.timezone %}
                {% endif %}
                GMT {{gmtDisplay}}
            </td>
            <td>{{providerData.name}}</td>
            <td>{{providerData.app_id}}</td>
            <td>{{providerData.app_secret}}</td>
            <td>
                <select class="status">
                    {% for key, value in status %}
                        <option value="{{providerData.id~"|"~value}}" {% if providerData.status == value %}selected{% endif %}>{{key}}</option>
                    {% endfor %}
                </select>
            </td>
            <td><a href="{{router.getRewriteUri()~'/detail/'~providerData.id|lowercase}}">Detail</a></td>
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