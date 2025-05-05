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
            flex: 1; /* Allows it to take remaining space */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0; /* Ensures proper shrinking inside flexbox */
        }


        .form-control:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #ced4da !important; /* Optional: Restore default border */
        }

        /* Folder CSS */
        .list-box {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two equal columns */
            gap: 10px; /* Equivalent to Bootstrap gap-2 */
            max-width: 1020px; /* Optional: adjust width */
            width: 100%;
            height: 100vh !important;
            height: max-content !important;
            max-height: 420px;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .user-list {
            background-color: #f8eaa0;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            height: fit-content !important;
        }

        .user-list:hover {
            border: 2px solid #a63522;
        }
        
        .dropdown-menu {
            position: fixed !important;
            z-index: 1050;
        }
        
    </style>

    @include('layouts.header')

    <!-- Main Content -->
    <main>
        <div class="container-fluid p-0" style="background-color: rgb(236, 236, 236); height: calc(100vh - 50px); width: 100vw;">
            <!-- Floating Header -->
            <div class="container-fluid floating-header d-flex justify-content-between align-items-center">
                <!-- Floating Brand -->
                <div class="d-flex justify-content-between align-items-end gap-2 pb-2 pt-1 ps-2 pe-2" style="width: fit-content;">
                    <i class="fa-solid fa-user fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">Profile</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('list') }}'"></span>
            </div>

            <!-- Divider -->
            <div class="d-flex">
                <div class="w-25" style="max-width: 120px;">
                    <a href="{{ route('fg.members', ['folder_id' => $folder->id]) }}" class="text-decoration-none text-dark">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-2">
                            <img src="{{ asset('storage/images/folder.png') }}" alt="Folder" width="100px">
                            <div class="d-flex flex-column text-center">
                                <span class="fs-6 fw-medium">{{ $folder->folder_name }}</span>
                                <span class="fw-medium" style="font-size: small;">No. of members</span>
                                <span class="fw-bold fs-2">{{ $folder->members_count }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="w-100">
                    <!-- Upload Box -->
                    <div class="container-fluid d-flex justify-content-between align-items-center mt-2 ps-5 pe-5">
                        <div class="d-flex justify-content-end align-items-center w-100">
                            <div class="d-flex justify-content-center align-items-center gap-1 p-1 ps-2 pe-2 btn" style="background-color: #f8eaa0;"  data-bs-toggle="modal" data-bs-target="#addProfileModal" style="height: 50px; width: 50px; background-color: orange;">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                <div>Upload</div>
                            </div>
                        </div>
                    </div>

                    @if($members->isEmpty())
                        <div class="alert alert-warning text-center ms-5 me-5 mt-4" role="alert">
                            No members found!
                        </div>
                    @endif

                    <!-- List Box -->
                    <div class="d-flex justify-content-center align-items-center m-3">
                        <div class="list-box d-grid gap-2 column-gap-md-5">
                            <!-- Show Lists -->
                            @foreach ($members as $member)
                                <div class="user-list text-center d-flex align-items-center">
                                    <div class="w-100" onclick="window.location.href='{{ route('fg.members.view_profile', $member->id) }}'">
                                        {{  $member->name }}
                                    </div>
                                    <div class="dropdown">
                                        <i class="fa-solid fa-ellipsis-v p-2 me-2 btn" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <!-- Update Button -->
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editMember({{ $member->id }}, '{{ $member->name }}')">Update</a></li>
                                            
                                            <!-- Delete Button -->
                                            <li>
                                                <form action="{{ route('fg.members.delete', $member->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>                        
                    </div>
                </div>
            </div>


            <!-- Add Profile Modal -->
            <div class="modal modal-sm fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #f8eaa0;">
                        <form id="memberForm" action="{{ route('fg.members.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="member_id" id="member_id">
                            <input type="hidden" name="folder_id" value="{{ $folder->id }}">  <!-- Keep folder_id -->
                            <div class="modal-body">
                                <div>
                                    <input type="text" class="form-control" placeholder="Enter name" name="name" id="member_name" aria-label="Member Name" style="border: 2px solid #a63522 !important; background-color: #f8eaa0;" required>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-1">
                                    <button type="button" class="btn p-0 m-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn p-0 m-0" id="submitButton">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('addProfileModal'));

        // Reset the form when the modal is hidden
        document.getElementById('addProfileModal').addEventListener('hidden.bs.modal', function () {
            // Reset the form
            var form = document.getElementById('memberForm');
            form.reset();
            
            // Reset button text
            document.getElementById('submitButton').textContent = 'Create';

            // Clear the hidden member_id field
            document.getElementById('member_id').value = '';
        });
    });

    function editMember(memberId, memberName) {
        var form = document.getElementById('memberForm');
        
        // Set the form action to the correct update route with the member's ID
        form.action = '{{ route('fg.members.update', '') }}' + '/' + memberId;

        // Set the method to PUT (using a hidden _method field)
        var methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'PUT');
        form.appendChild(methodInput);

        // Set the member_id and name in the input field
        document.getElementById('member_id').value = memberId;
        document.getElementById('member_name').value = memberName;

        // Change the button text to "Update"
        document.getElementById('submitButton').textContent = 'Update';

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('addProfileModal'));
        myModal.show();
    }
    </script>
@endsection