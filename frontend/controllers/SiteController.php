<?php
namespace frontend\controllers;


use common\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\SignForm;
use common\models\LoginForm;
use common\models\Posts;
use frontend\models\ContactForm;

/**
 * Site controller
 */
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSign(){
        if (!Yii::$app->user->isGuest) {
            return $this->render('sign');
        }
        $model = new SignForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->password =  $model->password;
            $user->email = $model->email;

            if ($user->save())
            {

                Yii::$app->session->addFlash('success', 'Вы успешно зарегистирировались!');
                return $this->render('contact');
            }
        }
        return $this->render('sign', compact('model'));
    }

    public function actionContact()
    {

        $sort = new Sort([
            'attributes' =>
                [
                    'title' =>
                        [
                            'asc' =>['title' => SORT_ASC],
                            'desc' =>['title' => SORT_DESC]
                        ]
                ]
        ]);

        $query = Posts::find();
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->render('contact', [
            'models' => $models,
            'pages' => $pages,
            'sort' => $sort
        ]);


    }

    public function actionCreate(){
        $post = new Posts();

        $post->user_id = $_SESSION['__id'];
        $formData = Yii::$app->request->post();

        if ($post->load($formData))
        {
            if ($post->save())
            {
                Yii::$app->session->addFlash('success', 'Задача успешно добавлена!');
                return $this->redirect(['contact']);
            }
            else
            {
                Yii::$app->getSession()->setFlash('message', "Failed");
            }
        }
        return $this->render('create', ['post' => $post]);
    }

    public function actionDelete($id){
        $post = Posts::findOne($id);
        if ($post!= null){
            $post = Posts::findOne($id)->delete();
            if ($post)
            {
                Yii::$app->session->addFlash('success', 'Задача успешно удалена!');
            }
        }
        else
            echo "!";
        return $this->render('contact', ['post' => $post]);
    }

    public function actionUpdate($id)
    {
        $post = Posts::findOne($id);
        if ($post->load(Yii::$app->request->post()) && $post->save())
        {
            Yii::$app->session->addFlash('success', 'Задача успешно изменена!');
            return $this->redirect(['contact']);
        }
        else{
            return $this->render('update', ['post' => $post]);
        }
    }
}
