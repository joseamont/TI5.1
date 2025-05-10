<?php

namespace app\controllers;

use Yii;

use app\models\UsuarioTic;
use app\models\Permiso;
use app\models\UsuarioTicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * UsuarioTicController implements the CRUD actions for UsuarioTic model.
 */
class UsuarioTicController extends Controller
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
     * Lists all UsuarioTic models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Permiso::accion('usuario_tic', 'index')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }
    
        // Obtener el ID del usuario y su rol
        $userId = Yii::$app->user->identity->id;
        $userRol = Yii::$app->user->identity->id_rol;
    
        // Si el usuario es de rol 4, solo ve sus propios tickets; de lo contrario, ve todos
        $query = ($userRol == 3) ? UsuarioTic::find()->where(['id_usuario' => $userId]) : UsuarioTic::find();
    
        // Verificar si existen filtros de búsqueda (por ejemplo, por estado de los tickets)
        $searchParams = Yii::$app->request->queryParams;
    
        // Agregar filtros a la consulta si existen
        if (!empty($searchParams)) {
            // Filtrar por id_ticket si es necesario
            if (isset($searchParams['id_ticket'])) {
                $query->andFilterWhere(['id_ticket' => $searchParams['id_ticket']]);
            }
    
            // Filtrar por fecha de inserción si es necesario
            if (isset($searchParams['fecha_insercion'])) {
                $query->andFilterWhere(['fecha_insercion' => $searchParams['fecha_insercion']]);
            }
    
            // Puedes agregar más filtros como estado o cualquier otro campo que necesites
            // if (isset($searchParams['status'])) {
            //     $query->andFilterWhere(['status' => $searchParams['status']]);
            // }
        }
    
        // Crear el proveedor de datos con paginación
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,  // Ordenar por ID descendente
                ]
            ],
        ]);
    
        // Renderizar la vista con el proveedor de datos
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single UsuarioTic model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Permiso::accion('usuario_tic', 'view')) {
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
     * Creates a new UsuarioTic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('usario_tic', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = new UsuarioTic();

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
     * Updates an existing UsuarioTic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Permiso::accion('usuario_tic', 'update')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = $this->findModel($id);

        var_dump($this->request->post());


        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateEstatus($id)
    {
        if (!Permiso::accion('usuario_tic', 'update-estatus')) {
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
     * Deletes an existing UsuarioTic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Permiso::accion('usuario_tic', 'delete')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UsuarioTic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UsuarioTic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioTic::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionUpdateUsuario()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id'); 
            $id_usuario = $request->post('id_usuario');
    
            $model = UsuarioTic::findOne($id);
            if ($model) {
                $model->id_usuario = $id_usuario;
                if ($model->save()) {
                    return ['success' => true, 'message' => 'Usuario actualizado correctamente.'];
                } else {
                    return ['success' => false, 'message' => 'Error al actualizar usuario.', 'errors' => $model->errors];
                }
            } else {
                return ['success' => false, 'message' => 'Registro no encontrado.'];
            }
        }
        return ['success' => false, 'message' => 'Petición no válida.'];
    }
    

    
}
