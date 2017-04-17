var db = require('./dbconnection');
var io = require("socket.io").listen(3000);

setInterval(function(){
	db.query('SELECT * FROM curso', function(err, result) {
		if (err) throw err;
		io.sockets.emit('listagem de turmas', result);
	});
}, 2000);

