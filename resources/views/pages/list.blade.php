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


        .form-control:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #ced4da !important;
        }

        /* Search CSS */

        /* Folder CSS */
        .folder-box {
            width: 100%;
            max-width: 1040px;
            max-height: calc(100vh - 190px);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: start;
            justify-content: start; 
            overflow-y: auto;
            overflow-x: hidden;
        }

        .folder-box > a {
            text-decoration: none !important;
            color: black;
        }

        .folder {
            width: fit-content;
            height: fit-content;
        }

        #searchResults {
            width: 100% !important; 
            max-width: 250px;
        }
        
    </style>

    <!-- Header -->
    @include('layouts.header')

    <!-- Main Content -->
    <main>
        <div class="container-fluid p-0" style="background-color: rgb(236, 236, 236); height: calc(100vh - 50px); width: 100vw;">
            <!-- Floating Header -->
            <div class="container-fluid floating-header d-flex justify-content-between align-items-center">
                <!-- Floating Brand -->
                <div class="d-flex justify-content-between align-items-end gap-2 pb-2 pt-1" style="width: fit-content;">
                    <i class="fa-solid fa-table-list fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">List</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('home') }}'"></span>
            </div>

            <!-- Search Box -->
            <div class="container-fluid d-flex position-relative justify-content-between align-items-center mt-2 ps-5 pe-5">
                <div class="d-flex justify-content-start align-items-center">
                    <!-- Search input group -->
                    <div class="input-group" style="border-radius: 30px !important; overflow: hidden !important; border: 1px solid black; position: relative;">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search here..." aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn" type="button" id="button-addon2" style="border: none !important; background-color: white; color: black;">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>

                    <!-- Search results container -->
                    <div id="searchResults" class="search-results" style="position: absolute; top: 100%; left: 100; width: 100%; background: white; border: 1px solid #ccc; max-height: 200px; overflow-y: auto; display: none; z-index: 1000;"></div>
                </div>

                <!-- Add Button -->
                 <div class="btn rounded-circle d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#addFolderModal" style="height: 50px; width: 50px; background-color: orange;">
                    <i class="fa-solid fa-folder-plus fa-xl" style="color: white;"></i>
                 </div>
            </div>

            <!-- Alert Box -->
            @if($errors->any())
                <div class="alert alert-danger ms-5 me-5 mt-2 alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success ms-5 me-5 mt-2 alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger ms-5 me-5 mt-2 alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($folders->isEmpty())
                <div class="alert alert-warning text-center ms-5 me-5 mt-4" role="alert">
                    No folders found!
                </div>
            @endif

            <!-- List Box -->
            <div class="container-fluid d-flex justify-content-center align-items-start overflow-hidden h-100">
                <!-- Folder Box -->
                <div class="folder-box h-100 overflow-y-auto overflow-x-hidden">
                    <!-- Folders -->
                    @foreach ($folders as $folder)
                        <a href="{{ route('fg.members', $folder->id) }}" class="folder text-center" data-folder-id="{{ $folder->id }}">
                            <div class="folder-icon">
                                <img src="{{ asset('storage/images/folder.png') }}" alt="" width="120px">
                            </div>
                            <div class="folder-name fw-bold">{{ $folder->folder_name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>



        <!-- Add Folder Modal -->
        <div class="modal modal-sm fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: #f8eaa0;">
                    <div class="modal-body">
                        <form action="{{ route('folder.create') }}" method="POST">
                            @csrf
                            <div>
                                <label class="form-label" for="folderName">New Folder</label>
                                <input type="text" class="form-control" name="folder_name" placeholder="Folder Name" aria-label="Folder Name" style="border: 2px solid #a63522 !important; background-color: #f8eaa0;">
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-1">
                                <div type="button" class="btn p-0 m-0" data-bs-dismiss="modal" aria-label="Close">Cancel</div>
                                <button type="submit" class="btn p-0 m-0">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Rename & Delete Modal -->
        <div class="modal modal-sm fade" id="renameFolderModal" tabindex="-1" aria-labelledby="renameFolderModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: #f8eaa0;">
                    <div class="modal-body">
                        <form action="{{ route('folder.update', ':folderId') }}" method="POST" id="renameFolderForm">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="folder_id" id="folder_id">
                            <div>
                                <label class="form-label" for="folderName">Folder Name</label>
                                <input type="text" class="form-control" name="folder_name" id="folder_name" placeholder="Folder Name" aria-label="Folder Name" style="border: 2px solid #a63522 !important; background-color: #f8eaa0;">
                            </div>

                            <div class="d-flex justify-content-between gap-2 mt-2">
                                <div type="button" class="btn p-0 m-0" data-bs-dismiss="modal" aria-label="Close">Cancel</div>
                                <button type="submit" class="btn p-0 m-0">Rename</button>
                            </div>
                        </form>

                        <form action="{{ route('folder.delete', ':folderId') }}" method="POST" id="deleteFolderForm" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="folder_id" id="delete_folder_id">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn p-1 m-0">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const resultsContainer = document.getElementById("searchResults");

            searchInput.addEventListener("input", function () {
                let query = searchInput.value.trim();

                if (query.length === 0) {
                    resultsContainer.style.display = "none";
                    return;
                }

                fetch(`/list/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            resultsContainer.innerHTML = '<div style="padding: 10px;">No results found</div>';
                            resultsContainer.style.display = "block";
                            return;
                        }

                        let resultHtml = data.map(folder => 
                            `<div style="padding: 10px; cursor: pointer;" onclick="selectItem('${folder}')">${folder}</div>`
                        ).join('');
                        
                        resultsContainer.innerHTML = resultHtml;
                        resultsContainer.style.display = "block";
                    })
                    .catch(error => console.error("Error fetching data:", error));
            });

            document.addEventListener("click", function (event) {
                if (!event.target.closest(".d-flex")) {
                    resultsContainer.style.display = "none";
                }
            });

            showModalUpdate();
        });

        function selectItem(value) {
            // Search input value
            document.getElementById("searchInput").value = value;
            document.getElementById("searchResults").style.display = "none";

            // Get all folder elements
            let folders = document.querySelectorAll(".folder");

            // Display only the selected folder
            folders.forEach(folder => {
                let folderName = folder.querySelector(".folder-name").textContent.trim();

                if (folderName === value) {
                    folder.style.display = "block";
                } else {
                    folder.style.display = "none";
                }
            });
        }

        function showModalUpdate() {
            const folders = document.querySelectorAll('.folder');

            // Add right-click event listener on each folder
            folders.forEach(folder => {
                folder.addEventListener('contextmenu', function (e) {
                    e.preventDefault(); // disable the default right click of the web app

                    const folderId = folder.getAttribute('data-folder-id');
                    const folderName = folder.querySelector('.folder-name').textContent.trim();

                    // Set the folder name and ID in the modal
                    document.getElementById('folder_id').value = folderId;
                    document.getElementById('folder_name').value = folderName;
                    document.getElementById('delete_folder_id').value = folderId; 

                    // Update the form action dynamically for rename
                    const formAction = '/list/update/' + folderId;
                    document.getElementById('renameFolderForm').action = formAction;

                    // Update the form action dynamically for delete
                    const deleteFormAction = '/list/delete/' + folderId;
                    document.getElementById('deleteFolderForm').action = deleteFormAction;

                    // Show the modal
                    const renameModal = new bootstrap.Modal(document.getElementById('renameFolderModal'));
                    renameModal.show();
                });
            });
        }
    </script>
@endsection