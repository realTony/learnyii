<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 14.03.2019
 * Time: 2:02
 */

namespace app\widgets;


use yii\base\Widget;
use \app\modules\admin\models\Categories;
use yii\helpers\Url;

class AdvertisementCat extends  Widget
{

    public function run() : void
    {
        $categories = new Categories();
        $catList = $categories->advList;
        $adv = $categories->advertisement;

        $i = 0;
        ?>

        <div class="inform-nav">
            <div class="container">
                <div class="group">
                    <?php foreach ( $catList as $cat ):
                        $currAdv = array_search($cat['title'], $adv);
                        $categories = new Categories();
                        $categories->category = $currAdv;
                        $currCat = $categories->category;
                    ?>
                        <div class="holder-block">
                            <a  href="<?= Url::to([$currCat['link']])?>" class="subsection-title">
                                <div class="holder-img">
                                    <?php if($i == 0): ?>
                                        <i class="fas fa-car"></i>
                                    <?php elseif ($i > 1) : ?>
                                        <i class="fas fa-pencil-ruler"></i>
                                    <?php else: ?>
                                        <i class="fas fa-bullhorn"></i>
                                    <?php endif; ?>
                                </div>
                                <span><?= $categories->category->meta['title'] ?></span>
                            </a>
                            <ul>
                                <?php foreach ($cat['subList'] as $li => $val ):?>
                                    <?php
                                    $cat = new Categories();
                                    $cat->category = $li;
                                    ?>
                                    <li><a href="<?= Url::to(['/'.$cat->category['link']]) ?>"><?= $cat->category->meta['title'] ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php
                        $i++;
                        endforeach;
                    ?>
                </div>

            </div>
        </div>
    <?php
    }
}