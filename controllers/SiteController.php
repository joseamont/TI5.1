<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;  
use app\models\Persona;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    public function actionCreate()
    {
        $modelPersona = new Persona();
        $modelUser = new User();
    
        if ($this->request->isPost) {
            // Asignación de datos de la persona
            $informacion = $this->request->post();
            $modelPersona->nombre = $informacion['User']['nombre'];
            $modelPersona->apellido_paterno = $informacion['User']['apellidoPaterno'];
            $modelPersona->apellido_materno = $informacion['User']['apellidoMaterno'];
    
            $transaction = Yii::$app->db->beginTransaction();
            
            try {
                // Insertar persona y asignar su id en user.id_persona
                if (!$modelPersona->save()) {
                    throw new \Exception('Error al guardar la persona: ' . implode(' ', $modelPersona->firstErrors));
                }
    
                // Asignar el ID de persona al usuario
                $informacion['User']['id_persona'] = $modelPersona->id;
                $modelUser->estatus = '1';  // Establecer el estatus como habilitado por defecto
    
                // Insertar usuario
                if (!$modelUser->load($informacion) || !$modelUser->save()) {
                    throw new \Exception('Error al guardar el usuario: ' . implode(' ', $modelUser->firstErrors));
                }
    
                // Confirmar la transacción si todo ha ido bien
                $transaction->commit();
    
                return $this->redirect(['view', 'id' => $modelUser->id]);
    
            } catch (\Exception $e) {
                // En caso de error, deshacer los cambios realizados
                $transaction->rollBack();
    
                // Eliminar la persona si el usuario no se guardó correctamente
                if (!$modelUser->hasErrors()) {
                    $modelPersona->delete();
                }
    
                return $this->render('/site/error', [
                    'name' => 'No se pudo agregar el usuario',
                    'message' => 'Verifique que el correo no se repita o falte información. Detalle del error: ' . $e->getMessage()
                ]);
            }
        } else {
            // Si es una solicitud GET, cargar los valores por defecto
            $modelUser->loadDefaultValues();
        }
    
        // Renderizar la vista para crear el usuario
        return $this->render('create', [
            'model' => $modelUser, 
            'accion' => 'create'
        ]);
    }
    
    
    
}
