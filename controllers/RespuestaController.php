<?php

namespace app\controllers;

use Yii;

use app\models\Respuesta;
use yii\data\ActiveDataProvider;
use app\models\RespuestaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Permiso;

/**
 * RespuestaController implements the CRUD actions for Respuesta model.
 */
class RespuestaController extends Controller
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
     * Lists all Respuesta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Permiso::accion('respuesta', 'index')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Respuesta::find(),
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
     * Displays a single Respuesta model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Respuesta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('respuesta', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = new Respuesta();

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
     * Updates an existing Respuesta model.
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

    /**
     * Deletes an existing Respuesta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Respuesta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Respuesta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Respuesta::findOne(['id' => $id]);
    
        if ($model === null) {
            $model = new Respuesta();
            $model->id_ticket = Yii::$app->request->get('id_ticket'); // Tomar el ID del ticket si está en la URL
        }
    
        return $model;
    }
    
}
