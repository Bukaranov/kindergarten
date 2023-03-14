<?php

namespace app\controllers;

use app\models\Kindergartens;
use app\models\Requests;
use app\models\RequestsSearch;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequestsController implements the CRUD actions for Requests model.
 */
class RequestsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'accept', 'refusal', 'create', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin;
                        } // Тільки адміністрація може отримати доступ до цих дій
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Requests models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Requests model.
     * @param int $id ID
     * @param int $kindergarten_id Kindergarten ID
     * @param int $user_id User ID
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
     * Creates a new Requests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Requests();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'kindergarten_id' => $model->kindergarten_id, 'user_id' => $model->user_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Requests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $kindergarten_id Kindergarten ID
     * @param int $user_id User ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRefusal($id)
    {

        $model = $this->findModel($id);
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->status = 3;
                $model->save();
            }
            $this->redirect(['view', 'id' => $model->id]);
        }

    }

    public function actionAccept($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->reason = null;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', "Заяву прийнято");
            $kindergarten = $model->kindergarten;
            if ($kindergarten->isNoPlace()) {
                // всем заявкам в садики делаем статус отказано и причину отказа
                $requests = Requests::find()->where('status = 1')->all();
                foreach ($requests as $requestModel) {
                    $requestModel->status = 3;
                    $requestModel->reason = "Не залишилося місць";
                    $requestModel->update(false);
                }
            }
        } else {
            foreach ($model->errors as $err) {
                Yii::$app->session->setFlash('error', $err);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Requests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $kindergarten_id Kindergarten ID
     * @param int $user_id User ID
     * @return Requests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
