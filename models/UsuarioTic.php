<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_tic".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_ticket
 * @property string|null $fecha_insercion
 *
 * @property Ticket $ticket
 * @property User $usuario
 */
class UsuarioTic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_tic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_ticket'], 'required'],
            [['id_usuario', 'id_ticket'], 'integer'],
            [['fecha_insercion'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['id_ticket' => 'id']],
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
            'id_ticket' => 'Id Ticket',
            'fecha_insercion' => 'Fecha Insercion',
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
