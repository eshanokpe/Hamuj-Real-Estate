<!-- Chat Widget Container -->
<div id="chatWidgetContainer" class="chat-widget-container">
    <!-- Widget Header (Minimized State) -->
    <div id="chatWidgetHeader" class="chat-widget-header">
        <div class="chat-widget-title">
            <i class="fas fa-comments"></i> Need help?
        </div>
        <div class="chat-widget-actions">
            <button id="toggleChatWidget" class="chat-widget-toggle">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
    </div>
    
    <!-- Widget Body (Expanded State) -->
    <div id="chatWidgetBody" class="chat-widget-body" style="display: none;">
        <div class="chat-widget-body-header">
            <h5>Customer Support</h5>
            <button id="closeChatWidget" class="chat-widget-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Messages Container -->
        <div id="chatMessages" class="chat-messages">
            @if(isset($activeConversation))
                @foreach($activeConversation->messages as $message)
                    <div class="message {{ ($message->user_type === 'guest' && $message->user_id === session()->getId()) || 
                                        ($message->user_type === 'registered' && $message->user_id === auth()->id()) ? 'sent' : 'received' }}">
                        {{ $message->content }}
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
                                {{-- <small class="form-text text-muted">Optional</small> --}}
                            </div>
                            <div class="form-group">
                                <input type="email" id="guestEmail" placeholder="Email (optional)" 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address"
                                    class="form-control">
                                {{-- <small class="form-text text-muted">Optional - for follow-up</small> --}}
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
                        placeholder="Type your message..." autocomplete="off">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary chat-send-button">
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
    // Check if user is authenticated or guest
    const isAuthenticated = document.querySelector('meta[name="user-id"]') !== null;
    const isGuest = !isAuthenticated;
    const sessionId = '{{ session()->getId() }}';

    // Guest info collection
    if (isGuest) {
        const saveGuestInfoBtn = document.getElementById('saveGuestInfo');
        if (saveGuestInfoBtn) {
            saveGuestInfoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const name = document.getElementById('guestName').value.trim();
                const email = document.getElementById('guestEmail').value.trim();
                const errorContainer = document.getElementById('guestValidationErrors');
                errorContainer.innerHTML = '';
                
                // Validate inputs
                const errors = [];
                
                // Name validation (if provided)
                if (name && !/^[A-Za-z ]+$/.test(name)) {
                    errors.push('Name can only contain letters and spaces');
                }
                
                // Email validation (if provided)
                if (email) {
                    if (!/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i.test(email)) {
                        errors.push('Please enter a valid email address');
                    }
                    
                    if (email.length > 255) {
                        errors.push('Email must be less than 255 characters');
                    }
                }
                
                // Show errors or submit
                if (errors.length > 0) {
                    errorContainer.innerHTML = errors.map(error => 
                        `<div class="error-item"><i class="fas fa-exclamation-circle"></i> ${error}</div>`
                    ).join('');
                } else {
                    // If all validations pass (including empty fields being allowed)
                    submitGuestInfo(name, email);
                }
            });
        }

        function submitGuestInfo(name, email) {
            fetch('/guest/info', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    name: name || 'Guest',
                    email: email || null
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.querySelector('.guest-info-prompt').style.display = 'none';
                document.getElementById('chatWidgetForm').style.display = 'block';
            })
            .catch(error => {
                document.getElementById('guestValidationErrors').innerHTML = 
                    `<div class="error-item"><i class="fas fa-exclamation-circle"></i> Failed to save information. Please try again.</div>`;
                console.error('Error:', error);
            });
        }
    } 
    
    // Helper function to add a message to the chat
    function addMessage(content, isSent, createdAt = null) {
        const chatMessages = document.getElementById('chatMessages');
        if (!chatMessages) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ' + (isSent ? 'sent' : 'received');
        
        // Format the timestamp if it's not already formatted
        let displayTime = createdAt;
        if (createdAt && !createdAt.includes('AM') && !createdAt.includes('PM')) {
            const time = new Date(createdAt);
            displayTime = time.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
        
        messageDiv.innerHTML = `
            ${content}
            <span class="message-time">${displayTime || (new Date()).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Message sending logic
    if (chatWidgetForm) {
        chatWidgetForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const messageContent = chatMessageInput.value.trim();
            
            if (messageContent) {
                addMessage(messageContent, true);
                
                fetch('/conversations/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: messageContent,
                        session_id: isGuest ? sessionId : null
                    }) 
                })
                .then(response => response.json())
                .then(data => {
                    console.error('data sending message:', data);
                    chatMessageInput.value = '';
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            }
        });
    }
    
    // Initialize Pusher for real-time updates
    if (typeof Pusher !== 'undefined') {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });
        // Subscribe to conversation channel
        const conversationChannel = pusher.subscribe('conversation.{{ $conversation->id }}');
        // Listen for new messages
        conversationChannel.bind('new-message', function(data) {
            if (data.message.user_type === 'admin') {
                // Don't show our own messages (we already see them)
                return;
            }
            addMessageToChat(data.message, false);
        });
        
        // Subscribe to appropriate channel
        if (isGuest) {
            const channel = pusher.subscribe('private-guest.' + sessionId);
            channel.bind('admin-replied', function(data) {
                addMessage(data.message.content, false, data.message.created_at);
            });
        } else {
            const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');
            const channel = pusher.subscribe('private-user.' + userId);
            channel.bind('admin-replied', function(data) {
                addMessage(data.message.content, false, data.message.created_at);
            });
        }
    }
    
    // Auto-open chat widget if URL has hash #chat
    if (window.location.hash === '#chat') {
        toggleWidget();
    } 
});
</script>