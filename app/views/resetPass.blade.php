@extends('master')

@section('nameOfPage', 'Input New Passowrd')

@section('title')
    <h1>Input New Password</h1>
@endsection

@section('content')
    <p>Reset Your Password</p>
    <form action="processResetPass" method="post">
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <input type="hidden" name="email" class="form-control" value="{{$email}}">
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
@endsection



