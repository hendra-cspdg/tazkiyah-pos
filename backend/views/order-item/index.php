<?php

use yii\helpers\Html;
use common\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrderItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Order Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order Item'), ['create'], ['class' => 'btn btn-success']) ?>

        <span class="pull-right btn btn-danger" id="delete_selected_items_btn" data-url="/order-item/multipledelete">Delete Selected</span>
    </p>
    <div class="table table-responsive">
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'   => 'common\components\widgets\ZeedCheckboxColumn',
            ],

            [
                'attribute' => 'id',
                'options' => ['width' => '70px'],
            ],
            'order_id',
            'product_id',
            'product_label',
            'product_attribute_id',
            // 'quantity',
            // 'unit_price',
            // 'note',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div>
</div>

<?= $this->registerJsFile('@web/js/multipledelete.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>