{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>[{{provider.nm}}] {{translate['title_text_detail']}}</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{translate['form_timezone']}}</label>
                                    <label class="col-xs-9">
                                        {% set gmtDisplay = provider.tz %}
                                        {% if provider.tz == 0%}
                                        {% set gmtDisplay = '' %}
                                        {% elseif provider.tz > 0%}
                                        {% set gmtDisplay = '+'~provider.tz %}
                                        {% endif %}
                                        <input type="text" placeholder="{{translate['placeholder_timezone']}}" class="form-control" value="GMT {{gmtDisplay}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{translate['form_provider_name']}}</label>
                                    <label class="col-xs-9">
                                        <input type="text" placeholder="{{translate['placeholder_provider_name']}}" class="form-control" value="{{provider.nm}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">{{translate['form_status']}}</label>
                                    <label class="col-xs-9">
                                        <select class="status form-control">
                                            {% for key, value in status %}
                                                <option value="{{provider.id~"|"~key}}" {% if provider.st == key %}selected{% endif %}>{{translate[value]}}</option>
                                            {% endfor %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{url('/'~module~'/list')}}" class="btn btn-sm btn-danger">{{translate['button_back']}}</a>
                                        </label>
                                        <label>
                                            <a href="{{url('/'~module~'/edit/'~provider.id)}}" class="btn btn-sm btn-info">{{translate['button_edit']}}</a>
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
                location.href = '/{{module}}/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}