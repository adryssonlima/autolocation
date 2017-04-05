var db = require('./dbconnection');
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);


app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});


setInterval(function(){
	db.query('SELECT * FROM curso', function(err, result) {
		if (err) throw err;
		io.emit('listagem de turmas', result);
	});
}, 2000);


http.listen(3000, function(){
  console.log('listening on *:3000');
});
