var app = require('http').createServer(handler);
var io = require('socket.io')(app);

var Redis = require('ioredis');
var redis = new Redis();

app.listen(6001, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', function(socket) {
    console.log('Client connected.');

    socket.on('disconnect', function() {
    	console.log('- Client disconnected.');
    });
});

redis.psubscribe('*', function(err, count) {
    console.log('Subscribed on all channels');
});

redis.on('pmessage', function(subscribed, channel, message) {
    console.log('Received new message.');
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});