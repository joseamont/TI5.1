<?php

namespace app\controllers;
use Yii;
use app\models\Permiso;

use app\models\Calificacion;
use app\models\CalificacionSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * CalificacionController implements the CRUD actions for Calificacion model.
 */
class CalificacionController extends Controller
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
     * Lists all Calificacion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Verificar permiso
        if (!Permiso::accion('ticket', 'index')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }
    
        // Obtener el ID del usuario y su rol
        $userId = Yii::$app->user->identity->id;
        $userRol = Yii::$app->user->identity->id_rol;
    
      // Si el usuario es de rol 4, solo ve sus propios tickets; de lo contrario, ve todos
      $query = ($userRol == 3) ? Calificacion::find()->where(['id_usuario' => $userId]) : Calificacion::find();
    
      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
              'pageSize' => 15
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
     * Displays a single Calificacion model.
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
     * Creates a new Calificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Calificacion();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['ticket/index', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Gracias por registrar su calificación, trabajaremos en mejorar el servicio.');
            return $this->redirect(['ticket/view', 'id' => $model->id_ticket]); // Ajusta la redirección según lo necesites
        }
        
    }

    /**
     * Updates an existing Calificacion model.
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
     * Deletes an existing Calificacion model.
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
     * Finds the Calificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Calificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calificacion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
