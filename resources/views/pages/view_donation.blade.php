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
        thead tr th {
            background-color: #191919 !important;
            text-wrap: nowrap;
            font-size: small;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            font-weight: 500;
        }

        th:first-child, th:nth-child(even) {
            color: white !important;
        }

        th:nth-child(odd):not(:first-child) {
            color: yellow;
        }

        td {
            text-wrap: nowrap;
            font-size: small;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        td:not(:first-child) {
            text-align: center;
        }

        .empty td {
            padding: 0px !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .typing td {
            padding: 0px !important;
            width: auto !important;
        }

        .typing td input {
            width: auto !important;
            min-width: 50px !important;
            max-width: max-content !important;
            text-align: center;
            font-size: small !important;
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
                <div class="d-flex justify-content-between align-items-end gap-2 pb-2 pt-1 ps-2 pe-2" style="width: fit-content;">
                    <i class="fa-solid fa-peso-sign fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">Donation</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('donation') }}'"></span>
            </div>

            <!-- Report Box -->
            <div class="report-box">
                <div class="report-header p-1 d-flex justify-content-between">
                    <div>
                        <span class="fs-5 fw-bold text-decoration-underline">FAMILY GROUPINGS / HUGPONG BANAY LEVEL</span>
                        <div class="d-flex flex-column ms-2 mt-2 fw-medium">
                            <div class="d-flex align-items-center gap-2">
                                <div>Name of Hugpong Banay:</div>
                                <div>{{ $folders['folderName'] }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div>GKK / Chapel:</div>
                                <div>SAINTS PETER AND PAUL MISSION STATION</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div>Address:</div>
                                <div>Kinabjangan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Year Dropdown -->
                    <div class="d-flex flex-column me-5">
                        <label class="form-label p-0 m-0 fw-medium" for="year" style="font-size: 9pt;">YEAR</label>
                        <select class="form-select fw-medium" name="year" id="year" style="border: 2px solid black;">
                            <option value="">2024</option>
                            <option value="">2023</option>
                        </select>
                    </div>
                </div>

                <!-- Report Title -->
                <div class="report-title text-center">
                    <div class="fw-medium">JANUARY TO DECEMBER 2024</div>
                </div>

                <!-- Report Table -->
                <div class="overflow-x-auto overflow-y-auto p-1 pt-0 pb-0" style="height: 100% !important; max-height: 250px;">
                    <table class="table table-bordered border-black">
                        <thead class="text-center position-sticky top-0">
                            <tr>
                                <th>LIST OF MEMBER</th>
                                <th>JAN</th>
                                <th>DATE</th>
                                <th>FEB</th>
                                <th>DATE</th>
                                <th>MAR</th>
                                <th>DATE</th>
                                <th>APR</th>
                                <th>DATE</th>
                                <th>MAY</th>
                                <th>DATE</th>
                                <th>JUNE</th>
                                <th>DATE</th>
                                <th>JULY</th>
                                <th>DATE</th>
                                <th>AUG</th>
                                <th>DATE</th>
                                <th>SEP</th>
                                <th>DATE</th>
                                <th>OCT</th>
                                <th>DATE</th>
                                <th>NOV</th>
                                <th>DATE</th>
                                <th>DEC</th>
                                <th>DATE</th>
                            </tr>
                        </thead>
                        <tbody id="memberTableBody">
                            <!-- Rows will be dynamically inserted here -->
                        </tbody>
                    </table>
                    </div>

                <div class="d-flex justify-content-end mt-3 me-4 gap-2">
                    <div>
                        <div class="btn btn-outline-secondary fw-medium" data-bs-toggle="modal" data-bs-target="#donationModal" style="border: 2px solid #191919; border-radius: 20px; width: 100px;">EDIT</div>
                    </div>
                </div>
            </div>
        </div>  

        <!-- Donation Modal -->
        <div id="donationModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: #f8eaa0;">
                    <div class="modal-header">
                        <h5 class="modal-title">Add / Update Donation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="donationForm">
                            <div class="form-group">
                                <label for="fg_member_id">Member Name</label>
                                <select id="fg_member_id" name="fg_member_id" class="d-input form-control" required>
                                    <option value="">Select Member</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="month">Month</label>
                                <select id="month" name="month" class="d-input form-control" required>
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" id="amount" name="amount" class="d-input form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" class="d-input form-control">
                            </div>

                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" id="form-year" name="year" class="form-control" readonly style="pointer-events: none;">
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="submit" class="d-input btn btn-primary">Save Donation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            getYears().then(() => {
                getMembers();

                let initialYear = $('#year').val();
                $('#form-year').val(initialYear);
            });

            $('#fg_member_id, #month').change(function() {
                updateDonationFields();
            });

            $('#year').change(function() {
                let selectedYear = $(this).val();
                $('#form-year').val(selectedYear);
                getMembers();
            });
        });

        $('#donationModal').on('hidden.bs.modal', function () {
            const modal_input = document.getElementsByClassName('d-input');
            Array.from(modal_input).forEach(input => {
                input.value = '';
            });
        });

        function updateDonationFields() {
            let memberId = $('#fg_member_id').val();
            let month = $('#month').val();

            if (memberId && month) {
                let selectedOption = $('#fg_member_id option:selected');
                let memberData = selectedOption.data('member');

                if (memberData) {
                    let monthKey = month.toLowerCase();

                    let donationData = typeof memberData === 'string' ? JSON.parse(memberData) : memberData;

                    let amount = donationData[monthKey]?.amount || '';
                    let date = donationData[monthKey]?.date || '';

                    $('#amount').val(amount);
                    $('#date').val(date);
                }
            }
        }

        function getYears() {
            return new Promise((resolve, reject) => {
                $.get('/get-years', function(response) {
                    let options = '';

                    if (response.success && response.years.length > 0) {
                        let uniqueYears = [...new Set(response.years)];
    
                        // Sort the years to ensure the last year is the most recent one
                        uniqueYears.sort((a, b) => a - b);
                        
                        // Add the extra year (last year + 1)
                        let lastYear = uniqueYears[uniqueYears.length - 1];
                        let nextYear = parseInt(lastYear) + 1;

                        // Add years to options
                        uniqueYears.forEach(year => {
                            options += `<option value="${year}">${year}</option>`;
                        });

                        // Add the next year to the options
                        options += `<option value="${nextYear}">${nextYear}</option>`;
                    } else {
                        let currentYear = new Date().getFullYear();
                        options = `<option value="${currentYear}" selected>${currentYear}</option>`;
                    }

                    $('#year').html(options);
                    resolve();
                }).fail((xhr, status, error) => {
                    console.error("Error fetching years:", error, xhr.responseText);
                    reject(error);
                });
            });
        }

        function fetchMembers(folderId, year) {
            $.get(`/get-members/${folderId}/${year}`, function(response) {
                if (response.success) {
                    let options = ['<option value="">Select Member</option>'];
                    let tableRows = [];

                    response.members.forEach(member => {
                        let donationData = {};
                        if (member.donations) {
                            member.donations.forEach(donation => {
                                donationData[donation.month.toLowerCase()] = {
                                    amount: donation.amount || '',
                                    date: donation.date ? formatDate2(donation.date) : ''
                                };
                            });
                        }

                        let donationJson = JSON.stringify(donationData);

                        options.push(`
                            <option value="${member.id}" data-member='${donationJson}'>
                                ${member.name}
                            </option>
                        `);

                        let monthCells = '';
                        const months = [
                            'January', 'February', 'March', 'April', 'May', 'June', 
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];

                        months.forEach(month => {
                            let lowerMonth = month.toLowerCase();
                            let amount = donationData[lowerMonth]?.amount || '';
                            let date = donationData[lowerMonth]?.date || '';

                            let formattedDate = date ? formatDate(date) : '';

                            monthCells += `<td>${amount}</td><td>${formattedDate}</td>`;
                        });

                        tableRows.push(`
                            <tr>
                                <td>${member.name}</td>
                                ${monthCells}
                            </tr>
                        `);
                    });

                    $('#fg_member_id').html(options.join(''));
                    $('#memberTableBody').html(tableRows.join(''));
                } else {
                    $('#fg_member_id').html('<option value="">No Members Found</option>');
                    $('#memberTableBody').html('<tr><td colspan="25" class="text-center">No data available</td></tr>');
                }
            });
        }

        // Function to format date as MM-DD-YYYY
        function formatDate(dateString) {
            let date = new Date(dateString);
            let month = (date.getMonth() + 1).toString().padStart(2, '0');
            let day = date.getDate().toString().padStart(2, '0');
            let year = date.getFullYear();
            return `${month}-${day}-${year}`;
        }

        // Function to format date as YYYY-MM-DD
        function formatDate2(dateString) {
            let date = new Date(dateString);
            let year = date.getFullYear();
            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Get month in two-digit format
            let day = date.getDate().toString().padStart(2, '0'); // Get day in two-digit format
            return `${year}-${month}-${day}`; // Return in the correct YYYY-MM-DD format
        }

        function getMembers() {
            let urlSegments = window.location.pathname.split('/');
            let folderId = urlSegments[urlSegments.length - 1];
            let year = $("#year").val();

            fetchMembers(folderId, year);
        }

        $("#year").change(function() {
            let urlSegments = window.location.pathname.split('/');
            let folderId = urlSegments[urlSegments.length - 1];
            let year = $(this).val();
            fetchMembers(folderId, year);
        });

        $('#donationForm').submit(function(event) {
            event.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/donations/save',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message);
                    $('#donationModal').modal('hide');
                    
                    let urlSegments = window.location.pathname.split('/');
                    let folderId = urlSegments[urlSegments.length - 1];
                    let year = $("#year").val();

                    fetchMembers(folderId, year);

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    </script>
@endsection