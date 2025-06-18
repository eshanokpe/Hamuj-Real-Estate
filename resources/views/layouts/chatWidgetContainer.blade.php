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
                                      ($message->user_type === 'registered' && $message->user_id === auth()->id()) ? 'sent' : 'received' }}"
                         data-message-id="{{ $message->id }}">
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
            <form id="chatWidgetForm" class="chat-widget-form" style="{{ auth()->check() || isset($activeConversation) ? '' : 'display: none;' }}">
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
        isSubmitting: false,
        conversationId: @json($activeConversation->id ?? null)
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
        sendBtn: document.querySelector('.chat-send-button'),
        guestName: document.getElementById('guestName'),
        guestEmail: document.getElementById('guestEmail'),
        saveGuestBtn: document.getElementById('saveGuestInfo')
    };

    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
                'X-Session-ID': '{{ session()->getId() }}',
                'Authorization': user.isAuthenticated ? `Bearer ${getAuthToken()}` : null
            }
        }
    });

   

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
        
        // Auto-scroll to bottom on load
        if (elements.messages) {
            elements.messages.scrollTop = elements.messages.scrollHeight;
        }
    }

    // Handle guest information
    function initGuestForm() {
        if (!user.isGuest) return;

        elements.saveGuestBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            const name = elements.guestName.value.trim();
            const email = elements.guestEmail.value.trim();
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
            elements.saveGuestBtn.disabled = true;
            elements.saveGuestBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            
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
            elements.form.style.display = 'block';
            
            // Initialize conversation if we got one
            if (data.conversation) {
                state.conversationId = data.conversation.id;
                initRealTimeUpdates();
            }
            
            openChat();
        } catch (error) {
            document.getElementById('guestValidationErrors').innerHTML = 
                `<div class="error-item"><i class="fas fa-exclamation-circle"></i> Failed to save information. Please try again.</div>`;
            console.error('Error:', error);
        } finally {
            if (elements.saveGuestBtn) {
                elements.saveGuestBtn.disabled = false;
                elements.saveGuestBtn.innerHTML = 'Continue Chat';
            }
        }
    }

    // Message handling
    function addMessage(content, isSent, createdAt = null, messageId = null) {
        if (!elements.messages) return;
        
        // Check if message already exists
        if (messageId && document.querySelector(`[data-message-id="${messageId}"]`)) {
            return;
        }
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
        if (messageId) {
            messageDiv.setAttribute('data-message-id', messageId);
        }
        
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
        
        if (typeof timestamp === 'string' && (timestamp.includes('AM') || timestamp.includes('PM'))) {
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
            
            // Add message optimistically
            const tempMessageId = 'temp-' + Date.now();
            addMessage(messageContent, true, new Date(), tempMessageId);
            
            const response = await fetch('/conversations/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    content: messageContent,
                    session_id: user.isGuest ? user.sessionId : null,
                    conversation_id: state.conversationId
                })
            });
            
           if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to send message');
            }
            
            const data = await response.json();
            elements.input.value = '';
            
            // Update conversation ID if this was the first message
            if (data.conversation && !state.conversationId) {
                state.conversationId = data.conversation.id;
                initRealTimeUpdates();
            }
            // Remove temporary message and add the real one when Pusher event comes through
            const tempMessage = document.querySelector(`[data-message-id="${tempMessageId}"]`);
            if (tempMessage) {
                tempMessage.remove();
            }
        } catch (error) {
            console.error('Error:', error);
        
            // Show error to user
            const errorMessage = document.createElement('div');
            errorMessage.className = 'alert alert-danger mt-2';
            errorMessage.textContent = error.message;
            
            // Remove any existing error messages
            document.querySelectorAll('.alert.alert-danger').forEach(el => el.remove());
            
            // Insert after the form
            elements.form.parentNode.insertBefore(errorMessage, elements.form.nextSibling);
            
            // Scroll to show error
            errorMessage.scrollIntoView({ behavior: 'smooth' });
            // Show error to user (could add a retry button)
            alert('Failed to send message. Please try again.');
        } finally {
            state.isSubmitting = false;
            setSubmitState(false);
            elements.input.focus();
        }
    }

    function setSubmitState(isSubmitting) {
        if (elements.input) elements.input.disabled = isSubmitting;
        if (elements.sendBtn) {
            elements.sendBtn.disabled = isSubmitting;
            elements.sendBtn.innerHTML = isSubmitting 
                ? '<i class="fas fa-spinner fa-spin"></i>' 
                : '<i class="fas fa-paper-plane"></i>';
        }
    }

    // Real-time updates
     function initRealTimeUpdates() {
        if (!pusher || !state.conversationId) return;

        try {
            const channel = pusher.subscribe(`private-conversation.${state.conversationId}`);
            
            channel.bind('pusher:subscription_error', (status) => {
                console.error('Subscription failed:', status);
                // Implement retry logic or user notification here
            });

            channel.bind('pusher:subscription_succeeded', () => {
                console.log('Successfully subscribed to channel');
            });

            channel.bind('App\\Events\\NewMessage', (data) => {
                // Handle incoming messages
                const message = data.message;
                const isSent = (message.user_type === 'guest' && message.user_id === user.sessionId) || 
                            (message.user_type === 'registered' && message.user_id === user.id);
                
                addMessage(message.content, isSent, message.created_at, message.id);
            });

        } catch (error) {
            console.error('Channel subscription error:', error);
        }
    }

    // Initialize everything
    function init() {
        initUI();
        initGuestForm();
        
        if (elements.form) {
            elements.form.addEventListener('submit', handleMessageSubmit);
        }
        
        if (state.conversationId) {
            initRealTimeUpdates();
        }
    }

    init();
});
</script>

<style>
.chat-widget-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    max-width: 100%;
    z-index: 1000;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

.chat-widget-header {
    background: #4361ee;
    color: white;
    padding: 12px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.chat-widget-title {
    font-weight: 600;
    font-size: 16px;
}

.chat-widget-toggle, .chat-widget-close {
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 16px;
    padding: 5px;
}

.chat-widget-body {
    display: none;
    height: 400px;
    flex-direction: column;
    background: #fff;
}

.chat-widget-body-header {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
}

.chat-widget-body-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f9fbfd;
}

.message {
    margin-bottom: 15px;
    max-width: 80%;
}

.message-content {
    padding: 10px 15px;
    border-radius: 18px;
    display: inline-block;
    word-wrap: break-word;
}

.message-time {
    display: block;
    font-size: 11px;
    color: #999;
    margin-top: 5px;
}

.sent .message-content {
    background: #4361ee;
    color: white;
    float: right;
    border-bottom-right-radius: 0;
}

.received .message-content {
    background: white;
    color: #333;
    float: left;
    border-bottom-left-radius: 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.chat-input-container {
    padding: 10px;
    border-top: 1px solid #eee;
    background: #fff;
}

.chat-widget-form {
    display: flex;
}

.input-group {
    width: 100%;
}

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

.guest-info-prompt {
    margin-top: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.guest-info-form {
    margin-top: 15px;
}

.form-group {
    margin-bottom: 10px;
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