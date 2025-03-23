<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_cal".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_calificaciones
 * @property string|null $fecha_insercion
 *
 * @property Calificaciones $calificaciones
 * @property User $usuario
 */
class UsuarioCal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_cal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_calificaciones'], 'required'],
            [['id_usuario', 'id_calificaciones'], 'integer'],
            [['fecha_insercion'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_calificaciones'], 'exist', 'skipOnError' => true, 'targetClass' => Calificaciones::class, 'targetAttribute' => ['id_calificaciones' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'id_calificaciones' => 'Id Calificaciones',
            'fecha_insercion' => 'Fecha Insercion',
        ];
    }

    /**
     * Gets query for [[Calificaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCalificaciones()
    {
        return $this->hasOne(Calificaciones::class, ['id' => 'id_calificaciones']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::class, ['id' => 'id_usuario']);
    }
}
