{% set messages = flash.getMessages() %}
{% if messages %}
    {% for type, messages in messages %}
    {{type}}
        {% if type == 'debug' %}
        {% endif %}
        {% for message in messages %}
            {% if type == 'error' %}
            <div class="notification">
                <div class="alert alert-danger alert-dismissible fade">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i>{{message}}</i>
                </div>
            </div>
            {% elseif type == 'success' %}
            <div class="notification">
                <div class="alert alert-success alert-dismissible fade">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i>{{message}}</i>
                </div>
            </div>
            {% elseif type == 'notice' %}
                <div class="notification">
                    {{message}}
                </div>
            {% endif %}
        {% endfor %}
    {% endfor %}
{% endif %}