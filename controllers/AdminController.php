<?php

namespace app\controllers;

use app\models\Request;
use app\models\Status;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class AdminController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['*'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'success', 'cancel'],
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return \Yii::$app->user->identity->isAdmin();
                            }
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Request::find(),

            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSuccess($id)
    {
        $model = $this->findModel($id);
        if ($model->status->code === 'new') {
            $model->status_id = Status::findOne(['code' => 'approve'])->id;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Заявление одобрено!');
        }
        return $this->redirect('index');
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        if ($model->status->code === 'new') {
            $model->status_id = Status::findOne(['code' => 'rejected'])->id;
            $model->save();
            \Yii::$app->getSession()->setFlash('info', 'Заявление отклонено!');
        }
        return $this->redirect('index');
    }

    protected function findModel($id)
    {
        if (($model = Request::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
