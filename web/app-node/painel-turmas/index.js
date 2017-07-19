var db = require('./dbconnection');
var io = require("socket.io").listen(3000);

var query = "SELECT t.identificador AS turma, sa.identificador AS sala, d.nome AS disciplina FROM cronograma.horario AS h INNER JOIN cronograma.turma AS t ON (h.turma = t.id) INNER JOIN cronograma.semana AS se ON (h.semana = se.id) INNER JOIN cronograma.sala AS sa ON (h.sala = sa.id) INNER JOIN cronograma.periodo AS p ON (h.periodo = p.id) INNER JOIN cronograma.disciplina AS d ON (h.disciplina = d.id) WHERE se.dia = CASE DATE_FORMAT(NOW(), '%W') WHEN 'Sunday' THEN 'domingo' WHEN 'Monday' THEN 'segunda-feira' WHEN 'Tuesday' THEN 'terça-feira' WHEN 'Wednesday' THEN 'quarta-feira' WHEN 'Thursday' THEN 'quinta-feira' WHEN 'Friday' THEN 'sexta-feira' WHEN 'Saturday' THEN 'sábado' END AND DATE_FORMAT(NOW(), '%H:%i') BETWEEN SUBSTRING_INDEX(p.intervalo, ' ', 1) AND SUBSTRING_INDEX(p.intervalo, ' ', - 1);";

setInterval(function(){
	db.query(query, function(err, result) {
        if (err) throw err;
        result.push({
            'curso' : 'Análise e Desenvolvimento de Sistemas',
            'turma' : 'ADS-2016.2',
            'disciplina' : 'Implementação de Banco de Dados',
            'sala' : 'PGP F01',
            'horario' : '19:00 às 20:20'
        });
        result.push({
            'curso' : 'Administração',
            'turma' : 'ADM-2017.2',
            'disciplina' : 'Introdução à Economia I',
            'sala' : 'PGP F02',
            'horario' : '19:00 as 20:20'
        });
        result.push({
            'curso' : 'Gestão de Recursos Humanos',
            'turma' : 'GRH-2017.2',
            'disciplina' : 'Disciplina de Exemplo',
            'sala' : 'PGP F102',
            'horario' : '19:00 as 20:20'
        });
        result.push({
            'curso' : 'Análise e Desenvolvimento de Sistemas',
            'turma' : 'ADS-2017.2',
            'disciplina' : 'Introdução a Programação',
            'sala' : 'PGP E202',
            'horario' : '19:00 as 20:20'
        });
        result.push({
            'curso' : 'Redes',
            'turma' : 'REDES-2017.2',
            'disciplina' : 'Cálculo',
            'sala' : 'PGP E206',
            'horario' : '19:00 as 20:20'
        });
		io.sockets.emit('listagem de turmas', result);
	});
}, 1000);

/*
use cronograma;

SELECT 
	c.nome AS curso,
    t.identificador AS turma,
    d.nome AS disciplina,
    sa.identificador AS sala,
    p.intervalo AS horario
FROM
    cronograma.horario AS h
        INNER JOIN
    cronograma.turma AS t ON (h.turma = t.id)
        INNER JOIN
	cronograma.curso AS c ON (t.curso = c.id)
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

