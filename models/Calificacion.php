<?php

namespace app\models;

use Yii;
use app\models\UsuarioTic;

/**
 * This is the model class for table "calificacion".
 *
 * @property int $id
 * @property int $id_ticket
 * @property int $id_usuario
 * @property int|null $rapidez
 * @property int|null $claridad
 * @property int|null $amabilidad
 * @property int|null $puntuacion
 * @property string|null $comentario
 * @property string|null $fecha
 *
 * @property Ticket $ticket
 * @property User $usuario
 */
class Calificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ticket', 'id_usuario'], 'required'],
            [['id_ticket', 'id_usuario', 'rapidez', 'claridad', 'amabilidad', 'puntuacion'], 'integer'],
            [['comentario'], 'string'],
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
            'rapidez' => 'Rapidez',
            'claridad' => 'Claridad',
            'amabilidad' => 'Amabilidad',
            'puntuacion' => 'Puntuacion',
            'comentario' => 'Comentario',
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
    public function getUsuarioTic()
    {
        return $this->hasOne(UsuarioTic::class, ['id_ticket' => 'id_ticket']);
    }

    public function getIdUsuarioFromUsuarioTic()
    {
        // Buscar el id_usuario en la tabla usuario_tic con base en el id_ticket
        $usuarioTic = UsuarioTic::find()->where(['id_ticket' => $this->id_ticket])->one();
    
        // Si encontramos un usuario_tic, buscamos el usuario en la tabla User
        return $usuarioTic && $usuarioTic->usuario ? $usuarioTic->usuario->getNombreUsuario() : 'Sin usuario';
    }
    




}
