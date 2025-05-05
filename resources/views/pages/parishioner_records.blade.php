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

        /* Table CSS */
        .table-box {
            max-width: 1080px;
        }

        .table-header {
            border: 2px solid black;
            padding: 2px;
        }
        
    </style>

    @include('layouts.header')

    <!-- Main Content -->
    <main>
        <div class="container-fluid p-0" style="background-color: rgb(255, 255, 255); height: calc(100vh - 50px); width: 100vw;">
            <!-- Floating Header -->
            <div class="container-fluid floating-header d-flex justify-content-end align-items-center">
                <!-- Floating Brand -->
                <div class="d-flex justify-content-between align-items-end gap-2 pb-2 pt-1 d-none" style="width: fit-content;">
                    <i class="fa-solid fa-file-pen fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">Registration</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('registration') }}'"></span>
            </div>

            <!-- Table Box -->
            <div class="table-box container-fluid mt-3">
                <div class="table-header mb-1">
                    <div class="d-flex justify-content-center align-items-center" style="background-color: #efe9e9;">
                        <div class="fs-4 fw-medium text-black">Parishioner Records</div>
                    </div>
                </div>
                <table class="table table-bordered border-black text-center">
                    <thead>
                        <tr class="table-active">
                            <th class="col-1" scope="col">NO.</th>
                            <th class="col-5" scope="col">NAME</th>
                            <th class="col-3" scope="col">DATE</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($parishioners as $index => $parishioner)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $parishioner->first_name }} {{ $parishioner->middle_name }} {{ $parishioner->last_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($parishioner->birthdate)->format('F j, Y') }}</td>
                                <td class="d-flex justify-content-center gap-3">
                                    <!-- Edit button -->
                                    <a href="{{ route('parishioner.edit', $parishioner->id) }}" class="btn btn-sm btn-warning border-black fw-medium">
                                        <i class="fa-solid fa-pen-to-square fa-xs"></i> Edit
                                    </a>
                                    <!-- Delete button -->
                                    <form action="{{ route('parishioner.destroy', $parishioner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger border-black fw-medium">
                                            <i class="fa-solid fa-trash-can fa-xs pe-2"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No data available!</td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>



        </div>
    </main>
@endsection