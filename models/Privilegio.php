<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "privilegio".
 *
 * @property int $id
 * @property int $id_rol
 * @property int $id_seccion
 * @property int|null $id_accion
 * @property string $estatus
 *
 * @property Accion $accion
 * @property Rol $rol
 * @property Seccion $seccion
 */
class Privilegio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'privilegio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_seccion'], 'required'],
            [['id_rol', 'id_seccion', 'id_accion'], 'integer'],
            [['estatus'], 'string'],
            [['id_rol', 'id_seccion', 'id_accion'], 'unique', 'targetAttribute' => ['id_rol', 'id_seccion', 'id_accion']],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::class, 'targetAttribute' => ['id_rol' => 'id']],
            [['id_seccion'], 'exist', 'skipOnError' => true, 'targetClass' => Seccion::class, 'targetAttribute' => ['id_seccion' => 'id']],
            [['id_accion'], 'exist', 'skipOnError' => true, 'targetClass' => Accion::class, 'targetAttribute' => ['id_accion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rol' => 'Id Rol',
            'id_seccion' => 'Id Seccion',
            'id_accion' => 'Id Accion',
            'estatus' => 'Estatus',
        ];
    }

    /**
     * Gets query for [[Accion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccion()
    {
        return $this->hasOne(Accion::class, ['id' => 'id_accion']);
    }

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::class, ['id' => 'id_rol']);
    }

    /**
     * Gets query for [[Seccion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccion()
    {
        return $this->hasOne(Seccion::class, ['id' => 'id_seccion']);
    }

    public function getDescripcion(){
        return 'Sección: '.$this->seccion->nombre.' '.
               ($this->accion ? ' - Acción: '.$this->accion->nombre : '');
    }
}
