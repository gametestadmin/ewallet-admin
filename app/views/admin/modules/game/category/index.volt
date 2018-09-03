{% block content %}
<div id="wrapper">
    <div>
        <a href="{{router.getRewriteUri()~'/add'}}">Add</a>
    </div>
    <table>
        <tr bgcolor="#000">
            <td>ID</td>
            <td>Type</td>
            <td>Code</td>
            <td>Name</td>
            <td>Status</td>
            <td></td>
        </tr>
        {% set i = 1 %}
        {% for categoryData in category %}
        <tr>
            <td>{{i}}</td>
            <td>{{categoryData.type}}</td>
            <td>{{categoryData.code}}</td>
            <td>{{categoryData.name}}</td>
            <td>
                <select class="status">
                    {% for key, value in status %}
                        <option value="{{categoryData.id~"|"~value}}" {% if categoryData.status == value %}selected{% endif %}>{{key}}</option>
                    {% endfor %}
                </select>
            </td>
            <td><a href="{{router.getRewriteUri()~'/detail/'~categoryData.code|lowercase}}">Detail</a></td>
        </tr>
        {% set i = i +1 %}
        {% endfor %}
    </table>
</div>
<a href="/" >homepage</a>
{% endblock %}

{% block action_js %}
    <script>
        jQuery(function () {
            //location.href='game/provider/status/'+jQuery("#status").val();
            jQuery(".status").change(function () {
                location.href = document.URL+'/status/'+jQuery(this).val();
            })
        })
    </script>
{% endblock %}