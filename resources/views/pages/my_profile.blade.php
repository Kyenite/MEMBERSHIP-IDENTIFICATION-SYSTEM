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
            border-bottom: 2px solid brown;
            flex-wrap: nowrap;
        }

        .floating-header {
            background-color: brown;
            height: 58px;
            border: 2px solid black;
        }

        .main-container {
            min-width: 300px;
            width: 650px !important;
            max-width: 680px !important;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .ellipsis-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        /* Message CSS */
        .menu-box {
            width: 280px;
            height: 480px;
            background-color: #ebdc95;
        }

        .custom-btn {
            background-color: #c76655;
            width: 260px;
            margin: 5px;
            border-radius: 20px;
            font-weight: 500;
        }

        .custom-btn:hover {
            background-color: #b96759;
            color: white;
        }

        /* Modal CSS */
        .modal .form-control {
            border: 2px solid #a63522 !important;
            background-color: #f8eaa0;
        }

        .modal .form-label {
            font-weight: 500;
        }

        .modal .form-check-input {
            border: 1px solid #a63522 !important;
        }
        
    </style>

    @include('layouts.header')

    <!-- Main Content -->
    <main>
        <div class="container-fluid p-0" style="background-color: rgb(236, 236, 236); height: calc(100vh - 50px); width: 100vw;">
            <!-- Floating Header -->
            <div class="container-fluid floating-header d-flex justify-content-between align-items-center">
                <!-- Floating Brand -->
                <div class="d-flex justify-content-between align-items-end gap-2 pb-2 pt-1" style="width: fit-content;">
                    <i class="fa-solid fa-bars fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white"></div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('home') }}'"></span>
            </div>

            <!-- Menu Box -->
            <div class="d-flex justify-content-start">
                <div class="menu-box d-flex flex-column">

                    <!-- Custom BTN Container -->
                    <div class="mb-2" style="border-bottom: 2px solid brown;">
                        <div class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#updateLogoModal">
                            Logo & Branding
                        </div>
                    </div>

                    <!-- Upload Text -->
                    <div class="d-flex justify-content-center align-items-center gap-2" style="height: 50px;">
                        <i class="fa-solid fa-arrow-up-from-bracket fa-xl" style="color: rgb(255, 255, 255); font-weight: 900;"></i>
                        <div style="width: 170px;"> 
                            Upload parish logo and customize theme colors
                        </div>
                    </div>

                    <!-- BTNs Container -->
                     <div class="d-flex flex-column w-100 justify-content-center">
                        <div class="btn custom-btn d-flex justify-content-between align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fa-solid fa-unlock ms-3" style="color: white;"></i>
                            <div class="w-75 text-start">
                                Change Password
                            </div>
                        </div>
                        <div class="btn custom-btn d-flex gap-2 align-items-center justify-content-between" onclick="window.location.href='{{ route('logout') }}'">
                            <i class="fa-solid fa-right-from-bracket ms-3" style="color: white;"></i>
                            <div class="w-75 text-start ps-4">
                                Sign Out
                            </div>
                        </div>
                     </div>
                </div>

                <!-- Notification -->
                <div class="w-100">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div id="changePasswordModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: #f8eaa0;">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="changePasswordForm" action="{{ route('change.password') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required minlength="8">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="new_password_confirmation" class="form-control" required minlength="8">
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Logo Modal -->
        <div id="updateLogoModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: #f8eaa0;">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Logos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateLogoForm" action="{{ route('update.logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="site_logo1" class="form-label">Site Logo 1</label>
                                <input type="file" id="site_logo1" name="site_logo1" class="form-control" accept="image/*">
                            </div>

                            <div class="form-group mb-3">
                                <label for="site_logo2" class="form-label">Site Logo 2</label>
                                <input type="file" id="site_logo2" name="site_logo2" class="form-control" accept="image/*">
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="submit" class="btn btn-primary">Update Logos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection