<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asistencia".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $fecha
 * @property string $hora_entrada
 * @property string|null $hora_salida
 * @property string|null $STATUS
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $usuario
 */
class Asistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'fecha', 'hora_entrada'], 'required'],
            [['id_usuario'], 'integer'],
            [['fecha', 'hora_entrada', 'hora_salida', 'created_at', 'updated_at'], 'safe'],
            [['STATUS'], 'string'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
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
            'fecha' => 'Fecha',
            'hora_entrada' => 'Hora Entrada',
            'hora_salida' => 'Hora Salida',
            'STATUS' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_usuario']);
    }

    public function getSTATUS()
{
    return $this->STATUS ? Yii::$app->formatter->asTime($this->STATUS, 'php:H:i') : '-';
}

}
