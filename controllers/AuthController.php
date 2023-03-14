<?php

namespace app\controllers;
use app\models\LoginForm;
//use app\models\User;
use app\models\SignupForm;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                //Ограничения доступа
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'login', 'signup', 'create'],
                        'allow' => true,
                        'roles' => ['?'] // Тільки не автентифіковані користувачі можуть отримати доступ до цих дій
                    ],
                    [
                        'actions' => ['login', 'logout'],
                        'allow' => true,
                        'roles' => ['@'], // Лише автентифіковані користувачі можуть отримати доступ до цих дій
                    ],
                    [
                        'actions' => ['login', 'logout'],
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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->isAdmin){
                return $this->redirect('/kindergartens/index');
            }else{
                return $this->goBack();
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if (Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if ($model->signup())
            {

                return $this->redirect(['auth/login']);
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
