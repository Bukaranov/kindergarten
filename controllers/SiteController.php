<?php

namespace app\controllers;

use app\models\Kindergartens;
use app\models\Requests;
use app\models\RequestsSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        $command = Yii::$app->db->createCommand('SELECT * FROM users');
//        $posts = $command->queryAll();
//        echo '<pre>';
//        var_dump($posts);die;
        return $this->render('index');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreateRequest()
    {
        $model = new Requests();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->id;
                $model->status = Requests::NEW_REQ;
                if ($model->validate()) {
                    $model->save();
                    return $this->goHome();
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create-request', [
            'model' => $model,
        ]);


    }

    /**
     *
     * @return string
     */
    public function actionMyRequests()
    {
        $user = Yii::$app->user->identity;

        $query = Requests::find()
            ->where([
                'user_id' => $user->id,
            ])
            ->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('my-requests', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDeleteRequest($id)
    {
        $this->findModel($id)->delete();

        return $this->goBack();
    }

    protected function findModel($id)
    {
        if (($model = Requests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSay($message = 'Привет') {
        return $this->render('say', ['massage' => $message]);
    }

    public function actionCreate()
    {
        $model = new Kindergartens();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Данные успешно сохранены!");
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        echo '<pre>';
        $model->load(Yii::$app->request->post());
        var_dump($model);
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
          return $this->render('entry', ['model' => $model]);
        }
    }
}
