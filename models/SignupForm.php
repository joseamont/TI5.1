<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Persona;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $confirm_password;
    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;

    public $estatus = 1; // Asignar 1 por defecto a estatus

    public function rules()
    {
        return [
            [['username', 'password', 'confirm_password', 'nombre', 'apellido_paterno'], 'required', 'message' => 'Este campo es obligatorio.'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este usuario ya existe.'],
            [['username', 'password'], 'string', 'max' => 45],
            [['estatus'], 'string'],
            [['nombre', 'apellido_paterno', 'apellido_materno'], 'string', 'max' => 100],
            [['apellido_materno'], 'default', 'value' => null], // Opcional
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden.'],
            [['password'], 'string', 'min' => 8],
            [['password'], 'match', 'pattern' => '/[A-Z]/', 'message' => 'La contraseña debe tener al menos una letra mayúscula.'],
            [['password'], 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
            [['password'], 'match', 'pattern' => '/[\W_]/', 'message' => 'La contraseña debe tener al menos un carácter especial.'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            Yii::$app->session->setFlash('error', 'Corrige los errores en el formulario.');
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // 1️⃣ Crear Persona
            $persona = new Persona();
            $persona->attributes = [
                'nombre' => $this->nombre,
                'apellido_paterno' => $this->apellido_paterno,
                'apellido_materno' => $this->apellido_materno
            ];
            
            if (!$persona->save()) {
                throw new \Exception('Error en Persona: ' . implode(' ', $persona->firstErrors));
            }
            
            // 2️⃣ Crear Usuario
            $user = new User();
            $user->attributes = [
                'username' => $this->username,
                'password' => Yii::$app->security->generatePasswordHash($this->password),
                'id_persona' => $persona->id,
                'id_rol' => $this->getDefaultRol(), // Método para roles dinámicos
                'estatus' => $this->estatus // El valor predeterminado de estatus será 1 (habilitado)
            ];
            
            if (!$user->save()) {
                throw new \Exception('Error en Usuario: ' . implode(' ', $user->firstErrors));
            }

            // Autenticar usuario si es necesario
            Yii::$app->user->login($user);

            $transaction->commit();
            Yii::$app->session->setFlash('success', '¡Registro exitoso!');
            return true;
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error al registrar: ' . $e->getMessage());
            Yii::error("Error en signup: " . $e->getMessage());
            return false;
        }
    }

    protected function getDefaultRol()
    {
        return 4; // Rol por defecto (ej: cliente)
    }
}
