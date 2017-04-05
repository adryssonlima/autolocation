//cria a conexão
var mysql      = require('mysql');
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : '1234',
	database : 'cronograma'
});

//teste a conexão
connection.connect(function(err) {
	if (err) throw err;
});


module.exports = connection;
