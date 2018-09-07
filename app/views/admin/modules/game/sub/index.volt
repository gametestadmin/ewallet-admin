{% block content %}
<div id="wrapper">
    <div>
        <a href="{{router.getRewriteUri()~'/add'}}">Add</a>
    </div>
    <table>
        <tr bgcolor="#000">
            <td>ID</td>
            <td>Type</td>
            <td>Parent</td>
            <td>Code</td>
            <td>Name</td>
            <td>Status</td>
            <td></td>
        </tr>
        {% set i = 1 %}
        {% for categoryData in category %}
        <tr>
            <td>{{i}}</td>
            <td>{{categoryData.type|gameType}}</td>
            <td>{{categoryData.game_parent|gameName}}</td>
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