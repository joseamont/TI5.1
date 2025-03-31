<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona_info".
 *
 * @property int $id
 * @property int $id_persona
 * @property string $fecha_nacimiento
 * @property string|null $genero
 * @property string|null $telefono
 * @property string $direccion
 * @property string $fecha_registro
 *
 * @property Persona $persona
 */
class PersonaInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_persona', 'fecha_nacimiento', 'direccion'], 'required'],
            [['id_persona'], 'integer'],
            [['fecha_nacimiento', 'fecha_registro'], 'safe'],
            [['genero'], 'string'],
            [['telefono'], 'string', 'max' => 20],
            [['direccion'], 'string', 'max' => 100],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::class, 'targetAttribute' => ['id_persona' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_persona' => 'Id Persona',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'genero' => 'Genero',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'fecha_registro' => 'Fecha Registro',
        ];
    }

    /**
     * Gets query for [[Persona]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Persona::class, ['id' => 'id_persona']);
    }
}
