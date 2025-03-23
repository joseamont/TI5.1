<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "suscripciones".
 *
 * @property int $id
 * @property string $nombre
 * @property float $precio
 * @property string $resolucion
 * @property int $dispositivos
 * @property string $duracion
 *
 * @property Ticket[] $tickets
 * @property UsuarioPla[] $usuarioPlas
 */
class Suscripciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suscripciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'precio', 'resolucion', 'dispositivos', 'duracion'], 'required'],
            [['precio'], 'number'],
            [['resolucion', 'duracion'], 'string'],
            [['dispositivos'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
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
            'precio' => 'Precio',
            'resolucion' => 'Resolucion',
            'dispositivos' => 'Dispositivos',
            'duracion' => 'Duracion',
        ];
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::class, ['id_suscripcion' => 'id']);
    }

    /**
     * Gets query for [[UsuarioPlas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioPlas()
    {
        return $this->hasMany(UsuarioPla::class, ['id_suscripcion' => 'id']);
    }
}
