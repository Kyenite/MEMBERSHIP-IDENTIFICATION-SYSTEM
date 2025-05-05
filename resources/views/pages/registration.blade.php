@extends('layouts.app')

@section('content')

    @php
        // Ensure $parishioner->birthdate exists before splitting
        $birthday = isset($parishioner->birthdate) ? explode('-', $parishioner->birthdate) : [null, null, null];
        $selectedYear = $birthday[0] ?? '';
        $selectedMonth = $birthday[1] ?? '';
        $selectedDay = $birthday[2] ?? '';

        // Check if it's an edit mode (disable inputs if data exists)
        $isEdit = !empty($selectedYear) && !empty($selectedMonth) && !empty($selectedDay);
    @endphp

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

        /* Form CSS */
        .form-box {
            width: 100%;
            max-width:1120px;
            height: max-content;
            border: 2px solid black;
        }

        .form-header {
            text-align: center;
            border: 2px solid black;
            background-color: #efe9e9;
        }

        .text-capitalize {
            text-transform: uppercase !important;
        }

        .input-group-text {
            min-width: 78px !important;
            background-color: #efe9e9;
            border-right: 2px solid black !important;
        }

        .box1 > .row input, .box2 > .row:not(:last-of-type) input, .box2 > .row:last-of-type .input-group  {
            border: 1px solid black !important;
            border-radius: 0;
        }

        .col > label {
            font-weight: 500 !important;
        }

        .row {
            margin-bottom: 10px;
        }

        .Disabled_Edit > #month, .Disabled_Edit > #day, .Disabled_Edit > #year {
            pointer-events: none !important;
        }
        
    </style>

    @include('layouts.header')

    <!-- Main Content -->
    <main>
        <div class="container-fluid p-0 overflow-y-auto" style="background-color: rgb(236, 236, 236); height: calc(100vh - 50px); width: 100vw;">
            <!-- Floating Header -->
            <div class="container-fluid floating-header d-flex justify-content-between align-items-center">
                <!-- Floating Brand -->
                <div class="d-flex justify-content-between align-items-end gap-2 pb-2 pt-1" style="width: fit-content;">
                    <i class="fa-solid fa-file-pen fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">Registration</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('home') }}'"></span>
            </div>

            <!-- Flash message alert section outside the form -->
            @if (session('status') == 'success')
                <div class="alert alert-success text-center">
                    {{ session('message') }}
                </div>
            @elseif (session('status') == 'error')
                <div class="alert alert-danger text-center">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Form Box -->
            <div class="container-fluid d-flex justify-content-center message-container p-2 pt-3 ps-4 pe-4" style="background-color: rgb(255, 255, 255); height: calc(100% - 85px); overflow: hidden; overflow-y: auto !important;">
                <div class="form-box pb-2">
                    <div class="form-header mt-1 mb-4">
                        <span class="text-capitalize fs-5 fw-medium">New Parishioners Registration Form</span>
                    </div>
                    <form class="container-fluid" action="{{ request()->routeIs('parishioner.edit') ? route('parishioner.update', $parishioner->id) : route('parishioner.register') }}" method="POST">
                        
                        @if(request()->routeIs('parishioner.edit'))
                            @method('PUT')
                        @endif

                        @csrf

                        <div class="d-flex gap-3 ps-3 pe-3">
                            <div class="box1 w-50">
                                <div class="row">
                                    <div class="col">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="fname" name="first_name" placeholder="Enter First Name" 
                                            value="{{ old('first_name', $parishioner->first_name ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="mname" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="mname" name="middle_name" placeholder="Enter Middle Name" 
                                            value="{{ old('middle_name', $parishioner->middle_name ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="last_name" placeholder="Enter Last Name" 
                                            value="{{ old('last_name', $parishioner->last_name ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="age">Age</label>
                                        <input type="number" class="form-control" id="age" name="age" required style="max-width: 85px;" 
                                            placeholder="Ex. 18" value="{{ old('age', $parishioner->age ?? '') }}">
                                    </div>
                                </div>

                                <!-- Birthday Dropdown -->
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="month">Birthday</label>
                                        <div class="d-flex {{ $isEdit ? 'Disabled_Edit' : '' }}">
                                            <!-- Month Dropdown -->
                                            <select class="form-control me-2 border-black" id="month" name="month" required {{ $isEdit ? 'enabled' : '' }}>
                                                <option value="">Month</option>
                                                @foreach (range(1, 12) as $m)
                                                    <option value="{{ $m }}" {{ (int)$selectedMonth === $m ? 'selected' : '' }}>
                                                        {{ date("F", mktime(0, 0, 0, $m, 1)) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!-- Day Dropdown -->
                                            <select class="form-control me-2 border-black" id="day" name="day" required {{ $isEdit ? 'enabled' : '' }}>
                                                <option value="">Day</option>
                                                @for ($d = 1; $d <= 31; $d++)
                                                    <option value="{{ $d }}" 
                                                        {{ (int)$selectedDay === $d ? 'selected' : '' }}>
                                                        {{ $d }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <!-- Year Dropdown -->
                                            <select class="form-control border-black" id="year" name="year" required {{ $isEdit ? 'enabled' : '' }}>
                                                <option value="">Year</option>
                                                @for ($y = date('Y'); $y >= 1900; $y--)
                                                    <option value="{{ $y }}" {{ (int)$selectedYear === $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box2 w-50">
                                <div class="row">
                                    <div class="col col-10">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Barangay, Municipality, Province" 
                                            value="{{ old('address', $parishioner->address ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-6">
                                        <label class="form-label" for="contact">Contact Number</label>
                                        <input type="number" class="form-control" id="contact" name="contact_number" placeholder="Ex. 09123456789" 
                                            value="{{ old('contact_number', $parishioner->contact_number ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-10">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Example@gmail.com" 
                                            value="{{ old('email', $parishioner->email ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="input-group">Parents:</label>
                                        <div class="input-group mb-2" id="input-group">
                                            <label class="input-group-text" for="mother">Mother</label>
                                            <input type="text" class="form-control" name="mother_name" id="mother" placeholder="Enter Mother's Name" 
                                                value="{{ old('mother_name', $parishioner->mother_name ?? '') }}">
                                        </div>
                                        <div class="input-group">
                                            <label class="input-group-text" for="father">Father</label>
                                            <input type="text" class="form-control" name="father_name" id="father" placeholder="Enter Father's Name" 
                                                value="{{ old('father_name', $parishioner->father_name ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex flex-column justify-content-center mt-3 gap-2">
                                    <button type="submit" class="btn btn-primary" style="background-color: #3cc221; border: 1px solid black;">
                                        {{ request()->routeIs('parishioner.edit') ? 'Update' : 'Register' }}
                                    </button>
                                    <button type="button" class="btn btn-primary" style="background-color: #3cc221; border: 1px solid black;" 
                                            onclick="window.location.href='{{ route('parishioner.records') }}'">Records</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Generate day dropdown
        function populateDays() {
        const daySelect = document.getElementById("day");
        const month = document.getElementById("month").value;
        
        // Empty the day list
        daySelect.innerHTML = '<option value="">Day</option>';

        if (month === "") return;

        let days = 31;
        if (month == 2) {
            days = 28; // Default for February
            const year = document.getElementById("year").value;
            if (year && ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0)) {
                days = 29; // Leap year
            }
        } else if ([4, 6, 9, 11].includes(parseInt(month))) {
            days = 30;
        }

        for (let i = 1; i <= days; i++) {
            daySelect.innerHTML += `<option value="${i}">${i}</option>`;
        }
    }
    
        // Generate year dropdown
        function populateYears() {
            const yearSelect = document.getElementById("year");
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i >= 1900; i--) {
                yearSelect.innerHTML += `<option value="${i}">${i}</option>`;
            }
        }
    
        document.getElementById("month").addEventListener("change", populateDays);
        document.getElementById("year").addEventListener("change", populateDays);
    
        // Initialize OnLoad
        document.addEventListener("DOMContentLoaded", () => {
            populateYears();
        });
        
    </script>
@endsection