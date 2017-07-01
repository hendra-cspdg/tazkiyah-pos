<?php

namespace backend\controllers;

use Yii;
use common\models\User;

use common\models\Customer;
use common\models\Employee;
use common\models\Product;
use common\models\Order;
use common\models\OrderLog;
use common\models\OrderItem;
use common\components\corecontrollers\ZeedController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OperatorController
 */
class OperatorController extends ZeedController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action)
                        {
                            return 
                                Yii::$app->user->identity['role'] == User::ROLE_SUPERADMIN ||
                                Yii::$app->user->identity['role'] == User::ROLE_OPERATOR;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'operator';

        $products = Product::find()->
            where(['visible' => '1'])->
            orderBy('position')->
            limit(12)->
            all();

        $all_products = Product::find()->
            where(['visible' => 1])->
            select('label, id')->
            orderBy('position')->
            indexBy('id')->
            column();
        
        return $this->render('index', [
            'products' => $products,
            'all_products' => $all_products
            ]);
    }
}
