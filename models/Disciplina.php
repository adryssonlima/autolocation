<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disciplina".
 *
 * @property integer $id
 * @property string $nome
 * @property integer $cht
 * @property integer $chp
 * @property integer $chc
 * @property integer $curso
 * @property integer $semestre_ref
 *
 * @property Curso $curso0
 * @property Horario[] $horarios
 */
class Disciplina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disciplina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'curso', 'semestre_ref'], 'required'],
            [['cht'], 'integer'],
            [['chp'], 'integer'],
            [['chc'], 'integer'],
            [['curso'], 'integer'],
            [['semestre_ref'], 'integer'],
            [['nome'], 'string', 'max' => 100],
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
            'nome' => 'Nome',
            'cdt' => 'CHT',
            'cdp' => 'CHP',
            'cdc' => 'CHC',
            'curso' => 'Curso',
            'semestre_ref' => 'Semestre Referência',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso0()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horario::className(), ['disciplina' => 'id']);
    }
}
