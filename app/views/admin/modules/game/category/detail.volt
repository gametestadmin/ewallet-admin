{% block content %}
<div id="wrapper">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group">
            <label>Category Name</label>
            <label>
                <input type="text" placeholder="Name" value="{{category.name}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Category Code</label>
            <label>
                <input type="text" placeholder="Name" value="{{category.code}}" readonly>
            </label>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select class="status">
                {% for key, value in status %}
                    <option value="{{category.id~"|"~value}}" {% if category.status == value %}selected{% endif %}>{{key}}</option>
                {% endfor %}
            </select>
        </div>
        <div class="form-group">
            <label>
                <a href="{{'/'~module~'/'~controller}}">Back</a>
            </label>
            <label>
                <a href="{{'/'~module~'/'~controller~'/edit/'~category.code|lowercase}}">Edit</a>
            </label>
        </div>
    </form>
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