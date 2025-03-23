<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_suscripcion
 * @property string|null $tipo
 * @property string|null $fecha_apertura
 * @property string|null $fecha_cierre
 * @property string|null $status
 * @property string|null $descripcion
 * @property int|null $id_calificacion
 *
 * @property Respuesta[] $respuestas
 * @property Suscripciones $suscripcion
 * @property User $usuario
 * @property UsuarioTic[] $usuarioTics
 * @property Privilegio[] $privilegios
 * @property User[] $users
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_suscripcion'], 'required'],
            [['id_usuario', 'id_suscripcion', 'id_calificacion'], 'integer'],
            [['tipo', 'status', 'descripcion'], 'string'],
            [['fecha_apertura', 'fecha_cierre'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_suscripcion'], 'exist', 'skipOnError' => true, 'targetClass' => Suscripciones::class, 'targetAttribute' => ['id_suscripcion' => 'id']],
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
            'id_suscripcion' => 'Id Suscripcion',
            'tipo' => 'Tipo',
            'fecha_apertura' => 'Fecha Apertura',
            'fecha_cierre' => 'Fecha Cierre',
            'status' => 'Status',
            'descripcion' => 'Descripcion',
            'id_calificacion' => 'Id Calificacion',
        ];
    }

    /**
     * Gets query for [[Respuestas]].
     *
     * @return \yii\db\ActiveQuery
     */

     public function getPrivilegios()
     {
         return $this->hasMany(Privilegio::class, ['id_accion' => 'id']);
     }
     public function getNombreEstatus(){
        return $this->nombre.' '.($this->estatus?'(Habilitado)':'(Deshabilitado)');
    }
 
    public function getRespuestas()
    {
        return $this->hasMany(Respuesta::class, ['id_ticket' => 'id']);
    }
    

    /**
     * Gets query for [[Suscripcion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuscripcion()
    {
        return $this->hasOne(Suscripciones::class, ['id' => 'id_suscripcion']);
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

    /**
     * Gets query for [[UsuarioTics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioTics()
    {
        return $this->hasMany(UsuarioTic::class, ['id_ticket' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_usuario']);
    }
    

public function getSuscripciones()
{
    return $this->hasOne(Suscripciones::class, ['id' => 'id_suscripcion']);
}

}
