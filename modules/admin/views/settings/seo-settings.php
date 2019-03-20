<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

?>
<!--<div class="row">-->
<!--    <div class="col-md-12">-->
<!--        <!--card editor -->-->
<!--        <div class="card">-->
<!--            <div class="card-block p-a-0">-->
<!--                <div class="box-tab single-project-tab justified m-b-0">-->
<!--                    <ul class="nav nav-tabs">-->
<!--                        <li>-->
<!--                            <a href="#account" data-toggle="tab">--><?//= Yii::t('app', 'Личный кабинет') ?><!--</a>-->
<!--                        </li>-->
<!--                        <li class="active">-->
<!--                            <a href="#news" data-toggle="tab">--><?//= Yii::t('app', 'Новости') ?><!--</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="#advertisement" data-toggle="tab">--><?//= Yii::t('app', 'Объявления') ?><!--</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <div class="tab-content">-->
<!--                        <div class="tab-pane active in" id="top"><!--header tab-->-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for header editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать меню-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!--                                                <!--header-->-->
<!--                                                <div class="page-heading">-->
<!--                                                    <div class="grid heading-grid">-->
<!--                                                        <div class="dot"></div>-->
<!--                                                        <div class="dot"></div>-->
<!--                                                        <span></span>-->
<!--                                                        <span></span>-->
<!--                                                        <span></span>-->
<!--                                                        <span></span>-->
<!--                                                        <span></span>-->
<!--                                                    </div>-->
<!--                                                    <div class="heading-box">-->
<!--                                                        <!--Image background -->-->
<!--                                                        <div class="cover-image">-->
<!--                                                            <img src="media/jove_intro.jpg" alt="">-->
<!--                                                        </div>-->
<!--                                                        <!--end Image background >-->-->
<!--                                                        <div class="video-background" id="video-bg" data-vide-bg="mp4: media/jove-intro, poster: media/jove_intro"></div>-->
<!--                                                        <div class="overlaybg black80"></div>-->
<!--                                                        <div class="top-content" >-->
<!--                                                            <div class="large-logo">-->
<!--                                                                <a href="index.html">-->
<!--                                                                    <span></span>-->
<!--                                                                    <h1>Jove</h1>-->
<!--                                                                </a>-->
<!---->
<!--                                                            </div>-->
<!--                                                            <div class="top-subtitle">-->
<!--                                                                <span>Профессиональная</span>-->
<!--                                                                <p>разработка сайтов</p>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <div class=" scroll-down">-->
<!--                                                        <div class="scroll-down__lines scroll-down__lines_animated"></div>-->
<!--                                                    </div>-->
<!--                                                </div><!--header-->-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for header editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div><!--end header tab-->-->
<!--                        <div class="tab-pane" id="services"><!--service tab-->-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for header editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать услуги-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for header editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div><!--end service tab-->-->
<!--                        <div class="tab-pane" id="portfolio"><!-- portfolio tab-->-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for portfolio editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать портфолио-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for portfolio editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div><!--end portfolio tab-->-->
<!--                        <div class="tab-pane" id="wanted"><!-- wanted tab-->-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for wanted editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать "Хочу сайт"-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for wanted editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div><!--end wanted tab-->-->
<!--                        <div class="tab-pane" id="reviews"><!--reviews tab-->-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for reviews editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать отзывы-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for reviews editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div><!--end reviews tab-->-->
<!--                        <div class="tab-pane" id="seo-in-home">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for seo-in-home editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать "Создание сайтов"-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for seo-in-home editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="tab-pane" id="footer">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-12">-->
<!--                                    <!--card for footer editor-->-->
<!--                                    <div class="card bg-white m-b">-->
<!--                                        <div class="card-header">-->
<!--                                            Редактировать футер-->
<!--                                        </div>-->
<!--                                        <div class="card-block">-->
<!--                                            <div class="summernote">-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <!--end card for footer editor-->-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php
//ActiveForm::end();