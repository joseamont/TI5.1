<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accion".
 *
 * @property int $id
 * @property int $id_seccion
 * @property string $nombre
 * @property string $identificador
 * @property string $estatus
 *
 * @property Privilegio[] $privilegios
 * @property Seccion $seccion
 */
class Accion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_seccion', 'nombre', 'identificador'], 'required'],
            [['id_seccion'], 'integer'],
            [['estatus'], 'string'],
            [['nombre'], 'string', 'max' => 150],
            [['identificador'], 'string', 'max' => 80],
            [['id_seccion'], 'exist', 'skipOnError' => true, 'targetClass' => Seccion::class, 'targetAttribute' => ['id_seccion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_seccion' => 'Id Seccion',
            'nombre' => 'Nombre',
            'identificador' => 'Identificador',
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
        return $this->hasMany(Privilegio::class, ['id_accion' => 'id']);
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

    public function getNombreEstatus(){
        return  $this->nombre.' '.
                ($this->estatus?'(Habilitada)':'(Deshabilitada)');
    }
}
