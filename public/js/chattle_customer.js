// Global variables
let lastMessageId = 0;
let isPollingActive = true;
let currentChatId = $.cookie("ch");
let currentUserName = $.cookie("nm");
let pollTimeout = null;

// ========== CORE FUNCTIONS ==========

function loadExistingChat(chatId) {
    $.ajax({
        type: "GET",
        url: "/chattle/get-messages",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { chat_id: chatId },
        success: function(response) {
            console.log("Chat loaded:", response);
            $('#messagesContainer').empty();
            if (response.length > 0) {
                appendMessages(response);
                lastMessageId = response[response.length - 1].id;
            }
            showChatWindow();
            pollMessages(); // Start polling after loading chat
        },
        error: function(xhr) {
            console.error("Error loading chat:", xhr.responseText);
        }
    });
}

function createNewChat() {
    $.ajax({
        type: "POST",
        url: "/chattle/create-chat",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            name: $('#name').val(),
            email: $('#email').val()
        },
        success: function(response) {
            console.log("New chat created:", response);
            currentChatId = response.id;
            currentUserName = response.name;
            $.cookie("ch", currentChatId, { expires: 1 });
            $.cookie("nm", currentUserName, { expires: 1 });
            loadExistingChat(currentChatId);
        },
        error: function(xhr) {
            console.error("Error creating chat:", xhr.responseText);
        }
    });
}

// ========== UI FUNCTIONS ==========

function showContactForm() {
    $('#messagesContainer, #inputContainer').hide();
    $('#chatContactContainer').show();
    $('.chat-button').hide();
    $('.chat-container').css("display", "flex");
}

function showChatWindow() {
    $('#chatContactContainer').hide();
    $('#messagesContainer, #inputContainer').show();
    $('.chat-button').hide();
    $('.chat-container').css("display", "flex");
    scrollToBottom();
}

function scrollToBottom() {
    $('#messagesContainer').stop().animate({
        scrollTop: $('#messagesContainer')[0].scrollHeight
    }, 300); 
}

// ========== MESSAGE FUNCTIONS ==========

function pollMessages() {
    if (!isPollingActive || !currentChatId) {
        pollTimeout = setTimeout(pollMessages, 2000);
        return;
    }

    $.ajax({
        type: "GET",
        url: "/chattle/get-messages",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            chat_id: currentChatId,
            last_message_id: lastMessageId
        },
        cache: false,
        timeout: 5000,
        success: function(response) {
            console.log("Polling response:", response);

            const messages = Array.isArray(response) ? response : response.messages;

            if (messages && messages.length > 0) {
                lastMessageId = messages[messages.length - 1].id;
                appendMessages(messages);
            }
        },
        error: function(xhr, status, error) {
            console.error("Polling error:", status, error);
        },
        complete: function() {
            if (pollTimeout) clearTimeout(pollTimeout);
            pollTimeout = setTimeout(pollMessages, 1000);
        }
    });
}

function appendMessages(messages) {
    const $container = $('#messagesContainer');
    const fragment = document.createDocumentFragment();

    messages.forEach(msg => {
        if ($(`[data-message-id="${msg.id}"]`).length > 0) return;

        const wrapper = document.createElement('div');
        wrapper.className = `message-wrapper ${msg.sender === 'admin' ? '' : 'reverse'}`;
        wrapper.dataset.messageId = msg.id;
        wrapper.innerHTML = `
            <div class="profile-picture">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                    <circle cx="12" cy="7" r="4" fill="gray"></circle>
                </svg>
            </div>
            <div class="message-content">
                <p class="name">${msg.sender === 'admin' ? 'Admin' : (currentUserName || 'User')}</p>
                <div class="message">${msg.message}</div>
            </div>
        `;
        fragment.appendChild(wrapper);
    });

    if (fragment.children.length > 0) {
        $container.append(fragment);
        scrollToBottom();
    }
}

async function sendMessage() {
    const $messageInput = $('#message');
    const messageText = $messageInput.val().trim();

    if (!messageText || !currentChatId) return;

    const tempId = 'temp-' + Date.now();
    addTempMessage(tempId, messageText);
    $messageInput.val('').focus();

    try {
        const response = await $.ajax({
            type: "POST",
            url: "/chattle/post-message",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                chat_id: currentChatId,
                sender: 'customer',
                message: messageText
            },
            timeout: 5000
        });

        $(`[data-message-id="${tempId}"]`).attr('data-message-id', response.id);
        if (response.id > lastMessageId) lastMessageId = response.id;
    } catch (error) {
        console.error("Message send error:", error);
        $(`[data-message-id="${tempId}"]`).remove();
        alert('Failed to send message. Please try again.');
    }
}

function addTempMessage(tempId, messageText) {
    $('#messagesContainer').append(`
        <div class="message-wrapper reverse" data-message-id="${tempId}">
            <div class="profile-picture">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                    <circle cx="12" cy="7" r="4" fill="gray"></circle>
                </svg>
            </div>
            <div class="message-content">
                <p class="name">${currentUserName || 'You'}</p>
                <div class="message">${messageText}</div>
            </div>
        </div>
    `);
    scrollToBottom();
}

// ========== INITIALIZATION ==========

function initializeChat() {
    if (currentChatId) {
        loadExistingChat(currentChatId);
    } else {
        showContactForm();
    }
}

function cleanup() {
    isPollingActive = false;
    if (pollTimeout) clearTimeout(pollTimeout);
    $(window).off('beforeunload');
}

$(document).ready(function() {
    // Setup event handlers
    $("#messageForm").on('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });

    $("#contactForm").on('submit', function(e) {
        e.preventDefault();
        userName = $('#name').val();
        userEmail = $('#email').val();

        if (!userName || !userEmail) {
            alert("Please enter your name and email.");
            return;
        } 
        $('#chatContactContainer').hide();
        $('#messagesContainer').show();
        $(".submit-button").prop("disabled", true).text("Connecting...");

        createNewChat();
    });

    $('.close-button').on('click', function() {
        $('.chat-container').hide();
        $('.chat-button').show();
    });

    $('.chat-button').on('click', function() {
        currentChatId ? showChatWindow() : showContactForm();
    });

    // Initialize chat
    initializeChat();

    // Cleanup on page unload
    $(window).on('beforeunload', cleanup);
});