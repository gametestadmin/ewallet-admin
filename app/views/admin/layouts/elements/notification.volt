<div class="row" >
    <div id="notif-bar" class="col-xs-12" Style="position : absolute ; z-index : 999 ;">
        {% set messages = flash.getMessages() %}
        {% if messages %}
            {% for type, messages in messages %}
                {% if type == 'debug' %}
                {% endif %}
                {% for message in messages %}
                    {% if type == 'error' %}
                    <div class="notification">
                        <div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <i>{{message}}</i>
                        </div>
                    </div>
                    {% elseif type == 'success' %}
                    <div class="notification">
                        <div class="alert alert-success alert-dismissible">
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
        <div id="alert" class="hidden notification" >
            <div id="alert-content" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <i id="alert-message"></i>
            </div>
        </div>
    </div>
</div>