<?php

namespace app\controllers;

use app\models\Kindergartens;
use app\models\KindergartensSerch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KindergartensController implements the CRUD actions for Kindergartens model.
 */
class KindergartensController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Kindergartens models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Kindergartens::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2()
    {
        $models = Kindergartens::find()
            ->all();

        return $this->render('new-index', [
            'models' => $models
        ]);
    }

    /**
     * Displays a single Kindergartens model.
     * @param int $kindergarten_id Kindergarten ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($kindergarten_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($kindergarten_id),
        ]);
    }

    /**
     * Creates a new Kindergartens model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Kindergartens();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'kindergarten_id' => $model->kindergarten_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kindergartens model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $kindergarten_id Kindergarten ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($kindergarten_id)
    {
        $model = $this->findModel($kindergarten_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'kindergarten_id' => $model->kindergarten_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kindergartens model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $kindergarten_id Kindergarten ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($kindergarten_id)
    {
        $this->findModel($kindergarten_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kindergartens model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $kindergarten_id Kindergarten ID
     * @return Kindergartens the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kindergarten_id)
    {
        if (($model = Kindergartens::findOne(['kindergarten_id' => $kindergarten_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //заявки
    public function actionSetRequests($id)
    {
        $kindergarten = $this->findModel($id);

        return $this->render('requests', [
           'kindergarten' => $kindergarten
        ]);
    }
}
