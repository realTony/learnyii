<?php
$this->title = 'Главная страница';
?>
<div class="admin-default-index">
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
