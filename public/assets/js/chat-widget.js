document.addEventListener('DOMContentLoaded', function() {
    const chatWidgetContainer = document.getElementById('chatWidgetContainer');
    const chatWidgetHeader = document.getElementById('chatWidgetHeader');
    const chatWidgetBody = document.getElementById('chatWidgetBody');
    const toggleChatWidget = document.getElementById('toggleChatWidget');
    const closeChatWidget = document.getElementById('closeChatWidget');
    const chatMessages = document.getElementById('chatMessages');
    const chatWidgetForm = document.getElementById('chatWidgetForm');
    const chatMessageInput = document.getElementById('chatMessageInput');
    
    // Check if user is authenticated (you might need to adjust this)
    const isAuthenticated = document.querySelector('meta[name="user-id"]') !== null;
    
    // Toggle chat widget
    function toggleWidget() {
        if (chatWidgetBody.style.display === 'none') {
            chatWidgetBody.style.display = 'block';
            toggleChatWidget.innerHTML = '<i class="fas fa-chevron-down"></i>';
            // Scroll to bottom when opening
            scrollToBottom();
        } else {
            chatWidgetBody.style.display = 'none';
            toggleChatWidget.innerHTML = '<i class="fas fa-chevron-up"></i>';
        }
    }
    
    // Close chat widget
    function closeWidget() {
        chatWidgetBody.style.display = 'none';
        toggleChatWidget.innerHTML = '<i class="fas fa-chevron-up"></i>';
    }
    
    // Scroll to bottom of messages
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    
    
    // Show typing indicator
    function showTypingIndicator() {
        // Remove any existing typing indicator
        const existingIndicator = document.querySelector('.typing-indicator');
        if (existingIndicator) existingIndicator.remove();
        
        const typingDiv = document.createElement('div');
        typingDiv.className = 'typing-indicator';
        typingDiv.innerHTML = 'Support is typing <span></span><span></span><span></span>';
        
        chatMessages.appendChild(typingDiv);
        scrollToBottom();
    }
    
    // Hide typing indicator
    function hideTypingIndicator() {
        const typingIndicator = document.querySelector('.typing-indicator');
        if (typingIndicator) typingIndicator.remove();
    }
    
    // Event listeners
    chatWidgetHeader.addEventListener('click', toggleWidget);
    toggleChatWidget.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleWidget();
    });
    
    closeChatWidget.addEventListener('click', function(e) {
        e.stopPropagation();
        closeWidget();
    });
    
    if (isAuthenticated && chatWidgetForm) {
        // Handle form submission
        chatWidgetForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const messageContent = chatMessageInput.value.trim();
            
            // if (messageContent) {
            //     // Add message to UI immediately
            //     addMessage(messageContent, true);
                
            //     // Send message to server
            //     fetch('/conversations/messages', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            //             'Accept': 'application/json'
            //         },
            //         body: JSON.stringify({
            //             content: messageContent,
            //             conversation_id: document.getElementById('activeConversationId')?.value || null
            //         })
            //     })
            //     .then(response => response.json())
            //     .then(data => {
            //         // You might want to update the message with server data (like ID, exact timestamp)
            //         chatMessageInput.value = '';
            //     })
            //     .catch(error => {
            //         console.error('Error sending message:', error);
            //         // Optionally show error to user
            //     });
            // }
        });
    }
    
    // Initialize Pusher for real-time updates
    if (isAuthenticated) {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        
        // const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        //     cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        //     encrypted: true,
        //     authEndpoint: '/broadcasting/auth',
        //     auth: {
        //         headers: {
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //         }
        //     }
        // });
        
        // Subscribe to user's private channel
        const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');
        const channel = pusher.subscribe('private-user.' + userId);
        
        // Listen for new messages
        channel.bind('new-message', function(data) {
            // Only add message if chat is open
            if (chatWidgetBody.style.display === 'block') {
                addMessage(data.message.content, false, data.message.created_at);
            } else {
                // Show notification badge or other indicator
                console.log('New message received while chat is minimized');
            }
        });
        
        // Listen for typing events
        channel.bind('client-typing', function(data) {
            if (data.isTyping) {
                showTypingIndicator();
            } else {
                hideTypingIndicator();
            }
        });
    }
    
    // Auto-open chat widget if URL has hash #chat
    if (window.location.hash === '#chat') {
        toggleWidget();
    }
});