
//cria a conexão
var mysql      = require('mysql');
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : '1234',
	database : 'cronograma'
});

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

var dados;
//teste a conexão
connection.connect(function(err) {
    if (err) {
        console.error('error connecting: ' + err.stack);
        return;
    }
    console.log('connected as id ' + connection.threadId);
});
//query
connection.query('SELECT * FROM curso', function (error, results, fields) {
    if (error) throw error;
    dados = results;
});

//setInterval(function() {
    app.get('/', function(req, res){
        res.send(dados);
    });
//}, 2000);

/*
setInterval(function() {
    console.log("setInterval: Ja passou 2 segundos!");
    io.on('connection', function(socket){
        socket.on('data', function(data){
            io.emit('data', 'data');
        });
    });
    //query
    /*connection.query('SELECT * FROM curso', function (error, results, fields) {
    	if (error) throw error;
        io.on('connection', function(socket){
            socket.on('data', function(results){
                io.emit('data', results);
            });
        });
    	//console.log(results);
    });
}, 2000);
*/
connection.end();


http.listen(3000, function(){
  console.log('listening on *:3000');
});
