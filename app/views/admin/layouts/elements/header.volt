<div class="row">
    <nav class="navbar navbar-static-top header-menu" role="navigation">
        <div class="navbar-header margin-10-20">
            <a class="navbar-minimalize">
                <b class="fa fa-bars header-menu-minimalize"></b>
            </a>
            <span class="header-menu-information">
                <b class="header-info-user"> {{ user.username }} </b>
                <b class="header-info-code"> {{ user.code }} </b>
                <b class="header-info-cur"> Currency </b>
            </span>
        </div>

        <div class="text-right margin-10-20">
            <select class="header-language-list" name="language" onchange="location = this.value;">
                {% for langkey , language_code in language_list%}
                    <option value="/language?code={{language_code}}" {% if language_code == language %} selected {% endif %}> {{translate['language_'~language_code]}} </option>
                {% endfor %}
            </select>
            <a href="{{url('/logout')}}" class="header-button-logout" >
                Log out
            </a>
        </div>
    </nav>
</div>