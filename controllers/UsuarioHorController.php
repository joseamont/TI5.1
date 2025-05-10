<?php

namespace app\controllers;

use Yii;

use app\models\UsuarioHor;
use app\models\Horario;
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
        $model = new UsuarioHor();
    
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            // Validación 1: Verificar duplicados exactos
            $duplicado = UsuarioHor::find()
                ->where([
                    'id_usuario' => $model->id_usuario,
                    'id_horario' => $model->id_horario
                ])
                ->exists();
    
            if ($duplicado) {
                Yii::$app->session->setFlash('error', 'Este usuario ya tiene asignado este horario exacto.');
                return $this->redirect(['horario/index']);
            }
    
            // Validación 2: Obtener datos del horario a asignar
            $horarioNuevo = Horario::findOne($model->id_horario);
            
            if (!$horarioNuevo) {
                Yii::$app->session->setFlash('error', 'El horario seleccionado no existe.');
                return $this->redirect(['horario/index']);
            }
    
            // Validación 3: Buscar horarios existentes del usuario
            $horariosUsuario = UsuarioHor::find()
                ->joinWith('horario')
                ->where(['usuario_hor.id_usuario' => $model->id_usuario])
                ->all();
    
            foreach ($horariosUsuario as $asignacion) {
                // Verificar solapamiento de horarios
                if ($this->horariosSeSolapan($asignacion->horario, $horarioNuevo)) {
                    Yii::$app->session->setFlash('error', 
                        'El usuario ya tiene un horario asignado que se solapa con este: ' .
                        $asignacion->horario->nombre . ' (' . 
                        $asignacion->horario->hora_inicio . ' a ' . 
                        $asignacion->horario->hora_fin . ')');
                    return $this->redirect(['horario/index']);
                }
            }
    
            // Si pasa todas las validaciones, guardar
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Horario asignado con éxito.');
            } else {
                Yii::$app->session->setFlash('error', 
                    'Error al guardar: ' . implode(' ', $model->getFirstErrors()));
            }
    
            return $this->redirect(['horario/index']);
        }
    
        return $this->redirect(['horario/index']);
    }
    
    /**
     * Verifica si dos horarios se solapan
     */
    private function horariosSeSolapan($horario1, $horario2)
    {
        return ($horario1->hora_inicio < $horario2->hora_fin) && 
               ($horario1->hora_fin > $horario2->hora_inicio);
    }
}


