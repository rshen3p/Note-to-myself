@extends('master')

@section('nameOfPage', 'Register')

@section('title')
    <h1>Register</h1>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <form action="processRegister" method="post">
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" name="pass" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="password"  name="confirmPass" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="form-group">
            <label>Captcha</label>
            <div class="g-recaptcha" data-sitekey="6LdkhRITAAAAAEugcLIYsE2yxd2PmhJwewMZAMgf"></div>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
        <span> Or <a href="home">Login</a></span>
    </form>
    <?php
        echo $error;
    ?>
@endsection



