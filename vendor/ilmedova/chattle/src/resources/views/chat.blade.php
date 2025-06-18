<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
{{-- <link rel="stylesheet" href="{{ asset('/css/chattle_style.css') }}"> --}}

<style>
    /* Mobile-specific fixes */
    .right-side {
        position: fixed;
        right: 20px;
        bottom: 20px;
        width: 350px;
        max-width: calc(100% - 40px);
        z-index: 9999;
    }

    .chat-container {
        display: none;
        height: 500px;
        max-height: 70vh;
    }

    .chat-area {
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        height: calc(100% - 120px);
    }

    .chat-typing-area-wrapper {
        position: relative;
        z-index: 100;
    }

    /* Critical input field fixes */
    .chat-input, .form-input {
        width: 100%;
        padding: 12px 15px;
        font-size: 16px;
        -webkit-appearance: none;
        border-radius: 8px;
        min-height: 50px;
        touch-action: manipulation;
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .right-side {
            width: calc(100% - 40px);
            right: 20px;
        }
        
        .chat-container {
            max-height: 60vh;
        }
        
        .chat-input, .form-input {
            font-size: 16px;
            padding: 15px;
        }
    }

    /* iOS specific fixes */
    @supports (-webkit-touch-callout: none) {
        .chat-input, .form-input {
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }
    }
</style>

<div class="right-side">
    <button class="chat-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>
    </button>
    
    <div class="chat-container">
        <div class="chat-header" style="display: flex">
            <div style="width: 90%">
                <h3>Chat with consultant</h3>
            </div>
            <div style="width: 10%">
                <button class="close-button" style="float: right; margin-top:12px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="chatContactContainer" class="chat-area" style="display:none">
            <form id="contactForm">
                <div class="chat-typing-area">
                    <input name="name" type="text" placeholder="John Doe" class="form-input" id="name">
                </div>
                <br>
                <div class="chat-typing-area">
                    <input name="email" type="text" placeholder="email@gmail.com" class="form-input" id="email">
                </div>
                <br>
                <button type="submit" class="submit-button">
                    Submit
                </button>
            </form>
        </div>
        <div id="messagesContainer" class="chat-area" style="display:none">
            <div class="message-wrapper">
                <div class="profile-picture">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="message-content">
                    <p class="name">Admin</p>
                    <div class="message">Hello! Can I help you?</div>
                </div>
            </div>
        </div>
        <div id="inputContainer" class="chat-typing-area-wrapper">
            <form id="messageForm">
                <div class="chat-typing-area">
                    <input type="text" id="message" placeholder="Type your message..." class="chat-input">
                    <button type="submit" class="send-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form> 
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle chat container
        const chatButton = document.querySelector('.chat-button');
        const chatContainer = document.querySelector('.chat-container');
        const closeButton = document.querySelector('.close-button');
        
        chatButton.addEventListener('click', function() {
            chatContainer.style.display = chatContainer.style.display === 'none' ? 'flex' : 'none';
        });
        
        closeButton.addEventListener('click', function() {
            chatContainer.style.display = 'none';
        });

        // Mobile input focus fix
        const inputs = document.querySelectorAll('.chat-input, .form-input');
        inputs.forEach(input => {
            input.addEventListener('touchstart', function(e) {
                this.focus();
                e.preventDefault();
            }, {passive: false});
            
            // Prevent zoom on focus for iOS
            input.addEventListener('focus', function() {
                document.querySelector('meta[name="viewport"]').content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
            });
        });

        // Prevent form submission from reloading page
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // Your form submission logic here
            });
        });
    });
</script>