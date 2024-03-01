<?php

namespace frontend\controllers;

use common\constants\Statuses;
use frontend\models\Apples;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApplesController implements the CRUD actions for Apples model.
 */
class ApplesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ],
                    ]
                ]
            ],
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Apples models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $models = Apples::find()->all();

        return $this->render('index', [
            'models' => $models
        ]);
    }

    /**
     * Displays a single Apples model.
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
     * Creates a new Apples model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if ($this->request->isPost) {
            $model = new Apples();

            if ($model->createApples()) {
                return $this->redirect(['index']);
            }
        }
    }

    public function actionFall($id)
    {
        if ($this->request->isPost) {
            $model = $this->findModel($id);

            try {
                $model->fall();
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                Yii::debug($e->getMessage());
            }

            return $this->redirect(['index']);
        }
    }

    public function actionEat($id)
    {
        if ($this->request->isPost) {
            $model = $this->findModel($id);
            $percent = Yii::$app->request->post('percent_eaten');

            try {
                $model->eat($percent);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                Yii::debug($e->getMessage());
            }

            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Apples model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Apples the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apples::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
