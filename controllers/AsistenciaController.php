<?php

namespace app\controllers;

use Yii;

use app\models\Asistencia;
use yii\data\ActiveDataProvider;
use app\models\AsistenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Permiso;

/**
 * AsistenciaController implements the CRUD actions for Asistencia model.
 */
class AsistenciaController extends Controller
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
     * Lists all Asistencia models.
     *
     * @return string
     */
    public function actionIndex()
    {
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
        $query = ($userRol == 3) ? Asistencia::find()->where(['id_usuario' => $userId]) : Asistencia::find();
    
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
     * Displays a single Asistencia model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Permiso::accion('asistencia', 'view')) {
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
     * Creates a new Asistencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('asistencia', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = new Asistencia();

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
     * Updates an existing Asistencia model.
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
        if (!Permiso::accion('asistencia', 'update-estatus')) {
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
     * Deletes an existing Asistencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Permiso::accion('asistencia', 'delete')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /**
     * Finds the Asistencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Asistencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asistencia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConsultaAsistencias()
{
    // Paso 1: Obtener todos los registros de usuario_hor
    $usuarioHorarios = UsuarioHor::find()->all(); 
    
    // Paso 2: Obtener todos los horarios y asistencias
    $horarios = Horario::find()->indexBy('id')->all();  // Indexar horarios por ID
    $asistencias = Asistencia::find()->indexBy('id_usuario')->all();  // Indexar asistencias por ID de usuario

    // Paso 3: Preparar los resultados con la lógica de comparación
    $resultados = [];
    foreach ($usuarioHorarios as $usuarioHorario) {
        $usuarioId = $usuarioHorario->id_usuario;

        // Verificar si existen los registros correspondientes
        if (isset($horarios[$usuarioHorario->id_horario]) && isset($asistencias[$usuarioId])) {
            $horario = $horarios[$usuarioHorario->id_horario];
            $asistencia = $asistencias[$usuarioId];

            // Comparar hora_entrada con hora_inicio
            $horaInicio = $horario->hora_inicio;
            $horaEntrada = $asistencia->hora_entrada;

            // Convertir a timestamps para comparar
            $horaInicioTimestamp = strtotime($horaInicio);
            $horaEntradaTimestamp = strtotime($horaEntrada);

            // Determinar el estatus (Retardo o A tiempo)
            $estatus = ($horaEntradaTimestamp > $horaInicioTimestamp) ? 'Retardo' : 'A tiempo';

            // Agregar los resultados al array
            $resultados[] = [
                'id_usuario' => $usuarioId,
                'hora_inicio' => $horaInicio,
                'hora_entrada' => $horaEntrada,
                'fecha' => $asistencia->fecha,
                'status' => $asistencia->status,
                'estatus' => $estatus,  // El campo calculado
            ];
        }
    }

    // Paso 4: Crear el ArrayDataProvider con los resultados procesados
    return $this->render('consulta-asistencias', [
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $resultados,  // Los resultados calculados
            'pagination' => [
                'pageSize' => 20,
            ],
        ]),
    ]);
}

    

}
