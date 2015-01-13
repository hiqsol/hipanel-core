<?
use frontend\components\Re;
use frontend\modules\thread\widgets\Label;
use frontend\modules\thread\widgets\Topic;
use frontend\widgets\GridView;
use frontend\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\web\JsExpression;

// frontend\assets\Select2Asset::register($this);

$this->title = Yii::t('app', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_search', compact('searchModel', 'priority_data')); ?>

<?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Ticket',
]), ['create'], ['class' => 'btn btn-success']) ?>&nbsp;
<?= Html::a(Yii::t('app', 'Advanced search'), '#', ['class' => 'btn btn-success search-button']) ?>



<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'yii\grid\CheckboxColumn',
            // you may configure additional properties here
        ],
        [
            'attribute' => 'subject',
            'format' => 'raw',
            'value' => function ($data) {
                return $data['subject'] . Topic::widget(['topics' => $data->topic]);
            }
        ],
        [
            'attribute' => 'create_time',
            'format' => ['date', 'php:d.m.Y H:i'],
//            'filter' => DatePicker::widget(
//                                  [
//                                      'name'=>'create_time',
//                                      'dateFormat' => 'dd/MM/yyyy',
//                                      'options' => [
//                                          'class' => 'form-control',
//                                      ],
//                                  ])
        ],
        [
            'attribute' => 'author_id',
            'value' => function ($data) {
                return Html::a($data->author, ['/client/client/view', 'id' => $data->author_id]);
            },
            'format' => 'html',
            'filterInputOptions' => ['id' => 'author_id'],
            'label' => Yii::t('app', 'Author'),
            'filter' => Select2::widget([
                'attribute' => 'author_id',
                'model' => $searchModel,
                'url' => Url::to(['client-list'])
            ]),
        ],
        [
            'attribute' => 'recipient_id',
            'format' => 'html',
            'filterInputOptions' => ['id' => 'recipient_id'],
            'label' => Yii::t('app', 'Recipient'),
            'value' => function ($data) {
                return Html::a($data->recipient, ['/client/client/view', 'id' => $data->recipient_id]);

            },
            'filter' => Select2::widget([
                'attribute' => 'recipient_id',
                'model' => $searchModel,
                'url' => Url::to(['manager-list'])
            ]),
        ],
        [
            'attribute' => 'priority',
            'format' => 'raw',
            'value' => function ($data) {
                return Label::widget([
                    'type' => 'priority',
                    'label' => Re::l($data->priority_label),
                    'value' => $data->priority,
                ]);
            },
            'filter' => Html::activeDropDownList($searchModel, 'priority', \frontend\models\Ref::getList('priority'), [
                    'class' => 'form-control',
                    'prompt' => Yii::t('app', '--'),
                ]),
        ],
        [
            'attribute' => 'state',
            'format' => 'html',
            'value' => function ($data) {
                return Label::widget([
                    'type' => 'state',
                    'label' => Re::l($data->state_label),
                    'value' => $data->state,
                ]);
            },
            'filter' => Html::activeDropDownList($searchModel, 'state', $state_data, [
                'class' => 'form-control',
                'prompt' => Yii::t('app', '--')
            ]),
        ],
        [
            'attribute' => 'responsible_id',
            'format' => 'html',
            'label' => Yii::t('app', 'Responsible'),
            'filterInputOptions' => ['id' => 'responsible_id'],
            'value' => function ($data) {
                return Html::a($data['responsible'], ['/client/client/view', 'id' => $data->responsible_id]);
            },
            'filter' => Select2::widget([
                'attribute' => 'responsible_id',
                'model' => $searchModel,
                'url' => Url::to(['client-list'])
            ]),
        ],
        'answer_count',
        [
            'attribute' => 'spent',
            'value' => function ($data) {
                return $data['spent'] > 0 ? sprintf("%02d:%02d", floor($data['spent'] / 60), ($data['spent'] % 60)) : '00:00';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {state}',
            'buttons' => [
                'state' => function ($url, $model, $key) {
                    if ($model->state == 'opened') {
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', [
                            'close',
                            'id' => $model->id
                        ], ['title' => 'Close']);
                    }
                },
            ],
        ],
    ],
]); ?>


<?php
$this->registerJs("
// Check if at least one input field is filled
$('.thread-search').find('input[type=text], select').each(function(){
    if($(this).val() != '') {
        $('.thread-search').toggle();
        $('tr.filters').toggle();
    }
});
// Button handle
$('.search-button').click(function(){
    $('.thread-search').toggle();
    $('tr.filters').toggle();
    return false;
});
// Reset handle
$('.thread-search :reset').click(function(){
    $('.thread-search :input').reset();
    return false;
});
", \yii\web\View::POS_LOAD, 'advanced-search-button');
?>