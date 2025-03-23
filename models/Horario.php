<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property int $id
 * @property string|null $dias
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string|null $tipo
 *
 * @property UsuarioHor[] $usuarioHors
 */
class Horario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dias', 'tipo'], 'string'],
            [['hora_inicio', 'hora_fin'], 'required'],
            [['hora_inicio', 'hora_fin'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dias' => 'Dias',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[UsuarioHors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioHors()
    {
        return $this->hasMany(UsuarioHor::class, ['id_horario' => 'id']);
    }
}
