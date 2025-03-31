<?php

namespace app\models;

use Yii;
use app\models\PersonaInfo;

/**
 * This is the model class for table "persona".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string|null $apellido_materno
 *
 * @property User $user
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido_paterno'], 'required'],
            [['nombre', 'apellido_paterno', 'apellido_materno'], 'string', 'max' => 60],
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
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id_persona' => 'id']);
    }

    public function getPersonaInfo()
    {
        return $this->hasOne(PersonaInfo::class, ['id_persona' => 'id']);
    }
    

}
