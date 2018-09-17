
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 ">

</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
    <select class="header-language-list" name="language" onchange="location = this.value;">
        {% for langkey , language_code in language_list%}
            <option value="/language?code={{language_code}}" {% if language_code == language %} selected {% endif %}> {{translate['language_'~language_code]}} </option>
        {% endfor %}
    </select>
    <a href="{{url('/logout')}}" class="btn btn-primary header-button-logout" >
        Log out
    </a>
</div>



