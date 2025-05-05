@extends('layouts.app')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ramaraja&family=Yeseva+One&display=swap');

        body {
            padding: 0;
            margin: 0;
        }

        .system-title{
            font-family: 'Ramaraja', sans-serif;
            color: #a63522;
            font-size: larger;
        }

        .loginDiv{
            background: linear-gradient(to right, brown, #ff86be); ;
            width: 680px;
            height: 100vh;
        }

        #loginForm{
            background-color: white;
            min-width: 250px;
            width: 70%;
            height: 420px;
            border-radius: 28px;
            border: 2px solid black;
        }

        #loginForm input{
            border: 1px solid black;
            background-color: rgb(214, 214, 214);
        }

        #loginForm button{
            border: 1px solid black;
            background: linear-gradient(to right, brown, #ff86be)
        }

        
    </style>

    <div class="container-fluid d-flex p-0">
        <div class="container-fluid">
            <div class="system-title text-center fw-bold mt-4 fs-1">ST. PETER AND PAUL PARISH <BR> MEMBERSHIP IDENTIFICATION SYSTEM</div>
            <div class="container-fluid d-flex align-items-center justify-content-center mt-0 gap-4 h-75">
                <img src="{{ asset('storage/' . $site_logo1) }}" alt="Logo 1" width="260px">
                <img src="{{ asset('storage/' . $site_logo2) }}" alt="Logo 2" width="260px">
            </div>
        </div>
        <div class="m-0 container-fluid loginDiv d-flex align-items-center justify-content-center">
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="d-flex justify-content-center mt-3 mb-4">
                    <span class="fw-bold fs-6 p-1 ps-4 pe-4 mt-4" style="font-family: 'Times New Roman', Times, serif; background-color: rgb(214, 214, 214); border: 1px solid;">User Log In</span>
                </div>
                <div class="ps-4 pe-4 mb-2">
                    <label class="fw-medium" for="Username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="ps-4 pe-4">
                    <label class="fw-medium" for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <div class="ps-4 pe-4">
                    <button class="btn btn-primary w-100 mt-4" type="submit">Log in</button>
                </div>

                <!-- Show Error -->
                @if ($errors->has('message'))
                    <div class="alert text-danger text-center mt-3">
                        {{ $errors->first('message') }}
                    </div>
                @endif
            </form>
        </div>
    </div>

@endsection