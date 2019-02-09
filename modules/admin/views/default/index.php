<?php
$this->title = 'Главная страница';
?>
<div class="admin-default-index">
<!--    <h1>--><?//= $this->context->action->uniqueId ?><!--</h1>-->
<!--    <p>-->
<!--        This is the view content for action "--><?//= $this->context->action->id ?><!--".-->
<!--        The action belongs to the controller "--><?//= get_class($this->context) ?><!--"-->
<!--        in the "--><?//= $this->context->module->id ?><!--" module.-->
<!--    </p>-->
<!--    <p>-->
<!--        You may customize this page by editing the following file:<br>-->
<!--        <code>--><?//= __FILE__ ?><!--</code>-->
<!--    </p>-->
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-white m-b">
                <div class="card-header">
                    <h2>Dashboard</h2>
                </div>
                <div class="card-block">
                    <h3>Привет, <?= Yii::$app->user->identity->username; ?>!</h3>
                    <p>Пока что здесь ведутся работы</p>
                    <p>и на этом месте будет что-то полезное</p>
                    <img src="https://static.lolkot.ru/u/2013/01/primus_1357544295.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
