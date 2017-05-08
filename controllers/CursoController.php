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
            //echo"<pre>";die(var_dump($data['Curso']['semestres']));
            if (!$curso->save()) {
                die('erro ao cadastrar curso');
            } else if (!$this->updateDisciplinas($curso->id, $disciplinas_set_horarios, $data['Curso']['semestres'])) {
                die('erro ao cadastrar disciplina');
            }
            return $this->redirect(['index']);
            //echo"<pre>";die(var_dump($curso));
        } else {
            return $this->render('update', [
                'curso' => $curso,
                'disciplinas' => json_encode($disciplinas_set_horarios)
            ]);
        }
    }

    public function updateDisciplinas($curso_id, $old_disciplinas, $semestres_disciplinas) {

        //remove as disciplinas
        $this->deleteDisciplinas($old_disciplinas, $semestres_disciplinas);

        foreach ($semestres_disciplinas as $semestre => $disciplinas) {
            foreach ($disciplinas['disciplinas'] as $disciplina) {
                //echo"<pre>";die(var_dump($disciplinas['disciplinas']));

                if (($model = Disciplina::findOne($disciplina['id'])) !== null) { //update nas disciplinas existentes
                    $model->nome = $disciplina['nome'];
                    $model->cht = $disciplina['cht'];
                    $model->chp = $disciplina['chp'];
                    $model->chc = $disciplina['chc'];
                    $model->curso = $curso_id;
                    $model->semestre_ref = $semestre;
                    if(!$model->save()) {
                        return false;
                    }
                } else if ($disciplina['id'] == "") { //cria as novas disciplinas
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
        return true;
    }

    public function deleteDisciplinas($old_disciplinas, $semestres_disciplinas) {
        foreach ($semestres_disciplinas as $semestre => $disciplinas) {
            //echo"<pre>";die(var_dump($disciplinas['disciplinas']));
            foreach ($old_disciplinas as $key => $value) {
                if (!($value['horario']) && !($this->is_array_mult($value['id'], $disciplinas['disciplinas']))) {
                    $model = Disciplina::findOne($value['id']);
                    $model->delete();
                }
            }
        }
    }

    public function is_array_mult($id, $array_disciplinas) {
        foreach ($array_disciplinas as $key => $value) {
            if ($id == $value['id']) {
                return true;
            }
        }
        return false;
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
