<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso".
 *
 * @property integer $id
 * @property string $nome
 * @property integer $qtd_semestre
 * 
 * @property Disciplina[] $disciplinas
 * @property Turma[] $turmas
 */
class Curso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'qtd_semestre'], 'required'],
            [['qtd_semestre'], 'integer'],
            [['nome'], 'string', 'max' => 100],
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
            'qtd_semestre' => 'Quantidade de Semestres'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplinas()
    {
        return $this->hasMany(Disciplina::className(), ['curso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurmas()
    {
        return $this->hasMany(Turma::className(), ['curso' => 'id']);
    }
}
