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

        .ellipsis-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        /* Form CSS */
        .sacraments .form-check {
            accent-color: green;
            pointer-events: none;
        }

        label {
            user-select: none;
        }

        .text-outline {
            -webkit-text-stroke: 1px gray;
        }

        .button-box .btn {
            border-radius: 0px !important;
        }

        tbody tr:nth-of-type(even) > td, thead tr > th {
            background-color: rgb(189, 189, 189) !important;
        }

        thead tr > th {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        tbody tr td {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
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
        <div class="container-fluid d-flex p-0" style="background-color: rgb(236, 236, 236); height: calc(100vh - 50px); width: 100vw;">
            <!-- Profile Layout -->
            <div class="d-flex flex-column" style="width: 210px; border-right: 1px solid brown;">
                <div class="user-profile overflow-hidden d-flex justify-content-center align-items-center">
                    <div class="border" style="height: 210px !important;">
                        <img src="{{ asset('storage/' . $member->profile) }}" alt="" style="width: 210px; height: fit-content;">
                    </div>
                </div>

                <!-- Active Status -->
                <div class="text-center p-1 fw-bold" style="border: 1px solid black; background-color: {{ $member->activity == 'Active' ? '#81bf2d' : '#ff0000' }}; color: white;">
                    {{ $member->activity == 'Active' ? 'ACTIVE' : 'INACTIVE' }}
                </div>

                <!-- Received Sacraments -->
                <div class="sacraments d-flex flex-column p-2 fw-bold" style="background-color: #a63522; color: white; font-size: 8pt;">
                    <div class="text-center">
                        RECEIVED SACRAMENTS:
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex gap-1 align-items-center">
                            <input class="form-check"  {{ $member->baptism ? 'checked' : '' }} type="checkbox" name="baptism" id="baptism">
                            <span>BAPTISM</span>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            <input class="form-check"  {{ $member->communion ? 'checked' : '' }} type="checkbox" name="baptism" id="baptism">
                            <span>COMMUNION</span>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            <input class="form-check"  {{ $member->confirmation ? 'checked' : '' }} type="checkbox" name="baptism" id="baptism">
                            <span>CONFIRMATION</span>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            <input class="form-check"  {{ $member->marriage ? 'checked' : '' }} type="checkbox" name="baptism" id="baptism">
                            <span>MARRIAGE</span>
                        </div>
                    </div>
                </div>

                <!-- Family Group -->
                 <div class="d-flex flex-column p-2 h-50 text-outline" style="background-color: #81bf2d; color: white;">
                    <div class="text-start fw-bolder fs-5">
                        {{ $member->folder->folder_name }}
                    </div>
                    <div class="d-flex flex-column align-items-center mt-1 gap-0">
                        <span class="fw-bold fs-6 p-0 m-0 lh-1">FAMILY CODE NO.</span>
                        <span class="fw-bold lh-1" style="font-size: 28pt;">{{ $member->family_code }}</span>
                    </div>
                 </div>
            </div>

            <!-- Profile Data -->
            <div class="d-flex flex-column w-100">
                <!-- Button Divider -->
                <div class="button-box d-flex" style="height: 68px !important; border-bottom: 1px solid brown;">
                    <div class="w-100 d-flex justify-content-evenly align-items-center">
                        <!-- Edit BTN -->
                        <div style="width: fit-content; border: 1px solid black;">
                            <div class="btn btn-sm btn-warning fw-medium d-flex justify-content-center align-items-center gap-1 ps-2 pe-2" data-bs-toggle="modal" data-bs-target="#updateMemberModal">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit Profile</span>
                            </div>
                        </div>

                        <!-- Delete BTN -->
                        <div style="width: fit-content; border: 1px solid black;">
                            <form action="{{ route('fg.members_onview.delete', ['member' => $member->id, 'folder_id' => $member->folder_id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger fw-medium d-flex justify-content-center align-items-center gap-1 ps-2 pe-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Delete Profile</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-1 ps-3 pe-3" onclick="window.location.href='{{ route('fg.members', $member->folder_id) }}'" style="background-color: #156c1b; color: white; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                        <div class="text-nowrap fw-medium">
                            GO BACK
                        </div>
                    </div>
                </div>

                <!-- Table Data Layout -->
                 <div class="overflow-y-auto fw-medium">
                    <table class="table border-black">
                        <thead style="border-top: 3px solid brown; border-bottom: 3px solid brown;">
                            <tr>
                                <th class="fw-medium">Member Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>FULLNAME:</td>
                            </tr>
                            <tr>
                                <td>{{ $member->name }}</td>
                            </tr>
                            <tr>
                                <td>DATE OF BIRTH:</td>
                            </tr>
                            <tr>
                                <td>{!! $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('F j, Y') : '<span>N/A</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>AGE:</td>
                            </tr>
                            <tr>
                                <td>{!! $member->age ?: '<span>N/A</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>GENDER:</td>
                            </tr>
                            <tr>
                                <td>{!! $member->gender ?: '<span>N/A</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>STATUS:</td>
                            </tr>
                            <tr>
                                <td>{!! $member->status ?: '<span>N/A</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>PARENTS:</td>
                            </tr>
                            <tr>
                                <td>
                                @if ($member->fathers_name || $member->mothers_name)
                                    @if ($member->fathers_name)
                                        {{ $member->fathers_name }} (FATHER){{ $member->mothers_name ? ', ' : '' }}
                                    @endif
                                    @if ($member->mothers_name)
                                        {{ $member->mothers_name }} (MOTHER)
                                    @endif
                                @else
                                    <span>N/A</span>
                                @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>

        <!-- FG Member Update Modal -->
        <div class="modal fade" id="updateMemberModal" tabindex="-1" aria-labelledby="updateMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: #f8eaa0;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateMemberModalLabel">Update Member Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('fg.members.complete_update', $member->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="profile" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile" name="profile" accept=".jpeg,.png,.jpg,.gif,.svg">
                                    </div>
                                        <div class="mb-3">
                                            <label for="family_code" class="form-label">Family Code</label>
                                            <input type="number" class="form-control" id="family_code" name="family_code" placeholder="Enter Family Code" value="{{ $member->family_code }}">
                                        </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="full_name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="full_name" name="name" value="{{ $member->name }}" style="pointer-events: none;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="birthday" class="form-label">Birthday</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $member->birthday }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" name="age" value="{{ $member->age }}" placeholder="Ex. 18" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                                <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Single" {{ $member->status == 'Single' ? 'selected' : '' }}>Single</option>
                                                <option value="Married" {{ $member->status == 'Married' ? 'selected' : '' }}>Married</option>
                                                <option value="Widowed" {{ $member->status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                <option value="Separated" {{ $member->status == 'Separated' ? 'selected' : '' }}>Separated</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fathers_name" class="form-label">Father's Name</label>
                                            <input type="text" class="form-control" id="fathers_name" name="fathers_name" placeholder="Enter Father's Name" value="{{ $member->fathers_name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mothers_name" class="form-label">Mother's Name</label>
                                            <input type="text" class="form-control" id="mothers_name" name="mothers_name" placeholder="Enter Mother's Name" value="{{ $member->mothers_name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="activity" class="form-label">Activity</label>
                                            <select class="form-control" id="activity" name="activity">
                                                <option value="Active" {{ $member->activity == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ $member->activity == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Insert the Sacraments checkboxes here -->
                                    <label class="form-label">Sacraments</label>
                                    <div class="d-flex flex-row gap-2 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="baptism_{{ $member->id }}" name="baptism" value="1" {{ $member->baptism ? 'checked' : '' }}>
                                            <label class="form-check-label" for="baptism_{{ $member->id }}">Baptism</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="communion_{{ $member->id }}" name="communion" value="1" {{ $member->communion ? 'checked' : '' }}>
                                            <label class="form-check-label" for="communion_{{ $member->id }}">Communion</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmation_{{ $member->id }}" name="confirmation" value="1" {{ $member->confirmation ? 'checked' : '' }}>
                                            <label class="form-check-label" for="confirmation_{{ $member->id }}">Confirmation</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="marriage_{{ $member->id }}" name="marriage" value="1" {{ $member->marriage ? 'checked' : '' }}>
                                            <label class="form-check-label" for="marriage_{{ $member->id }}">Marriage</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Success/Error Popup Modal -->
        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p id="modalMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let message = "{{ implode('\n', $errors->all()) }}";
                document.getElementById("modalMessage").textContent = message;
                new bootstrap.Modal(document.getElementById("messageModal")).show();
            });
        </script>
    @endif
@endsection