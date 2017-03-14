<?php

namespace app\controllers;

use app\models\Disciplina;
use app\models\Horario;
use app\models\Semana;
use app\models\Turma;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HorarioController implements the CRUD actions for Horario model.
 */
class HorarioController extends Controller
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
     * Lists all Horario models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $searchModel = new HorarioSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
           // 'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horario model.
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
     * Creates a new Horario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Horario model.
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
     * Deletes an existing Horario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    //Retorna as disciplinas referentes a turma
    public function actionGetDisciplinasTurma() {
        $id = Yii::$app->request->post()['id'];
        $turma = Turma::find()->where(['id' => "$id"])->one();
        $query = Disciplina::find()->select(['id', 'nome'])->where(['curso' => "$turma->curso"])->andWhere(['semestre_ref' => "$turma->semestre"])->asArray()->all();
        
        $disciplinas = [];
        foreach ($query as $disciplina) {
            $disciplinas[$disciplina['id']] = $disciplina['nome'];
        }
       
        return json_encode($disciplinas);
    }
    
    //Retorna os dias da semana livres
    public function actionGetDiasDaSemanaLivres() {
        #retorna a multiplicação de salas por períodos
        $salas_periodos = Yii::$app->db->createCommand('SELECT 
            ((SELECT COUNT(*) FROM cronograma.sala) * (SELECT COUNT(*) FROM cronograma.periodo)) AS total
        FROM
            cronograma.sala
        LIMIT 1') ->queryOne()['total'];
        
        $semanas = ArrayHelper::map(Semana::find()->all(), 'id', 'dia');
        $diasLivres = $semanas;
        foreach ($semanas as $key => $value) {
            $qtd_registros = Yii::$app->db->createCommand("SELECT 
                COUNT(*) AS qtd
            FROM
                cronograma.semana_sala_periodo
            WHERE
                semana = $key") ->queryOne()['qtd'];
            if ($salas_periodos == $qtd_registros) {
                unset($diasLivres[$key]);
            }
        }
        
        echo "<pre>"; die(var_dump($diasLivres));
    }

    /**
     * Finds the Horario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
