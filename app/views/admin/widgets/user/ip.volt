<form class="form-horizontal col-xs-12">
    <div class="list-inline text-right">
        {% if realParent == 1 or realParent == 3 %}
        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#form-add-user-ip">
            Add New
        </button>
        {% endif %}
    </div>
    <ul class="list-inline header-list text-center">
      <li class="col-xs-2 list-group-item">No</li>
      <li class="{% if realParent == 1 or realParent == 3 %}col-xs-8{%else%}col-xs-10{%endif%} list-group-item">IP</li>
      {% if realParent == 1 or realParent == 3 %}
        <li class="col-xs-2 list-group-item">&nbsp;</li>
      {% endif %}
    </ul>
    <div style="height:200px; overflow:auto;">
    {% if user_ip is not null %}
        {% set i = 1 %}
        {% for userWhitelistIpData in user_ip %}
            {% if i%2 == 0 %}
            {% set class = "content-even" %}
            {% else %}
            {% set class = "content-odd" %}
            {% endif %}
            <ul class="list-inline {{class}} text-center">
                <li class="col-xs-2 list-group-item">{{i}}</li>
                <li class="{% if realParent == 1 or realParent == 3 %}col-xs-8{%else%}col-xs-10{%endif%} list-group-item"><span id="id_{{userWhitelistIpData.id}}">{{userWhitelistIpData.ip}}</span></li>
                {% if realParent == 1 or realParent == 3 %}
                    <li class="col-xs-2 list-group-item">
                    <!--<span class="ip-edit fa fa-edit text-primary" data-id="{{userWhitelistIpData.id}}" data-toggle="modal" data-target="#form-edit-user-ip"></span>-->
                        <a href="{{url(module~'/whitelist/delete/'~agent.id~'?delete='~userWhitelistIpData.id)}}" class="delete"><span class="ip-edit fa fa-ban text-danger" title="delete"></span></a>
                    </li>
                {% endif %}
            </ul>
            {% set i = i +1 %}
        {% endfor %}
    {% else %}
        <h4 class="text-center">-No data-</h4>
    {% endif %}
    </div>
</form>
{{ widget('UserWhitelistIpFormAddWidget', []) }}
{{ widget('UserWhitelistIpFormEditWidget', ["id": agent.id]) }}

<script>
    $(document).ready(function(){
        $(".delete").click(function(){
            var conf = confirm('Are You Sure?');
            if(!conf){
                return false;
            }
        });
    });
</script>