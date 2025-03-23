<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property int $id
 * @property string $nombre
 * @property string $estatus
 *
 * @property Privilegio[] $privilegios
 * @property User[] $users
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['estatus'], 'string'],
            [['nombre'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'estatus' => 'Estatus',
        ];
    }

    /**
     * Gets query for [[Privilegios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrivilegios()
    {
        return $this->hasMany(Privilegio::class, ['id_rol' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id_rol' => 'id']);
    }

    public function getNombreEstatus(){
        return $this->nombre.' '.($this->estatus?'(Habilitado)':'(Deshabilitado)');
    }
}
