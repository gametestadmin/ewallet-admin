{% block content %}
<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3 ">
    <div class="text-center animated fadeInDown">
        <select class="header-language-list float-right margin-top-10" name="language" onchange="location = this.value;">
           {% for langkey , language_code in language_list%}
               <option value="/language?code={{language_code}}" {% if language_code == language %} selected {% endif %}> {{translate['language_'~language_code]}} </option>
           {% endfor %}
        </select>
        <div class="">
            <div>
                <img src="/assets/admin/img/logo.png" width="100%" />
            </div>
            <p class="margin-top-20"> Welcome to TriTech Company :) </p>
            <form class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3" action="{{url('/login')}}" method="post" role="form">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="username" class="form-control" placeholder="Username" required="" tabindex="1">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="password" name="password" class="form-control" placeholder="Password" required="" tabindex="2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="form-group col-xs-12">
                            <input type="text" name="captcha" class="form-control" placeholder="Captcha" required="" tabindex="3" maxlength="4">
                        </div>
                    </div>
                    <div class="">
                        <img src="/captcha" width="60" class="padding-5-0">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="submit" value="Login" class="btn btn-primary block full-width" tabindex="4">
                    </div>
                </div>
                <div class="row">
                    <p> <small>Admin Site © Copyright 2018</small> </p>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}

{% block action_js %}
{% endblock %}