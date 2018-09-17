{% block content %}
<div id="wrapper" class="col-xs-12" style="color:white;">
    <form class="form-horizontal" action="#" method="post">
        <div class="form-group col-xs-12">
            <label>Currency Code</label>
            <label>
                <input type="text" value="{{currency.code}}" readonly>
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Currency Name</label>
            <label>
                <input type="text" name="name" value="{{currency.name}}">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>Currency Symbol</label>
            <label>
                <input type="text" name="symbol" value="{{currency.symbol}}">
            </label>
        </div>
        <div class="form-group col-xs-12">
            <label>
                <a href="javascript:history.go(-1)">Back</a>
            </label>
            <label>
                <input type="submit" name="submit" value="Edit">
            </label>
        </div>
    </form>
</div>
{% endblock %}

{% block action_js %}

{% endblock %}