// Enable Pusher logging to console - remove in production
Pusher.logToConsole = true;

// Initialize Pusher
const pusher = new Pusher('5499ff5cb459223302e7', {
    wsHost: window.location.hostname,  // Changed from origin to hostname
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    cluster: 'mt1',
    forceTLS: false,
    encrypted: false  // Should be false for http connections
});

// Subscribe to chats update channel
const chatsUpdateChannel = pusher.subscribe('chats-update');
chatsUpdateChannel.bind('chats', function(response) {
    updateChatList(response.chats.data);
});

// Variables to track current chat
let prevChatId = 0;
let currentChannel = null;

// Update chat list function
function updateChatList(chats) {
    $('#chat-list').empty();
    
    chats.forEach(chat => {
        const chatItem = $('<li>', {
            class: 'chat-list-item',
            id: chat.id,
            'data-sender-name': chat.name,
            onclick: 'fetchData(this)'
        }).append(
            $('<span>', {
                class: 'chat-list-name',
                text: `${chat.name} (${chat.email})`
            })
        );

        if (chat.unseen_messages_count > 0) {
            chatItem.append(
                $('<div>', {
                    class: 'badge',
                    text: chat.unseen_messages_count
                })
            );
        }

        $('#chat-list').append(chatItem);
    });
}

// Fetch chat messages
function fetchData(elem) {
    const $elem = $(elem);
    const chatId = $elem.attr('id');
    
    // Update UI
    $('.chat-list-item').removeClass('active');
    $elem.addClass('active');
    $('#chat_id').val(chatId);

    // Fetch messages
    $.ajax({
        url: '/chattle/get-messages',
        method: 'GET',
        data: { chat_id: chatId },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            displayMessages(response, $elem.attr('data-sender-name'));
            subscribeToChatChannel(chatId, $elem.attr('data-sender-name'));
        },
        error: function(xhr) {
            console.error('Error fetching messages:', xhr.responseText);
        }
    });
}

// Display messages in container
function displayMessages(messages, senderName) {
    $('#messagesContainer').empty();
    
    messages.forEach(message => {
        const isAdmin = message.sender === 'admin';
        const messageWrapper = $('<div>', {
            class: `message-wrapper ${isAdmin ? 'reverse' : ''}`
        }).append(
            $('<div>', { class: 'profile-picture' }).html(
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
            ),
            $('<div>', { class: 'message-content' }).append(
                $('<p>', { class: 'name', text: isAdmin ? 'Admin' : senderName }),
                $('<div>', { class: 'message', text: message.message })
            )
        );
        
        $('#messagesContainer').append(messageWrapper);
    });

    scrollToBottom();
}

// Subscribe to specific chat channel
function subscribeToChatChannel(chatId, senderName) {
    // Unsubscribe from previous channel if exists
    if (prevChatId !== 0) {
        if (currentChannel) {
            currentChannel.unbind('my-messages');
        }
        pusher.unsubscribe('chat' + prevChatId);
    }

    // Subscribe to new channel
    currentChannel = pusher.subscribe('chat' + chatId);
    currentChannel.bind('my-messages', function(response) {
        console.log('New message received in chat:', chatId);
        const message = response.message;
        const isAdmin = message.sender === 'admin';
        
        const messageWrapper = $('<div>', {
            class: `message-wrapper ${isAdmin ? 'reverse' : ''}`
        }).append(
            $('<div>', { class: 'profile-picture' }).html(
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
            ),
            $('<div>', { class: 'message-content' }).append(
                $('<p>', { class: 'name', text: isAdmin ? 'Admin' : senderName }),
                $('<div>', { class: 'message', text: message.message })
            )
        );
        
        $('#messagesContainer').append(messageWrapper);
        scrollToBottom();
    });

    prevChatId = chatId;
}

// Scroll to bottom of messages container
function scrollToBottom() {
    $('#messagesContainer').stop().animate({
        scrollTop: $('#messagesContainer').prop("scrollHeight")
    }, 250);
}

// Load more chats
let currPage = 1;
$("#loading").on('click', function() {
    loadMore(++currPage);
});

function loadMore(page) {
    const $loadingBtn = $("#loading");
    $loadingBtn.text('Loading...').prop('disabled', true);
    
    $.ajax({
        url: '/chattle/get-chats',
        method: 'GET',
        data: { page: page },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            response.data.forEach(chat => {
                const chatItem = $('<li>', {
                    class: 'chat-list-item',
                    id: chat.id,
                    'data-sender-name': chat.name,
                    onclick: 'fetchData(this)'
                }).append(
                    $('<span>', {
                        class: 'chat-list-name',
                        text: `${chat.name} (${chat.email})`
                    })
                );

                if (chat.unseen_messages > 0) {
                    chatItem.append(
                        $('<div>', {
                            class: 'badge',
                            text: chat.unseen_messages
                        })
                    );
                }

                $('#chat-list').append(chatItem);
            });
        },
        error: function(xhr) {
            console.error('Error loading more chats:', xhr.responseText);
        },
        complete: function() {
            $loadingBtn.text('Load more').prop('disabled', false);
        }
    });
}

// Handle message form submission
$("#messageForm").on('submit', function(e) {
    e.preventDefault();
    
    const $form = $(this);
    const $messageInput = $('#message');
    const message = $messageInput.val().trim();
    
    if (!message) return;
    
    $.ajax({
        url: '/chattle/post-message',
        method: 'POST',
        data: {
            message: message,
            chat_id: $('#chat_id').val(),
            sender: 'admin'
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function() {
            $messageInput.val('');
            scrollToBottom();
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr.responseText);
            if (xhr.status === 419) {
                alert('Session expired. Please refresh the page.');
            }
        }
    });
});

// Initial load
loadMore(currPage);