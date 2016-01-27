@extends('master')

@section('nameOfPage', 'Reset Passowrd')

@section('title')
    <h1>Reset Your Password</h1>
    @endsection

    @section('content')
    <p>Type your username(email address) in the text box below. A temporary password will be sent to your email address. </p>
    <form action="processForgotPassword" method="post">
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
@endsection



