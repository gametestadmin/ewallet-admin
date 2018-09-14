<div class="row">
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header margin-10-20">
            <a class="navbar-minimalize btn btn-primary">
                <i class="fa fa-bars"></i>
            </a>
            {{ user.username }} / {{ user.code }}
        </div>

        <div class="text-right margin-10-20">
            <select class="header-language-list" name="language" onchange="location = this.value;">
                {% for langkey , language_code in language_list%}
                    <option value="/language?code={{language_code}}" {% if language_code == language %} selected {% endif %}> {{translate['language_'~language_code]}} </option>
                {% endfor %}
            </select>
            <a href="{{url('/logout')}}" class="btn btn-primary header-button-logout" >
                Log out
            </a>
        </div>
    </nav>
</div>