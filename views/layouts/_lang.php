<ul class="list-language">
    <li <?php if(\Yii::$app->language == 'ru-Ru' ): ?> class="active"<?php endif; ?> >
        <a href="#"><?= Yii::t('app', 'РУС') ?></a>
    </li>
    <li <?php if(\Yii::$app->language == 'uk-Uk' ): ?> class="active"<?php endif; ?> >
        <a href="#"><?= Yii::t('app', 'УКР') ?></a>
    </li>
</ul>