<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 28.02.2019
 * Time: 2:37
 */

namespace app\widgets;


use app\components\TextExcerption;
use yii\base\Widget;
use app\modules\admin\models\BlogPosts;
use yii\helpers\Url;

class SimilarNews extends Widget
{
    public $options = [];
    public $category;
    public $currentId;

    public function run()
    {
        $model = (new BlogPosts())->find()->where(['category_id' => $this->category])
        ->andWhere(['not', ['id' => $this->currentId] ])->limit(6)->orderBy('updated_at DESC')->all();

        if(! empty($model)):
        ?>

        <div class="aside">
            <span class="aside-title"><?= \Yii::t('app', 'Похожие новости')?></span>
            <div class="aside-content">
                <ul class="similar-news">
                    <?php foreach ( $model as $item) : ?>
                        <li>
                            <a href="<?= Url::toRoute($item->link)?>"><?= $item->title; ?></a>
                            <span><?= TextExcerption::excerptText($item->description, 110); ?></span>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    <?php endif;
    }
}