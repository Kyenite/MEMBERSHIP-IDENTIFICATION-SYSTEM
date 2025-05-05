@extends('layouts.app')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ramaraja&family=Yeseva+One&display=swap');

        body, main {
            padding: 0;
            margin: 0;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        .custom-header {
            background-color: white;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
            border-bottom: 3px solid brown;
        }

        .col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        /* Custom Griding */

        .box {
            border: 1px solid black;
            background-color: #8B2D1F;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100px;
            cursor: pointer;
        }

        .icon {
            font-size: 30px;
        }

        .text {
            margin-top: 5px;
            font-weight: bold;
        }

        .row:not(:first-child) {
            flex-wrap: nowrap;
            border-right: 1px solid black !important;
            border-left: 1px solid black !important;
        }
        
    </style>

    @include('layouts.header')

    <main>
        <div class="container-fluid d-flex justify-content-center align-items-center" style="background-color: rgb(236, 236, 236); height: calc(100vh - 50px); width: 100vw;">
            <div class="container-fluid text-center" style="width: 380px;">
                <div class="container text-center mt-4">
                    <!-- Full-Width Home Button -->
                    <div class="row mb-1">
                        <div class="box" style="height: 50px;">
                            <i class="fa-solid fa-house icon"></i>
                        </div>
                    </div>
                
                    <!-- 2x3 Grid -->
                    <div class="row gap-1 justify-content-center overflow-hidden">
                        <div class="col-4 box" onclick="window.location.href='{{ url('forum') }}'">
                            <i class="fa-solid fa-comments icon"></i>
                            <span class="text">Forum</span>
                        </div>
                        <div class="col-4 box" onclick="window.location.href='{{ url('registration') }}'">
                            <i class="fa-solid fa-file-pen icon"></i>
                            <span class="text">Registration</span>
                        </div>
                        <div class="col-4 box" onclick="window.location.href='{{ url('list') }}'">
                            <i class="fa-solid fa-table-list icon"></i>
                            <span class="text">List</span>
                        </div>
                    </div>
                    
                    <!-- 3x4 Grid -->
                    <div class="row gap-1 mt-1 justify-content-center overflow-hidden">
                        <div class="col-4 box" onclick="window.location.href='{{ url('donation') }}'">
                            <i class="fa-solid fa-peso-sign icon"></i>
                            <span class="text">Donation</span>
                        </div>
                        <div class="col-4 box">
                            <i class="fa-solid fa-user icon"></i>
                            <span class="text">Profile</span>
                        </div>
                        <div class="col-4 box" onclick="window.location.href='{{ url('profile-settings') }}'">
                            <i class="fa-solid fa-bars icon"></i>
                            <span class="text">Menu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection