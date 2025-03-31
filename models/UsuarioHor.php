<?php

namespace app\models;

use Yii;
use app\models\Horario;

/**
 * This is the model class for table "usuario_hor".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_horario
 * @property string|null $fecha_insercion
 *
 * @property Horario $horario
 * @property User $usuario
 */
class UsuarioHor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_hor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_horario'], 'required'],
            [['id_usuario', 'id_horario'], 'integer'],
            [['fecha_insercion'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_horario'], 'exist', 'skipOnError' => true, 'targetClass' => Horario::class, 'targetAttribute' => ['id_horario' => 'id']],
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
            'id_horario' => 'Id Horario',
            'fecha_insercion' => 'Fecha Insercion',
        ];
    }

    /**
     * Gets query for [[Horario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorario()
    {
        return $this->hasOne(Horario::class, ['id' => 'id_horario']);
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
