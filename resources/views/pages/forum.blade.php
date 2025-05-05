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
        .message-card {
            background-color: #f8eaa0;
            border: 1px solid black;
            width: 380px;
            border-radius: 12px;
        }

        .someone-message {
            display: flex;
            justify-content: flex-start;
            margin-top: 10px;
        }

        .my-message {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
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
                    <i class="fa-solid fa-comments fa-2x" style="color: white;"></i>
                    <div class="fs-4 fw-medium text-white">Forum</div>
                </div>

                <!-- Return Button -->
                 <span class="fa-solid fa-close fa-3x btn" style="color: white;" onclick="window.location.href='{{ url('home') }}'"></span>
            </div>

            <!-- Message Box -->
            <div class="container-fluid d-flex justify-content-center message-container p-2" style="background-color: rgb(255, 255, 255); height: calc(100% - 140px);">
                <div class="main-container w-100" id="message-box">
                    @foreach ($forums->reverse() as $forum)
                        @if ($forum->user_id === auth()->id()) 
                            <!-- My Message -->
                            <div class="my-message w-100">
                                <div class="message-card p-1" data-id="{{ $forum->id }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="message-profile d-flex align-items-center justify-content-center rounded-circle border overflow-hidden" style="height: 50px; width: 50px; background-color: rgb(206, 206, 206);">
                                            <img src="{{ asset('storage/' . auth()->user()->profile) }}" alt="Me" style="height: 50px; width: fit-content;">
                                        </div>
                                        <span class="fw-medium">Me</span>
                                    </div>
                                    <div class="message text-center mt-1 p-2 pt-0 pb-0">
                                        <p class="mb-1">{{ $forum->content }}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-medium" style="color: #0f01b4;">{{ $forum->created_at->format('F j, Y h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Someone's Message -->
                            <div class="someone-message w-100">
                                <div class="message-card p-1" data-id="{{ $forum->id }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="message-profile d-flex align-items-center justify-content-center rounded-circle border overflow-hidden" style="height: 50px; width: 50px; background-color: rgb(206, 206, 206);">
                                            <img src="{{ asset('storage/' . $forum->user->profile) }}" 
                                                alt="{{ $forum->user->name }}" style="height: 50px; width: fit-content;">
                                        </div>
                                        <span class="fw-medium">{{ $forum->user->username }}</span>
                                    </div>
                                    <div class="message text-center mt-1 p-2 pt-0 pb-0">
                                        <p class="mb-1">{{ $forum->content }}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-medium" style="color: #0f01b4;">{{ $forum->created_at->format('F j, Y h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if($forums->isEmpty())
                        <div class="text-center mt-5">
                            <h3>No messages yet!</h3>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Message Input -->
            <div class="container-fluid d-flex justify-content-center align-items-center p-2" 
                style="background-color: rgb(255, 255, 255); height: 100px;">
                <div class="main-container w-100">
                    <form action="{{ route('forum.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="content" class="form-control" placeholder="Type your message here..." 
                                style="background-color: #f8eaa0;" required>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </main>

    <script>
        const currentUserId = {{ auth()->id() }}; // Gets the authenticated user ID
        const currentUserProfile = "{{ asset('storage/' . auth()->user()->profile) }}"; // Gets the authenticated user's profile image


        document.addEventListener("DOMContentLoaded", function () {
        let messageBox = document.getElementById("message-box");
        let isLoading = false;
        let lastMessageId = document.querySelector(".message-card:first-of-type")?.dataset.id || null;

        function loadOlderMessages() {
            if (isLoading || !lastMessageId) return;
            isLoading = true;

            fetch(`/load-more-messages?last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(data => {

                if (!data || Object.keys(data).length === 0) {
                    lastMessageId = null; // No more messages to load
                    return;
                }

                let previousScrollHeight = messageBox.scrollHeight;

                let messages = Object.values(data); // Convert object to array

                console.log("Server Response:", messages); // Debugging line

                messages.reverse().forEach(msg => {
                    let messageHTML;
                    let formattedDate = formatDate(msg.created_at);
                    
                    if (msg.user_id === currentUserId) {
                        // My Message
                        messageHTML = `
                            <div class="my-message w-100">
                                <div class="message-card p-1" data-id="${msg.id}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="message-profile d-flex align-items-center justify-content-center rounded-circle border overflow-hidden" 
                                            style="height: 50px; width: 50px; background-color: rgb(206, 206, 206);">
                                            <img src="${currentUserProfile}" alt="Me" style="height: 50px; width: fit-content;">
                                        </div>
                                        <span class="fw-medium">Me</span>
                                    </div>
                                    <div class="message text-center mt-1 p-2 pt-0 pb-0">
                                        <p class="mb-1">${msg.content}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-medium" style="color: #0f01b4;">${formattedDate}</span>
                                    </div>
                                </div>
                            </div>`;
                    } else {

                        // Someone's Message
                        messageHTML = `
                            <div class="someone-message w-100">
                                <div class="message-card p-1" data-id="${msg.id}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="message-profile d-flex align-items-center justify-content-center rounded-circle border overflow-hidden" 
                                            style="height: 50px; width: 50px; background-color: rgb(206, 206, 206);">
                                            <img src="/storage/${msg.user.profile}" alt="${msg.user.name}" style="height: 50px; width: fit-content;">
                                        </div>
                                        <span class="fw-medium">${msg.user.username}</span>
                                    </div>
                                    <div class="message text-center mt-1 p-2 pt-0 pb-0">
                                        <p class="mb-1">${msg.content}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-medium" style="color: #0f01b4;">${formattedDate}</span>
                                    </div>
                                </div>
                            </div>`;
                    }

                    messageBox.insertAdjacentHTML("afterbegin", messageHTML);
                });

                // Update lastMessageId to the new first message
                lastMessageId = messages[0]?.id || null;

                // Maintain scroll position (prevent jump)
                let newScrollHeight = messageBox.scrollHeight;
                messageBox.scrollTop += newScrollHeight - previousScrollHeight;
            })
            .catch(error => console.error("Error loading messages:", error))
            .finally(() => isLoading = false);
        }

        // Detect when scrolling to the top (5px tolerance to prevent edge cases)
        messageBox.addEventListener("scroll", function () {
            if (messageBox.scrollTop <= 5 && lastMessageId) {
                loadOlderMessages();
            }
        });

        // Function to auto-scroll to the latest message on load
        function updateScroll() {
            messageBox.scrollTop = messageBox.scrollHeight;
        }

        // Format The Date String
        function formatDate(dateString) {
            const date = new Date(dateString);

            const optionsDate = { month: "long", day: "2-digit", year: "numeric" };
            const optionsTime = { hour: "2-digit", minute: "2-digit", hour12: true };

            const formattedDate = date.toLocaleDateString("en-US", optionsDate);
            const formattedTime = date.toLocaleTimeString("en-US", optionsTime);

            return `${formattedDate} ${formattedTime}`;
        }

        updateScroll();
    });
    </script>

@endsection