{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>[{{provider.name}}] {{translate['title_text_edit']}}</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="{{url(router.getRewriteUri())}}" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Timezone</label>
                                    <label class="col-xs-9">
                                        <select name="provider_timezone" class="form-control">
                                            {% for gmtTime in gmt %}
                                                {% set gmtDisplay = gmtTime %}
                                                {% if gmtTime == 0%}
                                                {% set gmtDisplay = '' %}
                                                {% elseif gmtTime > 0%}
                                                {% set gmtDisplay = '+'~gmtTime %}
                                                {% endif %}
                                                <option value="{{gmtTime}}"{%if provider.timezone == gmtTime%}selected{%endif%}>GMT {{gmtDisplay}}</option>
                                            {% endfor %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" name="provider_name" class="form-control" placeholder="{{translate['placeholder_provider_name']}}" value="{{provider.name}}">
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="javascript:history.go(-1)" class="btn btn-sm btn-danger">{{translate['button_back']}}</a>
                                        </label>
                                        <label>
                                            <input type="submit" name="submit" class="btn btn-sm btn-primary" value="{{translate['button_edit']}}">
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{% endblock %}

{% block action_js %}

{% endblock %}