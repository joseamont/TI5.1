<?php

namespace app\controllers;

use Yii;

use app\models\UsuarioHor;
use yii\data\ActiveDataProvider;
use app\models\UsuarioHorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Permiso;

/**
 * UsuarioHorController implements the CRUD actions for UsuarioHor model.
 */
class UsuarioHorController extends Controller
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
     * Lists all UsuarioHor models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Permiso::accion('usuario_hor', 'index')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }
    
        // Obtener el ID del usuario y su rol
        $userId = Yii::$app->user->identity->id;
        $userRol = Yii::$app->user->identity->id_rol;
    
        // Si el usuario es de rol 4, solo ve sus propios tickets; de lo contrario, ve todos
        $query = ($userRol == 3) ? UsuarioHor::find()->where(['id_usuario' => $userId]) : UsuarioHor::find();
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25
            ],
           /* 'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);
    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuarioHor model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Permiso::accion('usuario_hor', 'view')) {
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
     * Creates a new UsuarioHor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('usuario_hor', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = new UsuarioHor();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UsuarioHor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
        public function actionUpdateEstatus($id)
    {
        if (!Permiso::accion('usuario_hor', 'update-estatus')) {
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
     * Deletes an existing UsuarioHor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Permiso::accion('usuario_hor', 'delete')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UsuarioHor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UsuarioHor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioHor::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // En el controlador UsuarioHorController

    public function actionAssign()
    {
        // Crear una nueva instancia del modelo UsuarioHor
        $usuarioHorModel = new UsuarioHor();

        // Verificar si es una solicitud POST
        if (Yii::$app->request->isPost) {
            // Cargar los datos del formulario en el modelo
            if ($usuarioHorModel->load(Yii::$app->request->post())) {
                // Intentar guardar el registro en la tabla usuario_hor
                if ($usuarioHorModel->save()) {
                    // Si se guarda correctamente, mostrar un mensaje de éxito
                    Yii::$app->session->setFlash('success', 'Horario asignado con éxito.');
                } else {
                    // Si hay errores al guardar
                    Yii::$app->session->setFlash('error', 'Hubo un error al asignar el horario.');
                }
                // Redirigir a la vista deseada (por ejemplo, a la lista de horarios)
                return $this->redirect(['horario/index']);
            }
        }

        // Si no es un POST, redirigir
        return $this->redirect(['horario/index']);
    }
}


