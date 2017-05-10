<?php

namespace app\controllers;

use Yii;
use app\models\Curso;
use app\models\Disciplina;
use app\models\CursoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CursoController implements the CRUD actions for Curso model.
 */
class CursoController extends Controller
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
     * Lists all Curso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Curso model.
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
     * Creates a new Curso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Curso();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            //echo"<pre>";die(var_dump($data));
            $model->nome = $data['Curso']['nome'];
            $model->qtd_semestre = count($data['Curso']['semestres']);
            if (!$model->save()) {
                die('erro ao cadastrar curso');
            } else if (!$this->createDisciplinas($model->id, $data['Curso']['semestres'])) {
                die('erro ao cadastrar disciplina');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function createDisciplinas($curso_id, $semestres_disciplinas) {
        foreach ($semestres_disciplinas as $semestre => $disciplinas) {
            if ($disciplinas != "") {
                foreach ($disciplinas['disciplinas'] as $disciplina) {
                    $model = new Disciplina();
                    $model->nome = $disciplina['nome'];
                    $model->cht = $disciplina['cht'];
                    $model->chp = $disciplina['chp'];
                    $model->chc = $disciplina['chc'];
                    $model->curso = $curso_id;
                    $model->semestre_ref = $semestre;
                    if(!$model->save()) {
                        return false;
                    }
                }
            }

        }
        return true;
    }

    /**
     * Updates an existing Curso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $curso = $this->findModel($id);
        $all_disciplinas = Disciplina::find()->where(['curso' => $id])->asArray()->all();
        $disciplinas_set_horarios = Disciplina::getDisciplinasHorarios($id, $all_disciplinas);

        if ($curso->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $curso->nome = $data['Curso']['nome'];
            $curso->qtd_semestre = count($data['Curso']['semestres']);

            $this->updateCurso($curso->id, $data['Curso']);

            //echo"<pre>";die(var_dump($data['Curso']['semestres']));
            /*if (!$curso->save()) {
                die('erro ao cadastrar curso');
            } else if (!$this->updateCurso($curso->id, $data['Curso'])) {
                die('erro ao cadastrar disciplina');
            }*/
            return $this->redirect(['index']);
            //echo"<pre>";die(var_dump($curso));
        } else {
            return $this->render('update', [
                'curso' => $curso,
                'disciplinas' => json_encode($disciplinas_set_horarios)
            ]);
        }
    }

    public function updateCurso($curso_id, $data) {

        //metodos para inclusão de semestres
        //metodo para exclusão de semestres

        echo"<pre>";die(var_dump($data));

        if ( isset($data['removidas']) ) {
            if ( !$this->removeDisciplinas($data['removidas']) ) {
                return false;
            }
        }
        if ( !$this->updateDisciplinas($curso_id, $data['semestres']) ) {
            return false;
        }

        if ( !$this->createDisciplina($curso_id, $data['semestres']) ) {
            return false;
        }

        return true;

    }
    /*
     * Remoção de disciplinas
     */
    private function removeDisciplinas($disciplinas) {
        foreach($disciplinas as $id) {
            if (($model = Disciplina::findOne($id)) !== null) {
                if(!$model->delete()){
                    return false;
                }
            }
        }
        return true;
    }
    /*
     * Update de disciplinas
     */
    private function updateDisciplinas($curso_id, $semestres) {
        foreach ($semestres as $semestre => $disciplinas) {
            if ($disciplinas != "") {
                foreach ($disciplinas['disciplinas'] as $disciplina) {
                    if ( ($model = Disciplina::findOne($disciplina['id'])) !== null ) {
                        $model->nome = $disciplina['nome'];
                        $model->cht = $disciplina['cht'];
                        $model->chp = $disciplina['chp'];
                        $model->chc = $disciplina['chc'];
                        $model->curso = $curso_id;
                        $model->semestre_ref = $semestre;
                        if(!$model->save()) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }
    /*
     * Criação de disciplinas
     */
    private function createDisciplina($curso_id, $semestres) {
        foreach ($semestres as $semestre => $disciplinas) {
            if ($disciplinas != "") {
                foreach ($disciplinas['disciplinas'] as $disciplina) {
                    if ($disciplina['id'] == "") {
                        $model = new Disciplina;
                        $model->nome = $disciplina['nome'];
                        $model->cht = $disciplina['cht'];
                        $model->chp = $disciplina['chp'];
                        $model->chc = $disciplina['chc'];
                        $model->curso = $curso_id;
                        $model->semestre_ref = $semestre;
                        if(!$model->save()) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Deletes an existing Curso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->post("remover")) {
            $model->delete();
            return $this->redirect(['index']);
        } else {
            return $this->render('delete', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Curso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Curso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Curso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
