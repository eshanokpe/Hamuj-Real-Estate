<div id="chatWidgetContainer" class="chat-widget-container">
    <!-- Widget Header -->
    <div id="chatWidgetHeader" class="chat-widget-header">
        <div class="chat-widget-title">
            <i class="fas fa-comments"></i> Need help?
        </div>
        <div class="chat-widget-actions">
            <button id="toggleChatWidget" class="chat-widget-toggle" aria-label="Toggle chat widget">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
    </div>
    
    <!-- Widget Body -->
    <div id="chatWidgetBody" class="chat-widget-body" style="display: none;">
        <div class="chat-widget-body-header">
            <h5>Customer Support</h5>
            <button id="closeChatWidget" class="chat-widget-close" aria-label="Close chat widget">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Messages Container -->
        <div id="chatMessages" class="chat-messages">
            @if(isset($activeConversation))
                @foreach($activeConversation->messages as $message)
                    <div class="message {{ ($message->user_type === 'guest' && $message->user_id === session()->getId()) || 
                                      ($message->user_type === 'registered' && $message->user_id === auth()->id()) ? 'sent' : 'received' }}">
                        <div class="message-content">{{ $message->content }}</div>
                        <span class="message-time">{{ $message->created_at->format('h:i A') }}</span>
                    </div>
                @endforeach
            @else
                <div class="chat-welcome">
                    <p>Hello! How can we help you today?</p>
                    @guest
                    <div class="guest-info-prompt">
                        <p>To help us serve you better, please provide:</p>
                        <div class="guest-info-form">
                            <div class="form-group">
                                <input type="text" id="guestName" placeholder="Your name (optional)" 
                                    maxlength="100" pattern="[A-Za-z ]+" title="Only letters and spaces allowed"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" id="guestEmail" placeholder="Email (optional)" 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address"
                                    class="form-control">
                            </div>
                            <button id="saveGuestInfo" class="btn btn-primary btn-block">Continue Chat</button>
                            <div id="guestValidationErrors" class="validation-errors mt-2"></div>
                        </div>
                    </div>
                    @endguest
                </div>
            @endif
        </div>
        
        <!-- Message Input -->
        <div class="chat-input-container">
            <form id="chatWidgetForm" class="chat-widget-form" style="{{ auth()->check() ? '' : 'display: none;' }}">
                @csrf
                <div class="input-group">
                    <input type="text" id="chatMessageInput" class="form-control chat-message-input" 
                        placeholder="Type your message..." autocomplete="off" maxlength="1000"
                        aria-label="Type your message">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary chat-send-button" aria-label="Send message">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // State management
    const state = {
        isOpen: false,
        isSubmitting: false
    };

    // DOM elements
    const elements = {
        container: document.getElementById('chatWidgetContainer'),
        body: document.getElementById('chatWidgetBody'),
        toggleBtn: document.getElementById('toggleChatWidget'),
        closeBtn: document.getElementById('closeChatWidget'),
        messages: document.getElementById('chatMessages'),
        form: document.getElementById('chatWidgetForm'),
        input: document.getElementById('chatMessageInput'),
        sendBtn: document.querySelector('.chat-send-button')
    };

    // Initialize Pusher if available
    let pusher = null;
    if (typeof Pusher !== 'undefined') {
        pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });
    }

    // User information
    const user = {
        isAuthenticated: document.querySelector('meta[name="user-id"]') !== null,
        isGuest: !document.querySelector('meta[name="user-id"]'),
        sessionId: '{{ session()->getId() }}',
        id: document.querySelector('meta[name="user-id"]')?.content
    };

    // Toggle functions
    function openChat() {
        elements.body.style.display = 'block';
        elements.input?.focus();
        state.isOpen = true;
        elements.toggleBtn.innerHTML = '<i class="fas fa-chevron-down"></i>';
    }

    function closeChat() {
        elements.body.style.display = 'none';
        state.isOpen = false;
        elements.toggleBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    }

    function toggleChat() {
        if (state.isOpen) {
            closeChat();
        } else {
            openChat();
        }
    }

    // Initialize UI
    function initUI() {
        if (elements.toggleBtn) elements.toggleBtn.addEventListener('click', toggleChat);
        if (elements.closeBtn) elements.closeBtn.addEventListener('click', closeChat);
        
        if (window.location.hash === '#chat') {
            openChat();
        }
    }

    // Handle guest information
    function initGuestForm() {
        if (!user.isGuest) return;

        const saveBtn = document.getElementById('saveGuestInfo');
        if (!saveBtn) return;

        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const name = document.getElementById('guestName').value.trim();
            const email = document.getElementById('guestEmail').value.trim();
            const errorContainer = document.getElementById('guestValidationErrors');
            errorContainer.innerHTML = '';
            
            const errors = validateGuestInfo(name, email);
            
            if (errors.length > 0) {
                showValidationErrors(errorContainer, errors);
            } else {
                submitGuestInfo(name, email);
            }
        });
    }

    function validateGuestInfo(name, email) {
        const errors = [];
        
        if (name && !/^[A-Za-z ]+$/.test(name)) {
            errors.push('Name can only contain letters and spaces');
        }
        
        if (email) {
            if (!/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i.test(email)) {
                errors.push('Please enter a valid email address');
            }
            
            if (email.length > 255) {
                errors.push('Email must be less than 255 characters');
            }
        }
        
        return errors;
    }

    function showValidationErrors(container, errors) {
        container.innerHTML = errors.map(error => 
            `<div class="error-item"><i class="fas fa-exclamation-circle"></i> ${error}</div>`
        ).join('');
    }

    async function submitGuestInfo(name, email) {
        try {
            const response = await fetch('/guest/info', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    session_id: user.sessionId,
                    name: name || 'Guest',
                    email: email || null
                })
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            document.querySelector('.guest-info-prompt').style.display = 'none';
            document.getElementById('chatWidgetForm').style.display = 'block';
            openChat();
        } catch (error) {
            document.getElementById('guestValidationErrors').innerHTML = 
                `<div class="error-item"><i class="fas fa-exclamation-circle"></i> Failed to save information. Please try again.</div>`;
            console.error('Error:', error);
        }
    }

    // Message handling
    function addMessage(content, isSent, createdAt = null) {
        if (!elements.messages) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
        
        const displayTime = formatMessageTime(createdAt);
        
        messageDiv.innerHTML = `
            <div class="message-content">${content}</div>
            <span class="message-time">${displayTime}</span>
        `;
        
        elements.messages.appendChild(messageDiv);
        elements.messages.scrollTop = elements.messages.scrollHeight;
        
        if (!state.isOpen) openChat();
    }

    function formatMessageTime(timestamp) {
        if (!timestamp) {
            return new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
        
        if (timestamp.includes('AM') || timestamp.includes('PM')) {
            return timestamp;
        }
        
        const time = new Date(timestamp);
        return time.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    // Message submission
    async function handleMessageSubmit(e) {
        e.preventDefault();
        
        const messageContent = elements.input.value.trim();
        if (!messageContent || state.isSubmitting) return;
        
        try {
            state.isSubmitting = true;
            setSubmitState(true);
            
            addMessage(messageContent, true);
            
            const response = await fetch('/conversations/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    content: messageContent,
                    session_id: user.isGuest ? user.sessionId : null
                })
            });
            
            if (!response.ok) throw new Error('Failed to send message');
            
            const data = await response.json();
            elements.input.value = '';
        } catch (error) {
            console.error('Error:', error);
            // Optionally show error to user
        } finally {
            state.isSubmitting = false;
            setSubmitState(false);
            elements.input.focus();
        }
    }

    function setSubmitState(isSubmitting) {
        elements.input.disabled = isSubmitting;
        elements.sendBtn.disabled = isSubmitting;
        elements.sendBtn.innerHTML = isSubmitting 
            ? '<i class="fas fa-spinner fa-spin"></i>' 
            : '<i class="fas fa-paper-plane"></i>';
    }

    // Real-time updates
    function initRealTimeUpdates() {
        if (!pusher) return;

        // User-specific channel
        const userChannelName = user.isGuest 
            ? `private-guest.${user.sessionId}`
            : `private-user.${user.id}`;
        
        if (userChannelName) {
            const userChannel = pusher.subscribe(userChannelName);
            userChannel.bind('admin-replied', function(data) {
                addMessage(data.message.content, false, data.message.created_at);
            });
        }
        
        // Conversation channel
        @if(isset($activeConversation))
            const convChannel = pusher.subscribe(`conversation.{{ $activeConversation->id }}`);
            convChannel.bind('new-message', function(data) {
                if (data.message.user_type !== 'admin') return;
                addMessage(data.message.content, false, data.message.created_at);
            });
        @endif
    }

    // Initialize everything
    function init() {
        initUI();
        initGuestForm();
        
        if (elements.form) {
            elements.form.addEventListener('submit', handleMessageSubmit);
        }
        
        initRealTimeUpdates();
    }

    init();
});
</script>

<style>


.chat-message-input {
    border-radius: 20px !important;
    border: 1px solid #ddd !important;
    padding: 8px 15px !important;
}

.input-group-append .btn {
    border-radius: 0 20px 20px 0 !important;
}

.chat-send-button {
    transition: all 0.2s ease;
}

.chat-send-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.guest-info-form {
    margin-top: 15px;
}

.validation-errors {
    color: #dc3545;
    font-size: 0.9rem;
}

.error-item {
    margin-bottom: 5px;
}

.chat-welcome {
    padding: 15px;
    text-align: center;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .chat-widget-container {
        width: 90%;
        right: 5%;
        bottom: 10px;
    }
}
</style>