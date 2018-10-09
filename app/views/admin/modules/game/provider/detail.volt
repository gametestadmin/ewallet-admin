{% block content %}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title row">
                            <h5>General</h5>
                        </div>
                        <div class="ibox-content row">
                            <form class="form-horizontal col-xs-12" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Timezone</label>
                                    <label class="col-xs-9">
                                        {% set gmtDisplay = provider.timezone %}
                                        {% if provider.timezone == 0%}
                                        {% set gmtDisplay = '' %}
                                        {% elseif provider.timezone > 0%}
                                        {% set gmtDisplay = '+'~provider.timezone %}
                                        {% endif %}
                                        <input type="text" placeholder="Code" class="form-control" value="GMT {{gmtDisplay}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Name</label>
                                    <label class="col-xs-9">
                                        <input type="text" placeholder="Name" class="form-control" value="{{provider.name}}" readonly>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status</label>
                                    <label class="col-xs-9">
                                        <select class="status form-control">
                                            {% for key, value in status %}
                                                <option value="{{provider.id~"|"~value}}" {% if provider.status == value %}selected{% endif %}>{{key}}</option>
                                            {% endfor %}
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group"><div class="hr-line-dashed"></div></div>
                                <div class="form-group pull-right">
                                    <div class="col-xs-12">
                                        <label>
                                            <a href="{{'/'~module~'/'~controller}}" class="btn btn-sm btn-danger">Back</a>
                                        </label>
                                        <label>
                                            <a href="{{'/'~module~'/'~controller~'/edit/'~provider.id}}" class="btn btn-sm btn-info">Edit</a>
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
                location.href = '/game/provider/status/'+jQuery(this).val();
            });
        });
    </script>
{% endblock %}