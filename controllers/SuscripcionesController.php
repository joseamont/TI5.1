<?php

namespace app\controllers;

use Yii;

use app\models\Suscripciones;
use app\models\UsuarioPla;
use yii\data\ActiveDataProvider;
use app\models\SuscripcionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Permiso;

/**
 * SuscripcionesController implements the CRUD actions for Suscripciones model.
 */
class SuscripcionesController extends Controller
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
     * Lists all Suscripciones models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Permiso::accion('suscripciones', 'index')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Suscripciones::find(),
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
     * Displays a single Suscripciones model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Permiso::accion('suscripciones', 'view')) {
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
     * Creates a new Suscripciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('suscripciones', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = new Suscripciones();

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
     * Updates an existing Suscripciones model.
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
        if (!Permiso::accion('suscripciones', 'update-estatus')) {
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
     * Deletes an existing Suscripciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Permiso::accion('suscripciones', 'delete')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Suscripciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Suscripciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Suscripciones::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionContratar($id)
    {
        $suscripcion = Suscripciones::findOne($id);
        if (!$suscripcion) {
            throw new NotFoundHttpException('La suscripción no existe.');
        }
    
        // Obtener el usuario autenticado
        $usuario = Yii::$app->user->identity;
    
        // Verificar si el usuario ya tiene este plan contratado
        $existeSuscripcion = UsuarioPla::find()
            ->where(['id_usuario' => $usuario->id, 'id_suscripcion' => $suscripcion->id])
            ->exists();
    
        if ($existeSuscripcion) {
            Yii::$app->session->setFlash('warning', 'Ya tienes este plan contratado.');
            return $this->redirect(['index']); // Redirigir a la lista de suscripciones
        }
    
        // Asignar la suscripción al usuario
        $UsuarioPla = new UsuarioPla();
        $UsuarioPla->id_usuario = $usuario->id;
        $UsuarioPla->id_suscripcion = $suscripcion->id;
        $UsuarioPla->fecha_insercion = date('Y-m-d');
        
        if ($UsuarioPla->save()) {
            Yii::$app->session->setFlash('success', '¡Has contratado la suscripción con éxito!');
        } else {
            Yii::$app->session->setFlash('error', 'Hubo un error al contratar la suscripción.');
        }
    
        return $this->redirect(['index']); // Redirigir a la lista de suscripciones
    }
    

}
