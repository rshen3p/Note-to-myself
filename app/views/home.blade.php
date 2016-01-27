@extends('master')

@section('nameOfPage', 'Home')

@section('title')
    <h1>Note To Myself</h1>
    @endsection

@section('content')
    <h1></h1>
    <form method="post" action="processLogin">
        <table>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td><a href="register">Register</a> | <a href="forgot">Forgot Password</a></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit"></td>
            </tr>
            <tr>
                <td><a href="https://twitter.com/notes_myself">Twitter</a></td>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </tr>
        </table>
    </form>
@endsection



