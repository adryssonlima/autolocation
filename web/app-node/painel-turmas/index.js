var db = require('./dbconnection');
var io = require("socket.io").listen(3000);

var query = "SELECT t.identificador AS turma, sa.identificador AS sala, d.nome AS disciplina FROM cronograma.horario AS h INNER JOIN cronograma.turma AS t ON (h.turma = t.id) INNER JOIN cronograma.semana AS se ON (h.semana = se.id) INNER JOIN cronograma.sala AS sa ON (h.sala = sa.id) INNER JOIN cronograma.periodo AS p ON (h.periodo = p.id) INNER JOIN cronograma.disciplina AS d ON (h.disciplina = d.id) WHERE se.dia = CASE DATE_FORMAT(NOW(), '%W') WHEN 'Sunday' THEN 'domingo' WHEN 'Monday' THEN 'segunda-feira' WHEN 'Tuesday' THEN 'terça-feira' WHEN 'Wednesday' THEN 'quarta-feira' WHEN 'Thursday' THEN 'quinta-feira' WHEN 'Friday' THEN 'sexta-feira' WHEN 'Saturday' THEN 'sábado' END AND DATE_FORMAT(NOW(), '%H:%i') BETWEEN SUBSTRING_INDEX(p.intervalo, ' ', 1) AND SUBSTRING_INDEX(p.intervalo, ' ', - 1);";

setInterval(function(){
	db.query(query, function(err, result) {
		if (err) throw err;
		io.sockets.emit('listagem de turmas', result);
	});
}, 2000);

/*
SELECT 
    t.identificador AS turma,
    sa.identificador AS sala,
    d.nome AS disciplina
FROM
    cronograma.horario AS h
        INNER JOIN
    cronograma.turma AS t ON (h.turma = t.id)
        INNER JOIN
    cronograma.semana AS se ON (h.semana = se.id)
        INNER JOIN
    cronograma.sala AS sa ON (h.sala = sa.id)
        INNER JOIN
    cronograma.periodo AS p ON (h.periodo = p.id)
        INNER JOIN
    cronograma.disciplina AS d ON (h.disciplina = d.id)
WHERE
    se.dia = CASE DATE_FORMAT(NOW(), '%W')
        WHEN 'Sunday' THEN 'domingo'
        WHEN 'Monday' THEN 'segunda-feira'
        WHEN 'Tuesday' THEN 'terça-feira'
        WHEN 'Wednesday' THEN 'quarta-feira'
        WHEN 'Thursday' THEN 'quinta-feira'
        WHEN 'Friday' THEN 'sexta-feira'
        WHEN 'Saturday' THEN 'sábado'
    END
        AND DATE_FORMAT(NOW(), '%H:%i') BETWEEN SUBSTRING_INDEX(p.intervalo, ' ', 1) AND SUBSTRING_INDEX(p.intervalo, ' ', - 1);
*/

