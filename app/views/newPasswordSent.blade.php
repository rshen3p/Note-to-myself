@extends('master')

@section('nameOfPage', 'Reset Password')

@section('title')
    <h1>Your new temporary is <?php echo $profile[1];?></h1>
@endsection

@section('content')
    <p>Your password has been reset</p>
    <p>An email have been sent to <?php echo $profile[0]; ?></p>
    <p>Please use your new password form now on.</p>
    <p>Login here: <a href="home">log in</a>.</p>
@endsection



