<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seccion".
 *
 * @property int $id
 * @property int|null $id_seccion_superior
 * @property string $nombre
 * @property string $identificador
 * @property string $estatus
 *
 * @property Accion[] $accions
 * @property Privilegio[] $privilegios
 * @property Seccion $seccionSuperior
 * @property Seccion[] $seccions
 */
class Seccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_seccion_superior'], 'integer'],
            [['nombre', 'identificador'], 'required'],
            [['estatus'], 'string'],
            [['nombre'], 'string', 'max' => 150],
            [['identificador'], 'string', 'max' => 80],
            [['identificador'], 'unique'],
            [['id_seccion_superior'], 'exist', 'skipOnError' => true, 'targetClass' => Seccion::class, 'targetAttribute' => ['id_seccion_superior' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_seccion_superior' => 'Id Seccion Superior',
            'nombre' => 'Nombre',
            'identificador' => 'Identificador',
            'estatus' => 'Estatus',
        ];
    }

    /**
     * Gets query for [[Accions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccions()
    {
        return $this->hasMany(Accion::class, ['id_seccion' => 'id']);
    }

    /**
     * Gets query for [[Privilegios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrivilegios()
    {
        return $this->hasMany(Privilegio::class, ['id_seccion' => 'id']);
    }

    /**
     * Gets query for [[SeccionSuperior]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccionSuperior()
    {
        return $this->hasOne(Seccion::class, ['id' => 'id_seccion_superior']);
    }

    /**
     * Gets query for [[Seccions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccions()
    {
        return $this->hasMany(Seccion::class, ['id_seccion_superior' => 'id']);
    }

    public function getNombreEstatus(){
        return  $this->nombre.' '.
                ($this->estatus?'(Habilitada)':'(Deshabilitada)');
    }
}
