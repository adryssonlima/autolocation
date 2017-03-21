<?php

namespace app\controllers;

use app\models\Curso;
use app\models\Turma;
use app\models\Sala;
use app\models\Disciplina;
use app\models\TurmaSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        //return $model->save();
        echo"<pre>"; die(var_dump($model));
    }
    //Retorna os Horarios indisponiveis
    public function actionHorariosOcupados() {
        $qtdsalas = Yii::$app->db->createCommand('SELECT COUNT(*) as qtd FROM cronograma.sala')->queryOne()['qtd'];
        $semana_sala_periodo = Yii::$app->db->createCommand('SELECT * FROM cronograma.semana_sala_periodo')->queryAll();
        $dias_horarios_indisponiveis = [];
        foreach ($semana_sala_periodo as $key) {
            $qtdrg = Yii::$app->db->createCommand("SELECT
                    COUNT(*) AS qtd
                FROM
                    cronograma.semana_sala_periodo
                WHERE
                    semana = ".$key['semana']." AND periodo = ".$key['periodo'])->queryOne()['qtd'];

            if ($qtdrg == $qtdsalas) {
                $dias_horarios_indisponiveis[] = $key['semana'].$key['periodo'];
            }
        }
        return json_encode($dias_horarios_indisponiveis);
    }

    public function actionGetSalasDisciplinas() {
        $data = Yii::$app->request->post();
        $salas = ArrayHelper::map(Sala::find()->all(), 'id', 'identificador');
        $salas_indisponiveis = Yii::$app->db->createCommand("SELECT
                s.id, s.identificador
            FROM
                cronograma.semana_sala_periodo AS ssp
                    INNER JOIN
                cronograma.sala AS s ON (ssp.sala = s.id)
            WHERE
                semana = ".$data["id_dia"]." AND periodo = ".$data["id_periodo"])->queryAll();

        foreach ($salas_indisponiveis as $value) {
            unset($salas[$value['id']]);
        }

        $disciplinas = Disciplina::find()->select(['id', 'nome'])->where(['curso' => $data['id_curso']])->andWhere(['semestre_ref' => $data['semestre']])->asArray()->all();

        $dados = json_encode(['salas' => $salas, 'disciplinas' => $disciplinas]);

        return $dados;

        #echo"<pre>"; die(var_dump($dados));
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Turma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
