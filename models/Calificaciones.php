<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calificaciones".
 *
 * @property int $id
 * @property int|null $calificacion
 *
 * @property UsuarioCal[] $usuarioCals
 */
class Calificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calificacion'], 'required'],
            [['calificacion'], 'integer'],
            [['calificacion'], 'in', 'range' => [1, 10]], // Solo permitir calificación entre 1 y 10
            [['ticket_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calificacion' => 'Calificacion',
        ];
    }

    /**
     * Gets query for [[UsuarioCals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioCals()
    {
        return $this->hasMany(UsuarioCal::class, ['id_calificaciones' => 'id']);
    }
}
