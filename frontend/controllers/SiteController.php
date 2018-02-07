<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

use common\models\DishesIngredients;
use common\models\Ingredients;
use yii\helpers\Html;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * @return array in json
     */
    public function actionSearch()
    {
        if (!Yii::$app->request->isAjax) {
            die("This is not Ajax !)");
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $selected = \Yii::$app->request->post('selected');

        /*
         * SELECT dishes_ingredients.dish_id,count(ingredients.id) as count_math FROM ingredients
            left JOIN dishes_ingredients on ingredients.id = dishes_ingredients.ingredient_id
            Where ingredient_id in (1,2,3)
            GROUP BY dishes_ingredients.dish_id
            HAVING count(ingredient_id)>=2
            order by count_math DESC
         * */

        $matches = DishesIngredients::find()
            ->select(['dishes.title', 'dishes_ingredients.dish_id', 'COUNT(ingredients.id) as MatchCount'])
            ->leftJoin('ingredients', 'ingredients.id = dishes_ingredients.ingredient_id')
            ->leftJoin('dishes', 'dishes.id = dishes_ingredients.dish_id')
            ->andWhere(['in', 'ingredient_id', $selected])
            ->andWhere('dishes.active = 1')
            ->groupBy('dishes_ingredients.dish_id')
            ->having('COUNT(ingredient_id)>=2')
            ->orderBy('MatchCount DESC')
            ->asArray()
            ->all();

        if (empty($matches)) {
            return [
                'status' => 'ok',
                'result' => '<p class="text-warning">Ничего не найдено</p>'
            ];
        }

        $someMatches = [];
        $exactMatch = [];

        foreach ($matches as $matchElement) {
            $ingredientsArray = [];
            $dishQuery = Ingredients::find()->joinWith('dishesIngredients')->where(['dish_id' => $matchElement['dish_id']]);
            $dish = $dishQuery->all();
            $count = $dishQuery->count();

            foreach ($dish as $item) {
                if (!$item->active) {
                    continue 2;
                }

                $ingredientsArray[] = in_array($item->id, $selected) ?
                    Html::tag('span', $item->title, ['class' => 'text-success'])
                    :
                    $item->title;
            }

            $ingredients = implode(', ', $ingredientsArray);
            $title = $matchElement['title'] . ' [Всего совпадений: ' . $matchElement['MatchCount'] . ']';

            $someMatches[$title] = $ingredients;
            if ($matchElement['MatchCount'] == $count && $count == sizeof($selected)) {
                $exactMatch[$title] = $ingredients;
            }
        }

        return [
            'result' => $this->renderAjax('_item_dish', [
                'dishes' => (!empty($exactMatch)) ? $exactMatch : $someMatches,
            ]),
            'status' => 'ok'
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $ingredients = Ingredients::find()->select(['title', 'id'])->indexBy('id')->active()->column();
        return $this->render('index', [
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
