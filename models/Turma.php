<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turma".
 *
 * @property integer $id
 * @property string $identificador
 * @property integer $curso
 * @property integer $semestre
 * @property string $turno
 *
 * @property Horario[] $horarios
 * @property Curso $curso0
 */
class Turma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'turma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identificador', 'curso', 'semestre', 'turno'], 'required'],
            [['curso'], 'integer'],
            [['identificador'], 'string', 'max' => 45],
            [['semestre'], 'integer'],
            [['turno'], 'string', 'max' => 1],
            [['curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['curso' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identificador' => 'Identificador (Ex: ADS-2017.1)',
            'curso' => 'Curso',
            'semestre' => 'Semestre Atual da Turma',
            'turno' => 'Turno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horario::className(), ['turma' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso0()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso']);
    }
}
