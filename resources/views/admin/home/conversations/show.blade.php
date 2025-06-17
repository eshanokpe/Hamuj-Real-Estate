@extends('layouts.admin')

@section('content')
<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="page-title mb-1">Support Conversation</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class=""><a href="{{ route('admin.index') }}">Dashboard /</a></li>
                                    <li class=""><a href="{{ route('admin.support.index') }}"> Conversations /</a></li>
                                    <li class=" active" aria-current="page">#{{ $conversation->id }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <span class="badge fs-6 bg-{{ $conversation->is_open ? 'success' : 'danger' }}">
                                {{ $conversation->is_open ? 'Open Ticket' : 'Closed Ticket' }}
                            </span>
                            <a href="{{ route('admin.support.index')}}" class="btn btn-dark">View Conversations</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conversation Card -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <!-- Card Header -->
                        <div class="card-header bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <span class="avatar-title bg-{{ $conversation->user_type === 'registered' ? 'primary' : 'secondary' }} rounded-circle">
                                            {{ substr($conversation->user->name ?? 'G', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">
                                            @if($conversation->user_type === 'registered')
                                                <a href="{{ route('admin.users.show', $conversation->user_id) }}" class="text-dark">
                                                    {{ $conversation->user->name }}
                                                </a>
                                            @else
                                                {{ $conversation->user->name ?? 'Guest User' }}
                                            @endif
                                            <span class="badge ms-2 bg-{{ $conversation->user_type === 'registered' ? 'primary' : 'secondary' }}">
                                                {{ $conversation->user_type === 'registered' ? 'Registered' : 'Guest' }}
                                            </span>
                                        </h5>
                                        <div class="text-muted small">
                                            @if($conversation->user->email ?? false)
                                                <span><i class="far fa-envelope me-1"></i> {{ $conversation->user->email }}</span>
                                            @endif
                                            @if($conversation->user->phone ?? false)
                                                <span class="ms-3"><i class="fas fa-phone-alt me-1"></i> {{ $conversation->user->phone }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i> Export Chat</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-tag me-2"></i> Add Tag</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        @if($conversation->is_open)
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#closeConversationModal">
                                                    <i class="fas fa-lock me-2"></i> Close Conversation
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <form action="{{ route('admin.conversations.reopen', $conversation) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-lock-open me-2"></i> Reopen Conversation
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-0">
                            <!-- Chat Container -->
                            <div class="chat-container p-4" style="height: 60vh; overflow-y: auto;" id="chatContainer">
                                @foreach($conversation->messages as $message)
                                    <div class="message-wrapper d-flex mb-4 {{ $message->user_type === 'admin' ? 'justify-content-end' : 'justify-content-start' }}" data-message-id="{{ $message->id }}">
                                        <div class="message {{ $message->user_type === 'admin' ? 'admin-message' : 'user-message' }}" style="max-width: 75%;">
                                            <div class="message-header d-flex {{ $message->user_type === 'admin' ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                                                @if($message->user_type !== 'admin')
                                                    <div class="avatar-xs me-2">
                                                        <span class="avatar-title bg-light text-dark rounded-circle">
                                                            {{ substr($message->user->name ?? 'C', 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong class="me-2">
                                                        @if($message->user_type === 'admin')
                                                            Admin
                                                        @else
                                                            {{ $message->user->name ?? 'Customer' }}
                                                        @endif
                                                    </strong>
                                                    <small class="text-muted">
                                                        {{ $message->created_at->format('h:i A') }}
                                                        @if($message->read && $message->user_type !== 'admin')
                                                            <i class="fas fa-check-circle text-success ms-1"></i>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="message-body p-3 position-relative">
                                                {!! nl2br(e($message->content)) !!}
                                                <div class="position-absolute top-0 {{ $message->user_type === 'admin' ? 'end-0' : 'start-0' }} translate-middle">
                                                    <div class="bg-{{ $message->user_type === 'admin' ? 'primary' : 'light' }} px-1">
                                                        <i class="fas fa-caret-down text-{{ $message->user_type === 'admin' ? 'primary' : 'light' }}"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Admin Assignment -->
                            <div class="border-top p-4 bg-light">
                                <form action="{{ route('admin.conversations.assign', $conversation) }}" method="POST">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-md-8">
                                            <label class="form-label">Assign to Team Member</label>
                                            <select name="admin_id" class="form-select">
                                                <option value="">-- Unassigned --</option>
                                                @foreach($availableAdmins as $admin)
                                                    <option value="{{ $admin->id }}" {{ $conversation->admin_id == $admin->id ? 'selected' : '' }}>
                                                        {{ $admin->name }} ({{ $admin->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-user-plus me-1"></i> Assign
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Reply Form -->
                            @if($conversation->is_open)
                            <div class="border-top p-4 bg-white">
                                <form id="messageForm" onsubmit="sendMessage(event)">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Your Response</label>
                                        <textarea name="content" class="form-control" rows="3" 
                                                placeholder="Type your message here..." required 
                                                id="messageInput"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button type="button" class="btn btn-outline-secondary me-2">
                                                <i class="fas fa-paperclip"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="fas fa-smile"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" id="sendButton">
                                                <i class="fas fa-paper-plane me-1"></i> Send Message
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Close Conversation Modal -->
<div class="modal fade" id="closeConversationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title">Close Conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p>Are you sure you want to close this conversation? You can reopen it later if needed.</p>
                <div class="mb-3">
                    <label class="form-label">Resolution Notes (Optional)</label>
                    <textarea name="resolution_notes" class="form-control" rows="2" placeholder="Add any final notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.conversations.close', $conversation) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Confirm Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .chat-container {
        background-color: #f9fbfd;
    }
    .message {
        position: relative;
    }
    .message-body {
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .admin-message .message-body {
        background-color: #4361ee;
        color: white;
        border-top-right-radius: 0 !important;
    }
    .user-message .message-body {
        background-color: white;
        border: 1px solid #e9ecef;
        border-top-left-radius: 0 !important;
    }
    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-xs {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
    .dropdown-toggle::after {
        display: none;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }
</style>
@endsection

@section('scripts')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
            }
        }
    });

    // Subscribe to conversation channel
    const channel = pusher.subscribe('private-conversation.{{ $conversation->id }}');

    // Listen for new messages
    channel.bind('App\\Events\\NewMessage', function(data) {
        console.log('New message received:', data);
        const message = data.message;
        const isAdmin = message.user_type === 'admin';
        const container = document.getElementById('chatContainer');
        
        // Check if message already exists to prevent duplicates
        const messageExists = document.querySelector(`[data-message-id="${message.id}"]`) !== null;
        
        if (!messageExists) {
            const messageTime = new Date(message.created_at);
            const formattedTime = messageTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            const messageHtml = `
                <div class="message-wrapper d-flex mb-4 ${isAdmin ? 'justify-content-end' : 'justify-content-start'}" data-message-id="${message.id}">
                    <div class="message ${isAdmin ? 'admin-message' : 'user-message'}" style="max-width: 75%;">
                        <div class="message-header d-flex ${isAdmin ? 'justify-content-end' : 'justify-content-start'} mb-2">
                            ${!isAdmin ? `
                                <div class="avatar-xs me-2">
                                    <span class="avatar-title bg-light text-dark rounded-circle">
                                        ${message.user?.name ? message.user.name.charAt(0) : 'C'}
                                    </span>
                                </div>
                            ` : ''}
                            <div>
                                <strong class="me-2">
                                    ${isAdmin ? 'Admin' : (message.user?.name || 'Customer')}
                                </strong>
                                <small class="text-muted">
                                    ${formattedTime}
                                    ${message.read && !isAdmin ? '<i class="fas fa-check-circle text-success ms-1"></i>' : ''}
                                </small>
                            </div>
                        </div>
                        <div class="message-body p-3 position-relative">
                            ${message.content.replace(/\n/g, '<br>')}
                            <div class="position-absolute top-0 ${isAdmin ? 'end-0' : 'start-0'} translate-middle">
                                <div class="bg-${isAdmin ? 'primary' : 'light'} px-1">
                                    <i class="fas fa-caret-down text-${isAdmin ? 'primary' : 'light'}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', messageHtml);
            container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
        }

        // If message is from user, mark as read
        if (message.user_type !== 'admin' && !message.read) {
            fetch(`/admin/conversations/messages/${message.id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
        }
    });

    // Debugging: Log subscription events
    channel.bind('pusher:subscription_succeeded', function() {
        console.log('Successfully subscribed to conversation channel');
    });

    channel.bind('pusher:subscription_error', function(status) {
        console.error('Subscription error:', status);
    });

    // Auto-scroll to bottom on load
    const container = document.getElementById('chatContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
    
    @if($conversation->is_open)
    document.getElementById('messageInput')?.focus();
    @endif

    // Enhanced message submission
    function sendMessage(event) {
        event.preventDefault();
        
        const form = event.target;
        const button = form.querySelector('#sendButton');
        const messageInput = document.getElementById('messageInput');
        const originalButtonText = button.innerHTML;
        
        // Show loading state
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        // Get form data
        const formData = new FormData(form);
        
        fetch("{{ route('admin.conversations.messages.store', $conversation) }}", {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Clear input on success
            messageInput.value = '';
            
            // If we have the message data, add it to the chat immediately
            if (data.message) {
                const container = document.getElementById('chatContainer');
                const messageTime = new Date(data.message.created_at);
                const formattedTime = messageTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                const messageHtml = `
                    <div class="message-wrapper d-flex mb-4 justify-content-end" data-message-id="${data.message.id}">
                        <div class="message admin-message" style="max-width: 75%;">
                            <div class="message-header d-flex justify-content-end mb-2">
                                <div>
                                    <strong class="me-2">Admin</strong>
                                    <small class="text-muted">${formattedTime}</small>
                                </div>
                            </div>
                            <div class="message-body p-3 position-relative">
                                ${data.message.content.replace(/\n/g, '<br>')}
                                <div class="position-absolute top-0 end-0 translate-middle">
                                    <div class="bg-primary px-1">
                                        <i class="fas fa-caret-down text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', messageHtml);
                container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalButtonText;
            messageInput.focus();
        });
    }
});
</script>
@endsection