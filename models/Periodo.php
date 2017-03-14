<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodo".
 *
 * @property integer $id
 * @property string $identificador
 * @property string $intervalo
 * @property string $turno
 *
 * @property Horario[] $horarios
 */
class Periodo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identificador', 'intervalo', 'turno'], 'required'],
            [['identificador', 'intervalo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identificador' => 'Identificador',
            'intervalo' => 'Intervalo',
            'turno' => 'Turno'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horario::className(), ['periodo' => 'id']);
    }
}
