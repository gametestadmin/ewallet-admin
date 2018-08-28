{% block content %}
LANGUAGE
    <a href="/language?code=id" >LANGUAGE INDONESIA</a>
    <a href="/language?code=en" >LANGUAGE ENGLISH</a>
this is login.volt
please make sure this is it

<div class="row">
    <div class="text-center margin-0-auto margin-top-20 animated fadeInDown white-text">
        <div>
            <div>
                <h1 class="login-logo">BACKOFFICE</h1>
            </div>
            <p><h2>LOGIN PAGE</h2></p>
            <form action="{{url('/login')}}" method="post" role="form">
                <div class="row form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="" tabindex="1">
                </div>
                <div class="row form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="" tabindex="2">
                </div>
                <div class="row form-group">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <input type="text" name="captcha" class="form-control" placeholder="Captcha" required="" tabindex="3" maxlength="4">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <img src="/captcha" height="40" align="absbottom">
                    </div>
                </div>
                <div class="row form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="submit" value="Login" class="btn btn-primary block full-width">
                </div>
            </form>
            <p> <small>Admin Site © Copyright 2018</small> </p>
        </div>
    </div>
</div>
{% endblock %}

{% block action_js %}
{% endblock %}