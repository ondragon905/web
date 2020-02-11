<?php
#include 'C:\xampp\htdocs\yii-application\frontend\controllers\SiteController.php';
#$path = 'C:\xampp\htdocs\yii-application\frontend\controllers\SiteController.php';
#C:\xampp\htdocs\yii-application\frontend\controllers\SiteController.php
#echo $path;
use backend\controllers\SiteController;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\html;
use common\models\Posts;
use common\models\User;
use yii\widgets\LinkPager;

?>

<?php $sort = new Sort([
    'attributes' =>
        [
            'Sort' =>
                [
                    'asc' =>['title' => SORT_ASC],
                    'desc' =>['title' => SORT_DESC]
                ]
        ]
]);
?>

<div class = "row">
    <span>
        <?= Html::a('Create',['/site/create'], ['class' => 'btn btn-success'])?>

    </span>
</div>

<table class="table table-hover">
    <thead>
    <tr>
        <!--<th scope="col">ID</th> -->
        <th scope="col">Название</th>
        <th scope="col"> ! </th>
    </tr>
    </thead>

    <tbody>
    <?php
    $query = Posts::find()->orderBy($sort->orders)->where(['user_id' => $_SESSION['__id']]);
    $count = $query->count();
    $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false]);
    $models = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->all(); ?>


    <h3><center> <?php echo $sort->link('Sort', ['class' => 'label label-warning']); ?></center></h3>
    <?php foreach ($models as $p): ?>

    <tr class="table-active">
        <!--<th scope="row"><?php echo $p->id ?></th> -->
        <td><?php echo $p->title; ?></td>
        <td>
            <span> <?= Html::a('Delete', ['delete', 'id' => $p->id], ['class' => 'label label-danger'])?> </span>
            <span> <?= Html::a('Update', ['update', 'id' => $p->id], ['class' => 'label label-info'])?> </span>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<center>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</center>


