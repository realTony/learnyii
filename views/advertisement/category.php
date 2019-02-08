<?php

use yii\helpers\Url;

?>

<div class="form-search">
    <div class="container">
        <a class="search-query" href="#">Поисковый запрос</a>
        <div class="holder-form-search">
            <span class="bg-search"></span>
            <form>
                <fieldset>
                    <a class="closed-search-form" href="#"></a>
                    <div class="search-input">
                        <input type="text" placeholder="Поисковый запрос">
                    </div>
                    <div class="category-input">
                        <select name="dropdown" class="dropdown">
                            <option>Категория</option>
                            <option>Категория1</option>
                            <option>Категория2</option>
                            <option>Категория3</option>
                        </select>
                    </div>
                    <div class="city-input ui-widget">
                        <input class="tags-city" type="text" placeholder="Город">
                    </div>
                    <input class="btn-search" type="submit" value="искать">
                </fieldset>
            </form>
        </div>
    </div>
</div>
<div class="holder-crumbs">
    <div class="container">
        <div class="holder-bread-crumbs">
            <ul class="bread-crumbs">
                <li>
                    <a href="#">Главная</a>
                </li>
                <li>Название категории</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="group-content">
        <div class="aside-left">
            <form class="holder-aside-left">
                <fieldset>
                    <div class="aside-accordion">
                        <span class="title">Транспорт</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Легковые автомобили <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Мото <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Прицепы <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Грузовики <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Автобусы <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Велосипеды <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Другое <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Реклама</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Полная обклейка <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Частичная обклейка <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Навесная реклама <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Реклама в салоне <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Исполнители</span>
                        <div class="expanded">
                            <ul>
                                <li><a href="#">Типографии <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Дизайнеры <sup><small>(12)</small></sup></a></li>
                                <li><a href="#">Поклейщики <sup><small>(12)</small></sup></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Цена (грн/мес)</span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/11000/1600/10000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">Область поклейки</span>
                        <div class="expanded">
                            <ul class="list-checkbox">
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Полная обклейка</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n" checked>
                                        <span><i class="fas fa-check"></i> Частичная обклейка</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Навесная реклама</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox">
                                        <input type="checkbox" name="n">
                                        <span><i class="fas fa-check"></i> Реклама в салоне</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="aside-accordion">
                        <span class="title">пробег (км/мес)</span>
                        <div class="expanded">
                            <div class="range-slider">
                                <div class="slider-range">
                                    <input type="text" class="min_max_currentmin_currentmax" value="0/2000/300/1000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="submit" type="submit" value="применить">
                </fieldset>
            </form>
        </div>
        <div class="content">
            <h1>Название категории</h1>
            <div class="holder-filters">
                <span class="filters">фильтры</span>
                <div class="block-filter">

                </div>
            </div>
            <div class="form-content">
                <form>
                    <fieldset>
                        <div class="group">
                            <div class="holder-input">
                                <div class="city-input ui-widget">
                                    <input class="tags-city" type="text" placeholder="Город">
                                </div>
                                <div class="city-input ui-widget">
                                    <input class="district" type="text" placeholder="Район">
                                </div>
                            </div>
                            <div class="category-input">
                                <select name="dropdown" class="dropdown">
                                    <option>По возрастанию цены</option>
                                    <option>По убыванию цены</option>
                                    <option>По популярности</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="holder-view">
                    <a class="view-list" href="#">
                        <i class="fas fa-th-large"></i>
                        <i class="fas fa-list"></i>
                    </a>
                </div>
            </div>
            <ul class="list-announcements">
                <li class="premium">
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-1.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque... Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-2.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-3.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-1.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-2.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-3.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-1.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-2.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="like-star" href="#">&#160;</a>
                    <a href="#">
                        <div class="holder-img">
                            <img src="<?= Url::home(true); ?>/images/img-3.jpg" alt="img">
                        </div>
                        <div class="holder-text">
                            <div class="group">
                                <div class="topic">
                                    <span>Заголовок объявления</span>
                                    <p>Транспорт</p>
                                </div>
                                <strong>500 <sup><small>грн/мес</small></sup></strong>
                            </div>
                            <div class="overflow-text">
                                <span class="region"><em>Харьков</em>, <em>Немышлянский район</em></span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In finibus, urna eu blandit lacinia, mi metus malesuada mauris, nec tempor eros purus quis ipsum. Pellentesque et leo mollis, imperdiet diam eget, ornare justo. Aenean finibus suscipit scelerisque...</p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>


            <div class="holder-pagination">
                <a class="prev-page" href="#">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <ul class="pagination">
                    <li>
                        <a href="#">1</a>
                    </li>
                    <li class="active">
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">4</a>
                    </li>
                    <li>
                        <a href="#">5</a>
                    </li>
                    <li>
                        <a href="#">6</a>
                    </li>
                    <li>
                        <a href="#">7</a>
                    </li>
                    <li>
                        <a href="#">8</a>
                    </li>
                </ul>
                <a class="next-page" href="#">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="accordion">
    <div class="holder-section">
        <div class="container">
            <div class="holder-box-hidden clone">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut nunc in eros posuere euismod in a tortor. Phasellus nunc orci, vehicula in <span class="box-hidden">hendrerit eu, hendrerit quis neque. Duis eget turpis nec enim vulputate tristique vel vel sem. Etiam sagittis facilisis nisl, id ultricies ante commodo vitae. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer nec elit sollicitudin, vehicula massa vel, accumsan dolor. Phasellus placerat quam justo, eu porttitor ante imperdiet a. Duis imperdiet, lacus at placerat bibendum, lacus arcu molestie lorem, sed lobortis dui nulla malesuada purus. Quisque id viverra lorem. Aliquam rutrum mattis varius. Aenean lectus mi, imperdiet aliquam imperdiet ac, pretium sed neque. Duis molestie luctus tellus sit amet eleifend. Curabitur erat nisl, sagittis non magna eget, sagittis malesuada urna. Etiam nibh justo, egestas et ligula at, molestie auctor tortor. Aliquam hendrerit ante sit amet urna congue ultrices. Vivamus pellentesque risus sit amet est pretium tristique.</span></p>
                <a class="btn-show-more" href="#">Читать дальше...</a>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Объявления в городах</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
            <div class="adver-group">
                <div class="item-accordion">
                    <div class="advert">
                        <strong class="btn-accordion">Интересные <br>предложения</strong>
                    </div>
                    <div class="holder-text content-accordion">
                        <p><a href="#">Lorem</a>, <a href="#">ipsum</a>, <a href="#">dolor</a>, <a href="#">sit amet</a>, <a href="#">consectetur</a>, <a href="#">adipiscing</a>, <a href="#">elit</a>, <a href="#">nunc in eros</a>, <a href="#">posuere euismod</a>, <a href="#">in a tortor</a>, <a href="#">Phasellus nunc orci</a>, <a href="#">vehicula in</a>, <a href="#">hendrerit eu</a>, <a href="#">hendrerit quis neque</a>, <a href="#">Duis eget turpis</a>, <a href="#">nec enim vulputate</a>, <a href="#">tristique vel vel sem</a>. <a href="#">Etiam sagittis</a>, <a href="#">facilisis nisl</a>, <a href="#">id ultricies</a>, <a href="#">ante commodo</a>, <a href="#">vitae</a>. <a href="#">Class aptent</a>, <a href="#">taciti sociosqu</a>, <a href="#">ad litora torquent</a>, <a href="#">per conubia nostra</a>, <a href="#">per inceptos</a>, <a href="#">himenaeos</a>. <a href="#">Integer nec elit</a>, <a href="#">sollicitudin</a>, <a href="#">vehicula massa vel</a>, <a href="#">accumsan dolor</a>, <a href="#">Phasellus placerat</a>, <a href="#">quam justo</a>, <a href="#">eu porttitor</a>, <a href="#">ante imperdiet a</a>. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>