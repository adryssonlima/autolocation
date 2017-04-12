var ami = new require('asterisk-manager')('5038', '127.0.0.1', 'nvox', 'nvox_@!&%*', true);
const fs = require('fs');
var io = require("socket.io").listen(8000);
var mysql = require('mysql');
require('shelljs/global');

var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '_vocalixsec663d',
    database: 'nvox'
});

var template = fs.readFileSync('template.html').toString();
var nodemailer = require('nodemailer');
var smtpTransport = require('nodemailer-smtp-transport');
var transporter = nodemailer.createTransport(smtpTransport({
   host: 'enviosites.secrel.com.br',
   port: 587,
   auth: {
       user: 'vocalixftp@vocalix.com.br',
       pass: '7328aad7'
   }
}));

//Não deixa a sessão do mysql cair
setInterval(function () {
   //console.log("Conectou"); 
   connection.query('SELECT 1');
}, 5000);

ami.keepConnected();

ami.on('hangup', function (evt) {
    //console.log(evt);
});

io.on('connection', function (socket) {
	//socket.broadcast("data", evt);
});


ami.on('managerevent', function (evt) {
   
    io.sockets.emit("data", evt); 
    
    if (evt.event == "CEL" && evt.eventname == "CHAN_START") {
	connection.query("INSERT INTO nvox.painel_ramais (ramal,status,data) VALUES (?,?,?);", [evt.calleridnum,evt.eventname,JSON.stringify(evt)]); 
    }   
    if (evt.event == "MessageWaiting") {
	connection.query("SELECT email FROM rtconf.voicemail_users WHERE mailbox = ? LIMIT 1", [evt.mailbox.substring(0,4)], function(err, rows, fields) {
	    if (!err) {
		exec('ls /var/spool/asterisk/voicemail/LOCAL/'+evt.mailbox.substring(0,4)+'/INBOX/ | fgrep wav | tail -n 1', function(status, output) {
			fs.readFile('/var/spool/asterisk/voicemail/LOCAL/'+evt.mailbox.substring(0,4)+'/INBOX/'+output.replace(/\n/g, ""), function (err, data) {
				transporter.sendMail({
					from: 'vocalix@secrel.net.br',
					to: rows[0].email,
					subject: 'VOCALIX::VOICEMAIL',
					attachments: [{'filename': getDateTime('file'), 'content': data}],
					html: template.replace('{title}', 'Você recebeu um novo voicemail!').replace('{text}', '<h3>Remetente: </h3><b>Nome: </b> '+ evt.calleridname +'<br><b>Ramal: </b>'+evt.calleridnum+'<h3>Data/Hora: </h3>'+getDateTime('email')+'<br>')
				});
			});
		});
	    } else {
		console.log('Error while performing Query.');
	    }
	});

    }
   
});


function getDateTime(format) {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;
	
    if (format === "file") {
         return year + ":" + month + ":" + day + ":" + hour + ":" + min + ":" + sec + ".wav";
    } else if (format === "email") {
	 return day + '/' + month + '/' + year + ', às ' + hour + ':' + min + ':' + sec;
    }
}








