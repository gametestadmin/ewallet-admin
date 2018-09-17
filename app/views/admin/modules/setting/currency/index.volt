{% block content %}
<div id="wrapper" class="col-xs-12">
    <div class="list black-text">

    <div>
        <a href="{{router.getRewriteUri()~'/add'}}">Add</a>
    </div>
        <div class="row header">
            <div class="col-sm-1">ID</div>
            <div class="col-sm-2">Code</div>
            <div class="col-sm">Name</div>
            <div class="col-sm">Status</div>
            <div class="col-sm"></div>
        </div>
        <div class="content">
        {% set i = 1 %}
        {% for currencyData in currency %}
            <div class="row content-list">
                <div class="col-sm-1">{{i}}</div>
                <div class="col-sm-2">{{currencyData.code}}</div>
                <div class="col-sm">{{currencyData.name}}</div>
                <div class="col-sm">
                    <select class="status">
                        {% for key, value in status %}
                            <option value="{{currencyData.code~"|"~value}}" {% if currencyData.status == value %}selected{% endif %}>{{key}}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class="col-sm">
                    <a href="{{router.getRewriteUri()~'/detail/'~currencyData.code|lowercase}}">Detail</a>
                </div>
            </div>
        {% set i = i +1 %}
        {% endfor %}
        </div>
    </div>
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
                location.href = document.URL+'/status/'+jQuery(this).val();
            });
        });
    </script>

{% endblock %}