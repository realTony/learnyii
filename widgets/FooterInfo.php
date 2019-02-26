<?php
namespace app\widgets;


use yii\base\Widget;

class FooterInfo extends Widget
{

    public function run()
    {
        ?>
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
        <?php
    }
}