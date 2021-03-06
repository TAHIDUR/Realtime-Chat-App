<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Chat App</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!--- Vue js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js"
            integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H"
            crossorigin="anonymous"></script>


</head>

<body>

<div class="container text-center mx-auto" id="chat-app">
    <div class="max-w-full mt-4 border rounded">
        <div>
            <div class="w-full">
                <div class="relative flex items-center p-3 border-b border-gray-300">
                    <img class="object-cover w-10 h-10 rounded-full"
                         src="https://cdn.pixabay.com/photo/2018/01/15/07/51/woman-3083383__340.jpg"
                         alt="username"/>
                    <span class="block ml-2 font-bold text-gray-600">User</span>
                    <span class="absolute w-3 h-3 bg-green-600 rounded-full left-10 top-3">
                        </span>
                </div>
                <div class="relative w-full p-6 overflow-y-auto h-[40rem] chattings">

                    <ul class="space-y-2">
                        <li v-for="chat in chats" :class='chat.user!=="me" ? "flex justify-start" : "flex justify-end"'>
                            <div
                                :class='chat.user!=="me" ? "relative max-w-xl px-4 py-2 text-gray-700 rounded shadow" : "relative bg-gray-100 max-w-xl px-4 py-2 text-gray-700 rounded shadow"'>
                                <span v-text="chat.messages" class="block"></span>
                            </div>
                        </li>

                    </ul>

                </div>

                <div class="flex items-center justify-between w-full p-3 border-t border-gray-300">

                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                    </button>

                    <input type="text" placeholder="Message" id="chat-message" ref="chatMessage"
                           v-on:keyup.enter="sendMessage"
                           class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700"
                           name="message" required/>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                        </svg>
                    </button>
                    <button type="submit">
                        <svg class="w-5 h-5 text-gray-500 origin-center transform rotate-90"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var vue = new Vue({
        el: '#chat-app',
        data: {
            chats: [],
            chatMessage: '',
            ip_address: '127.0.0.1',
            socket_port: '3000',
            socket: null,
        },

        created: function () {
            this.socket = io.connect('127.0.0.1:3000');
        },

        async mounted() {
            this.socket.on('receiveChatFromClient', (message) => {
                this.chats.push({
                    user: 'you',
                    messages: message
                });
            });
        },

        methods: {
            sendMessage: function () {
                this.chatMessage = this.$refs.chatMessage.value;

                this.chats.push({
                    user: 'me',
                    messages: this.chatMessage
                });

                this.socket.emit('sendChatToServer', this.chatMessage);
                this.$refs.chatMessage.value = '';
                return false;
            }
        },
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

</body>

</html>
