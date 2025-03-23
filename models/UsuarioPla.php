<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_pla".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int|null $id_suscripcion
 * @property string|null $fecha_insercion
 *
 * @property Suscripciones $suscripcion
 * @property User $usuario
 */
class UsuarioPla extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_pla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario'], 'required'],
            [['id_usuario', 'id_suscripcion'], 'integer'],
            [['fecha_insercion'], 'safe'],
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
            'fecha_insercion' => 'Fecha Insercion',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_usuario']);
    }
}
