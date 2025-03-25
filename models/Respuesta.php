<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta".
 *
 * @property int $id
 * @property int $id_ticket
 * @property int $id_usuario
 * @property string|null $respuesta
 * @property string|null $fecha
 *
 * @property Ticket $ticket
 * @property User $usuario
 */
class Respuesta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuesta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ticket', 'id_usuario'], 'required'],
            [['id_ticket', 'id_usuario'], 'integer'],
            [['respuesta'], 'string'],
            [['fecha'], 'safe'],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['id_ticket' => 'id']],
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
            'id_ticket' => 'Id Ticket',
            'id_usuario' => 'Id Usuario',
            'respuesta' => 'Respuesta',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['id' => 'id_ticket']);
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
