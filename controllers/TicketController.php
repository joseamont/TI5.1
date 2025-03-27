<?php

namespace app\controllers;

use Yii;

use app\models\Ticket;
use app\models\Respuesta;
use app\models\UsuarioTic;
use app\models\UsuarioCal;
use yii\data\ActiveDataProvider;
use app\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Permiso;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
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
     * Lists all Ticket models.
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
    
        // Si el usuario tiene rol 4, solo verá sus propios tickets; de lo contrario, verá todos los tickets
        $query = ($userRol == 4) ? Ticket::find()->where(['id_usuario' => $userId]) : Ticket::find();
    
        // Crear el modelo de búsqueda
        $searchModel = new TicketSearch();
    
        // Pasar el query filtrado por id_usuario al método search() del TicketSearch
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query); // Pasamos el query filtrado
    
        // Configurar la paginación
        $dataProvider->pagination = ['pageSize' => 25];
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    

    /**
     * Displays a single Ticket model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Permiso::accion('ticket', 'view')) {
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
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Permiso::accion('ticket', 'create')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $model = new Ticket();

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
     * Updates an existing Ticket model.
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
        if (!Permiso::accion('ticket', 'update-estatus')) {
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
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Permiso::accion('ticket', 'delete')) {
            return $this->render('/site/error', [
                'name' => 'Permiso denegado',
                'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
            ]);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCerrar($id)
{
    $ticket = Ticket::findOne($id);
    if (!$ticket) {
        throw new NotFoundHttpException('El ticket no existe.');
    }

    // Verificar permiso
    if (!Permiso::accion('ticket', 'update')) {
        Yii::$app->session->setFlash('error', 'No tienes permiso para cerrar este ticket.');
        return $this->redirect(['index']);
    }

    // Marcar como cerrado si aún no está cerrado
    if ($ticket->status !== 'cerrado') {
        $ticket->status = 'cerrado';
        
        // Asignar la fecha y hora de cierre al ticket
        $ticket->fecha_cierre = date('Y-m-d H:i:s'); // Fecha y hora actual
        
        // Guardar los cambios
        if ($ticket->save()) {
            Yii::$app->session->setFlash('success', 'El ticket ha sido cerrado exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Hubo un error al cerrar el ticket.');
        }
    }

    return $this->redirect(['index']); // Redirigir a la lista de tickets
}


public function actionVerRespuesta($id)
{
    // Buscar la respuesta vinculada al ticket
    $respuesta = Respuesta::find()->where(['id_ticket' => $id])->one();

    if (!$respuesta) {
        // Crear un modelo vacío para que se cargue el chat sin respuestas aún
        $respuesta = new Respuesta();
        $respuesta->id_ticket = $id;
    }

    // Renderizar la vista de respuesta con el modelo (aunque esté vacío)
    return $this->render('/respuesta/view', [
        'model' => $respuesta,
    ]);
}

public function actionTomar($id)
{
    $ticket = Ticket::findOne($id); // Busca el ticket por ID

    if (!$ticket) {
        throw new NotFoundHttpException('El ticket no existe.');
    }

    // Verificar si el ticket ya fue tomado
    $usuarioTicketExistente = UsuarioTic::find()->where(['id_ticket' => $id])->one();

    if ($usuarioTicketExistente) {
        Yii::$app->session->setFlash('error', 'Este ticket ya ha sido tomado por otro usuario.');
        return $this->redirect(['index']);
    }

    // Crear un nuevo registro en la tabla usuario_tic
    $usuarioTicket = new UsuarioTic();
    $usuarioTicket->id_usuario = Yii::$app->user->identity->id; // ID del usuario autenticado
    $usuarioTicket->id_ticket = $ticket->id;
    $usuarioTicket->fecha_insercion = date('Y-m-d H:i:s'); // Fecha y hora actual

    if ($usuarioTicket->save()) {
        // Actualizar el estado del ticket a "Abierto"
        $ticket->status = 'Abierto'; 
        $ticket->save(false); // Guardar sin validaciones

        Yii::$app->session->setFlash('success', 'Has tomado el ticket correctamente.');
    } else {
        Yii::$app->session->setFlash('error', 'Hubo un error al tomar el ticket.');
    }

    return $this->redirect(['index']); // Redirige a la lista de tickets
}

    
}
