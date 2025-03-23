<?php

namespace app\controllers;

use app\models\Persona;
use app\models\User;
use app\models\Permiso;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Permiso::accion('user', 'index')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 25];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Permiso::accion('user', 'view')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('user', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $modelPersona = new Persona();
        $modelUser = new User();

        if ($this->request->isPost) {
            // Asignación de datos de la persona
            $informacion = $this->request->post();
            $modelPersona->nombre = $informacion['User']['nombre'];
            $modelPersona->apellido_paterno = $informacion['User']['apellidoPaterno'];
            $modelPersona->apellido_materno = $informacion['User']['apellidoMaterno'];
            // Insert de persona y asignación de su id en user.id_persona
            if ($modelPersona->save()) {
                $informacion['User']['id_persona'] = $modelPersona->id;
                //Insert de user
                if ($modelUser->load($informacion) && $modelUser->save()) {
                    return $this->redirect(['view', 'id' => $modelUser->id]);
                } else {
                    $modelPersona->delete();
                    return $this->render('/site/error', [
                        'name' => 'No se pudo agregar el usuario',
                        'message' => 'Verifique que el correo no se repita o falte información '
                    ]);
                }
            }
        } else {
            $modelUser->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $modelUser, 'accion' => 'create'
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Permiso::accion('user', 'update')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $modelUser = $this->findModel($id);
        // Persona asignada a user desde el modelo por la foreingkey id_persona
        $modelPersona = $modelUser->persona;

        if ($this->request->isPost) {
            // Asignación de datos de la persona
            $informacion = $this->request->post();
            $modelPersona->nombre = $informacion['User']['nombre'];
            $modelPersona->apellido_paterno = $informacion['User']['apellidoPaterno'];
            $modelPersona->apellido_materno = $informacion['User']['apellidoMaterno'];
            // Update de persona
            if ($modelPersona->save()) {
                //Update de user
                if ($modelUser->load($informacion) && $modelUser->save()) {
                    return $this->redirect(['view', 'id' => $modelUser->id]);
                } else {
                    return $this->render('/site/error', [
                        'name' => 'No se pudo actualizar el usuario',
                        'message' => 'Verifique que el correo no se repita o falte información '
                    ]);
                }
            }
        }

        return $this->render('update', [
            'model' => $modelUser,
        ]);
    }

    public function actionUpdateEstatus($id)
    {
        if (!Permiso::accion('user', 'update-estatus')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Permiso::accion('user', 'delete')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = $this->findModel($id);
        $modelPersona = $model->persona;
        $model->delete();
        $modelPersona->delete();
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
