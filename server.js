const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: { origin: "*" }
});

io.on('connection', (socket) => {

    socket.on('sendChatToServer', (message) => {
        // Send Message to all clients including me
        // io.sockets.emit('receiveChatFromClient', message);

        // Send Message to other clients
        socket.broadcast.emit('receiveChatFromClient', message);
    });

    socket.on('disconnect', (socket) => {
        console.log('Disconnected');
    });
});

server.listen(3000, () => {
    console.log('Server is running on port 3000');
});
