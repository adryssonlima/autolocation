<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semana".
 *
 * @property integer $id
 * @property string $dia
 *
 * @property Horario[] $horarios
 */
class Semana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia'], 'required'],
            [['dia'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia' => 'Dia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horario::className(), ['semana' => 'id']);
    }
}
