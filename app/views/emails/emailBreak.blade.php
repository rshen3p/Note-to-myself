<html>
    <body>
        <h1>BREAK IN.</h1>
        <p>Someone tried to break into your account. Your account has been locked.</p>
        <p>Here is your NEW temporary password: {{$code}}</p><br/>
        <p>please use this password to login from now on</p><br/>
        <p>Use the following link to login again: </p><br/>
        {{URL::to('home')}}
    </body>
</html>