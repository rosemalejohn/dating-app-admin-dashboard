var socket = require('socket.io');
var express = require('express');
var http = require('http');
var app = express();
var server = http.createServer(app);
var io = socket.listen(server);

server.listen(3000, function(){
    console.log('Listening on Port 3000');
});

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('take-chat', function(err, count) {
});

redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message);
    
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

