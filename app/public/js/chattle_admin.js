
    let prevchat_id = 0;
    let selectedChatId = null;
    let pollingInterval = null;

    // Poll chat list every 5 seconds
    setInterval(fetchChatList, 5000);

    function fetchChatList() {
        $.get('/chattle/get-chats', function (response) {
            $('#chat-list').empty();
            for (let i = 0; i < response.data.length; i++) {
                let chat = response.data[i];
                let badge = chat.unseen_messages > 0 ? `<div class="badge">${chat.unseen_messages}</div>` : '';
                $('#chat-list').append(`
                    <li onclick="fetchData(this)" class="chat-list-item" id="${chat.id}" data-sender-name="${chat.name}">
                        <span class="chat-list-name">${chat.name} (${chat.email})</span>${badge}
                    </li>
                `);
            }
        });
    }

    function fetchData(elem) {
        $('.chat-list-item').removeClass('active');
        $(elem).addClass('active');
        selectedChatId = $(elem).attr('id');
        $('#chat_id').val(selectedChatId);

        fetchMessages(selectedChatId, $(elem).attr('data-sender-name'));

        if (pollingInterval) {
            clearInterval(pollingInterval);
        }

        pollingInterval = setInterval(function () {
            fetchMessages(selectedChatId, $(elem).attr('data-sender-name'));
        }, 3000); // Poll every 3 seconds
    }

    function fetchMessages(chatId, senderName) {
        $.get('/chattle/get-messages', {chat_id: chatId}, function (response) {
            $('#messagesContainer').empty();
            for (let i = 0; i < response.length; i++) {
                let msg = response[i];
                if (msg.sender === 'admin') {
                    $('#messagesContainer').append(`
                        <div class="message-wrapper reverse">
                            <div class="profile-picture"><svg>...</svg></div>
                            <div class="message-content"><p class="name">Admin</p><div class="message">${msg.message}</div></div>
                        </div>
                    `);
                } else {
                    $('#messagesContainer').append(`
                        <div class="message-wrapper">
                            <div class="profile-picture"><svg>...</svg></div>
                            <div class="message-content"><p class="name">${senderName}</p><div class="message">${msg.message}</div></div>
                        </div>
                    `);
                }
            }
            $('#messagesContainer').finish().animate({
                scrollTop: $('#messagesContainer').prop("scrollHeight")
            }, 250);
        });
    }

    $("#messageForm").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "/chattle/post-message",
            data: {
                'message': $('#message').val(),
                'chat_id': $('#chat_id').val(),
                'sender': 'admin'
            },
            cache: false,
            success: function () {
                $('#message').val("");
                fetchMessages(selectedChatId, $(`#${selectedChatId}`).attr('data-sender-name'));
            }
        });
    });

    // Load more chats (pagination)
    let currPage = 1;
    $("#loading").on('click', function () {
        loadMore(++currPage);
    });

    function loadMore(page) {
        $("#loading").html('Loading...').show();
        $.get('/chattle/get-chats', {page: page}, function (response) {
            $("#loading").html('Load more');
            for (let i = 0; i < response.data.length; i++) {
                let chat = response.data[i];
                let badge = chat.unseen_messages > 0 ? `<div class="badge">${chat.unseen_messages}</div>` : '';
                $('#chat-list').append(`
                    <li onclick="fetchData(this)" class="chat-list-item" id="${chat.id}" data-sender-name="${chat.name}">
                        <span class="chat-list-name">${chat.name} (${chat.email})</span>${badge}
                    </li>
                `);
            }
        });
    }

