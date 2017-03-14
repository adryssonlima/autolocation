<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sala".
 *
 * @property integer $id
 * @property string $identificador
 * @property string $tipo
 *
 * @property Horario[] $horarios
 */
class Sala extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sala';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identificador', 'tipo'], 'required'],
            [['identificador', 'tipo'], 'string', 'max' => 45],
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
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horario::className(), ['sala' => 'id']);
    }
}
