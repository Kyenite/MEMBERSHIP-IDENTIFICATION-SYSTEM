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

        /* Folder CSS */
        .list-box {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-width: 1020px;
            width: 100%;
            height: 100vh;
            max-height: calc(100vh - 220px);
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .donation-list {
            background-color: white;
            border: 2px solid black;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            height: fit-content !important;
        }
        
        .dropdown-menu {
            position: fixed !important;
            z-index: 1050;
        }

        #searchResults {
            width: 100% !important; 
            max-width: 250px;
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
                    <i class="fa-solid fa-peso-sign fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">Donation</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('home') }}'"></span>
            </div>

            <!-- Divider -->
            
            <div class="w-100">
                <!-- Upload Box -->
                <div class="container-fluid position-relative d-flex justify-content-start align-items-center mt-2 ps-5 pe-5">
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
                     <!-- <div class="btn d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#addFolderModal" style="height: 35px; width: 60px; background-color: #ced4da; border: 2px solid black; border-radius: 20px;">
                        <i class="fa-solid fa-plus fa-xl" style="color: black;"></i>
                     </div> -->
                </div>

                @if ($folders->isEmpty())
                    <div class="alert alert-warning text-center ms-5 me-5 mt-4" role="alert">
                        No folders found!
                    </div>
                @endif

                <!-- List Box -->
                <div class="d-flex justify-content-center align-items-center m-3">
                    <div class="list-box d-grid gap-2 column-gap-md-5">
                        <!-- Show Lists -->
                        @foreach ($folders as $folder)
                            <div class="donation-list text-center d-flex align-items-center">
                                <div class="donation-name w-100 fs-5 p-2" onclick="window.location.href='{{ url('donation/view', ['folderId' => $folder->id]) }}'">
                                    {{ $folder->folder_name }}
                                </div>
                                <div class="dropdown">
                                    <i class="fa-solid fa-ellipsis-v fa-xl p-3 me-2 btn" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item fw-medium" href="#">Rename</a></li>
                                        <li><a class="dropdown-item text-danger fw-medium" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>                        
                </div>
            </div>


            <!-- Add Profile Modal -->
            <div class="modal modal-sm fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #f8eaa0;">
                        <div class="modal-body">
                            <div>
                                <label class="form-label" for="folderName">Enter name</label>
                                <input type="text" class="form-control" placeholder="" aria-label="Folder Name" style="border: 2px solid #a63522 !important; background-color: #f8eaa0;">
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-1">
                                <!-- <div class="btn p-0 m-0" data-bs-dismiss="modal" aria-label="Close">Cancel</div> -->
                                <div class="btn p-0 m-0">Okay</div>
                            </div>
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

            resultsContainer.innerHTML = '<div style="padding: 10px;">Searching...</div>';
            resultsContainer.style.display = "block";

            fetch(`/donation/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Data received:", data);
                    
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
                .catch(error => {
                    console.error("Error fetching data:", error);
                    resultsContainer.innerHTML = '<div style="padding: 10px;">An error occurred</div>';
                    resultsContainer.style.display = "block";
                });
        });

        document.addEventListener("click", function (event) {
            if (!event.target.closest(".d-flex")) {
                resultsContainer.style.display = "none";
            }
        });
    });

    function selectItem(value) {
        
        document.getElementById("searchInput").value = value;
        document.getElementById("searchResults").style.display = "none";

        let donations = document.querySelectorAll(".donation-list");

        donations.forEach(donation => {
            donation.style.display = "block";
        });

        donations.forEach(donation => {
            let folderName = donation.querySelector(".donation-name").textContent.trim();

            if (folderName !== value) {
                donation.style.setProperty('display', 'none', 'important');
            }
        });
    }
    </script>
@endsection