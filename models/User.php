<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $id_persona
 * @property int $id_rol
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property string $estatus
 *
 * @property Persona $persona
 * @property Rol $rol
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     *  Getters y Setters 
     *  Necesarios para las búsquedas en _search y UserSearch 
     *  Guardar y actualizar datos relacionados en las tablas user y persona en _form
     *  Mostrar datos en view y index
     * */

    public function getNombre()
    {
        if ($this->persona)
            return $this->persona->nombre;
        else
            return '';
    }

    public function getApellidoPaterno()
    {
        if ($this->persona)
            return $this->persona->apellido_paterno;
        else
            return '';
    }

    public function getApellidoMaterno()
    {
        if ($this->persona)
            return $this->persona->apellido_materno;
        else
            return '';
    }

    public function getNombreRol()
    {
        if ($this->rol)
            return $this->rol->nombre;
        else
            return '';
    }

    public function setNombre(String $nombre)
    {
        if ($this->persona)
            $this->persona->nombre = $nombre;
    }

    public function setApellidoPaterno(String $ap)
    {
        if ($this->persona)
            $this->persona->setApellidoPaterno = $ap;
    }

    public function setApellidoMaterno(String $am)
    {
        if ($this->persona)
            $this->persona->setApellidoMaterno = $am;
    }

    public function getNombreUsuario()
    {
        return $this->persona->nombre . ' ' . $this->persona->apellido_paterno . ' ' . $this->persona->apellido_materno;
    }

    public function getNombreUsuarioEstatus()
    {
        return  $this->persona->nombre . ' ' .
            $this->persona->apellido_paterno . ' ' .
            $this->persona->apellido_materno . ' ' .
            ($this->estatus ? '(Habilitado)' : '(Deshabilitado)');
    }

    public function getNombreUsuarioRol(){
        return $this->persona->nombre.
        substr($this->persona->apellido_paterno, 0, 1).
        substr($this->persona->apellido_materno, 0, 1).
        '-'.$this->rol->nombre;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_persona', 'id_rol', 'username', 'password'], 'required'],
            [['id_persona', 'id_rol'], 'integer'],
            [['estatus'], 'string'],
            [['username', 'password'], 'string', 'max' => 45],
            [['authKey', 'accessToken'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['id_persona'], 'unique'],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::class, 'targetAttribute' => ['id_persona' => 'id']],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::class, 'targetAttribute' => ['id_rol' => 'id']],
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
            'id_rol' => 'Id Rol',
            'username' => 'Correo',
            'password' => 'Contraseña',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'estatus' => 'Estatus',
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
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*  foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }*/

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        /*
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        } */

        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
