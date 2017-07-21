<?php

namespace app\controllers;

use app\models\Curso;
use app\models\Turma;
use app\models\Sala;
use app\models\Semana;
use app\models\Periodo;
use app\models\Disciplina;
use app\models\TurmaSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

date_default_timezone_set('America/Fortaleza');
/**
 * TurmaController implements the CRUD actions for Turma model.
 */
class TurmaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Turma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TurmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Turma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Yii::$app->db->createCommand("SELECT 
                t.id,
                t.identificador,
                c.nome AS curso,
                t.semestre,
                CASE t.turno
                    WHEN 'M' THEN 'Manhã'
                    WHEN 'T' THEN 'Tarde'
                    WHEN 'N' THEN 'Noite'
                END AS turno
            FROM
                cronograma.turma AS t
                    INNER JOIN
                cronograma.curso AS c ON (t.curso = c.id)
            WHERE
                t.id = $id")->queryAll();

        $horario = Yii::$app->db->createCommand("SELECT 
                h.*, s.identificador as identificador_sala, d.nome as nome_disciplina
            FROM
                cronograma.horario AS h
                    INNER JOIN
                cronograma.sala AS s ON (h.sala = s.id)
                    INNER JOIN
                cronograma.disciplina as d ON (h.disciplina = d.id)
            WHERE
                h.turma = $id")->queryAll();

        return $this->render('view', [
            'model' => $model,
            'horario' => json_encode($horario),
        ]);
    }

    /**
     * Creates a new Turma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Turma();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->id]);
        //} else {
            return $this->render('create', [
                'model' => $model,
            ]);
        //}
    }

    //Cria uma nova turma
    public function actionNovaTurma() {
        $data = Yii::$app->request->post();
        $model = new Turma();
        $model->identificador = $data['identificador'];
        $model->curso = $data['curso'];
        $model->semestre = $data['semestre'];
        $model->turno = $data['turno'];
        $model->last_update = date('Y-m-d');
        if ($model->save()) {
            if ($this->createHorarios($model->id, $data['horarios']) >= 1) {
                return $this->redirect(['index']);
            }
        }
        die("Erro ao inserir dados!");
    }

    public function createHorarios($id_turma, $horarios) {
        foreach ($horarios as $key => $horario) {
            $horarios[$key]["turma"] = $id_turma;
        }
        return Yii::$app->db->createCommand()
            ->batchInsert("cronograma.horario", [
                "turma",
                "semana",
                "sala",
                "periodo",
                "disciplina"
            ], $horarios)->execute();
    }

    //Retorna os Horarios indisponiveis
    public function actionHorariosOcupados() {
        $qtdsalas = Yii::$app->db->createCommand('SELECT COUNT(*) as qtd FROM cronograma.sala')->queryOne()['qtd'];
        $horarios = Yii::$app->db->createCommand('SELECT * FROM cronograma.horario')->queryAll();
        $dias_horarios_indisponiveis = [];
        foreach ($horarios as $key) {
            $qtdrg = Yii::$app->db->createCommand("SELECT
                    COUNT(*) AS qtd
                FROM
                    cronograma.horario
                WHERE
                    semana = ".$key['semana']." AND periodo = ".$key['periodo'])->queryOne()['qtd'];

            if ($qtdrg == $qtdsalas) {
                $dias_horarios_indisponiveis[] = $key['semana'].$key['periodo'];
            }
        }
        $dias_horarios_indisponiveis = array_unique($dias_horarios_indisponiveis); //Remove o valores duplicados do array
        return json_encode($dias_horarios_indisponiveis);
    }

    public function actionGetSalasDisciplinas() {
        $data = Yii::$app->request->post();
        $salas = ArrayHelper::map(Sala::find()->all(), 'id', 'identificador');
        $salas_indisponiveis = Yii::$app->db->createCommand("SELECT
                s.id, s.identificador
            FROM
                cronograma.horario AS ssp
                    INNER JOIN
                cronograma.sala AS s ON (ssp.sala = s.id)
            WHERE
                semana = ".$data["id_dia"]." AND periodo = ".$data["id_periodo"])->queryAll();

        foreach ($salas_indisponiveis as $value) {
            unset($salas[$value['id']]);
        }
        $disciplinas = ArrayHelper::map(Disciplina::find()->select(['id', 'nome'])->where(['curso' => $data['id_curso']])->andWhere(['semestre_ref' => $data['semestre']])->all(), 'id', 'nome');
        $salasDisciplinas = ['salas' => $salas, 'disciplinas' => $disciplinas];
        #echo"<pre>"; die(var_dump($salas));
        return json_encode($salasDisciplinas);
    }

    public function actionGetDiasPeriodos() {
        $turno = Yii::$app->request->post()['turno'];
        $dias = Semana::find()->select(['id', 'dia'])->asArray()->all();
        $periodos = Periodo::find()->select(['id', 'identificador', 'intervalo'])->where(['turno' => "$turno"])->asArray()->all();
        $diasPeriodos = ['dias' => $dias, 'periodos' => $periodos];
        //echo"<pre>"; die(var_dump($diasPeriodos));
        return json_encode($diasPeriodos);
    }

    /**
     * Updates an existing Turma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {    
        $model = $this->findModel($id);
        $horario = Yii::$app->db->createCommand("SELECT 
                h.*, s.identificador as identificador_sala, d.nome as nome_disciplina
            FROM
                cronograma.horario AS h
                    INNER JOIN
                cronograma.sala AS s ON (h.sala = s.id)
                    INNER JOIN
                cronograma.disciplina as d ON (h.disciplina = d.id)
            WHERE
                h.turma = $id")->queryAll();

        return $this->render('update', [
            'model' => $model,
            'horario' => json_encode($horario),
        ]);
    }

    public function actionUpdateTurma() {
        $data = Yii::$app->request->post();
        $model = $this->findModel($data['id']);
        $model->identificador = $data['identificador'];
        $model->semestre = $data['semestre'];
        $model->last_update = date('Y-m-d');
        if ($model->save()) {
            $delete = Yii::$app->db->createCommand()
                        ->delete('cronograma.horario', ['turma' => $model->id])
                        ->execute();
            if ($delete) {
                if ($this->createHorarios($model->id, $data['horarios']) >= 1) {
                    return $this->redirect(['index']);
                }
            }
        }
        die("Erro ao editar dados!");
    }

    /**
     * Deletes an existing Turma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$id = Yii::$app->request->post('id');
        $model = $this->findModel($id);

        if (Yii::$app->request->post("remover")) {
            $delete = Yii::$app->db->createCommand()
                        ->delete('cronograma.horario', ['turma' => $model->id])
                        ->execute();
            if ($delete) {
                $model->delete();
                return $this->redirect(['index']);
            } else {
                die("Erro ao excluir turma");
            }
        } else {
            $model = Yii::$app->db->createCommand("SELECT 
                    t.id,
                    t.identificador,
                    c.nome AS curso,
                    t.semestre,
                    CASE t.turno
                        WHEN 'M' THEN 'Manhã'
                        WHEN 'T' THEN 'Tarde'
                        WHEN 'N' THEN 'Noite'
                    END AS turno
                FROM
                    cronograma.turma AS t
                        INNER JOIN
                    cronograma.curso AS c ON (t.curso = c.id)
                WHERE
                    t.id = $id")->queryAll();

            $horario = Yii::$app->db->createCommand("SELECT 
                    h.*, s.identificador as identificador_sala, d.nome as nome_disciplina
                FROM
                    cronograma.horario AS h
                        INNER JOIN
                    cronograma.sala AS s ON (h.sala = s.id)
                        INNER JOIN
                    cronograma.disciplina as d ON (h.disciplina = d.id)
                WHERE
                    h.turma = $id")->queryAll();
            
            return $this->render('delete', [    
                'model' => $model,
                'horario' => json_encode($horario),
            ]);
        }
    }

    //Retorna a quantidade de semestres do curso
    public function actionGetQuantidadeSemestres() {
        $id = Yii::$app->request->post()['id'];
        $curso = Curso::find()->where(['id' => "$id"])->one();
        return $curso->qtd_semestre;
    }

    /**
     * Finds the Turma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Turma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Turma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
