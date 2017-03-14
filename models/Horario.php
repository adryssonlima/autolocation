<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property integer $id
 * @property integer $turma_disciplina
 * @property integer $semana_sala_periodo
 *
 * @property SemanaSalaPeriodo $semanaSalaPeriodo
 * @property TurmaDisciplina $turmaDisciplina
 */
class Horario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'horario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turma_disciplina', 'semana_sala_periodo'], 'required'],
            [['turma_disciplina', 'semana_sala_periodo'], 'integer'],
            [['semana_sala_periodo'], 'exist', 'skipOnError' => true, 'targetClass' => SemanaSalaPeriodo::className(), 'targetAttribute' => ['semana_sala_periodo' => 'id']],
            [['turma_disciplina'], 'exist', 'skipOnError' => true, 'targetClass' => TurmaDisciplina::className(), 'targetAttribute' => ['turma_disciplina' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turma_disciplina' => 'Turma Disciplina',
            'semana_sala_periodo' => 'Semana Sala Periodo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemanaSalaPeriodo()
    {
        return $this->hasOne(SemanaSalaPeriodo::className(), ['id' => 'semana_sala_periodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurmaDisciplina()
    {
        return $this->hasOne(TurmaDisciplina::className(), ['id' => 'turma_disciplina']);
    }
}
