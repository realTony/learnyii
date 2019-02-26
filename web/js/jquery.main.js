$(document).ready(function(){

    resolutions();
    resolutions1();
    resolutions2();
    resolutions3();
    init_and_resize();
    init_and_resize1();
    init_and_resize2();
    init_and_resize3();
    $(window).resize(function() {
        init_and_resize();
        init_and_resize1();
        init_and_resize2();
        init_and_resize3();
    });
    acardionMobileAside();
    initTabs();
    blockText();
    accordion();
    asideAccordion();
    initDropCity();
    initDropDistrict();

    $('#widget').draggable();

    $(window).on('load resize',function(){
        slickWidth();
    });

    $(".dropdown").dropdown();
    $('#footer .holder-block').matchHeight();
    $('#footer .holder-block').matchHeight();
    $('.list-announcements li').matchHeight();

    $('.promo-slider').slick({
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true
    });

    if( $('#account-panel').is('ul') ){
        var hash = window.location.hash;
        if( typeof hash != 'undefined' && hash != ''){
            $('#account-panel li').each( function () {
                $(this).attr('class', '');
                if( $(this).children().attr('href') == hash ) {
                    $(this).attr('class', 'active');
                    $(this).children().trigger('click');
                }
            });
        }
    }
    $('.slider-announcements .list-announcements').slick({
        dots: false,
        arrows: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 820,
                settings: {

                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 540,
                settings: {
                    fade: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $(window).on('load', function(){
        $('.blog-list').isotope({
            // set itemSelector so .grid-sizer is not used in layout
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                // use element for option
                columnWidth: '.grid-sizer'
            }
        });
    });
    $('.edit-photo a#save-photo').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $imageInput = $('#edit-image-form').find('[type = file]');
        $imageInput.trigger('click');
        $imageInput.on('change', function () {
            $('#edit-image-form').trigger('submit');
        });
    });
    $('.list-img').find('input[type=file]').on('change', function (e) {
        var fileSrc  = e.target.files;


        if (fileSrc) {
            var images = Object.values(fileSrc);
            images.forEach(function(element) {
                var reader = new FileReader();
                reader.onloadend = function () {
                    var image = new Image();
                    image.src = reader.result;

                    var img = '<li><a href="#" class="holder-img"><i class="fas fa-times-circle"></i></a></li>';
                    $('#add-adv-image').before(img);
                    $('.list-img').find('.holder-img:last').append(image);
                    $('.list-img').find('.holder-img:last > img').css({'width':'130px', 'height':'130px'});
                }
                reader.readAsDataURL(element);
            });
        }
    });
    $('body').on('click','a.holder-img', function (e) {
        e.preventDefault();

       $(this).parents('li').remove();
    });


    $('#createPost').find('select#category_id').on('change', function(e) {
        var form = $('#createPost');
        var _csrf = form.find('input[name="_csrf"]').val();
        $.post( "/myaccount/default/update-cat", { id: $(this).val(),_csrf: _csrf })
            .done(function( data ) {
                $('#subcat_id').html(data).dropdown('update');
            });
    });
    $('#delete-photo').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var form = $('#edit-profile-form');
        var _csrf = form.find('input[name="_csrf"]').val();
        console.log(_csrf);
        //
        $.ajax({
            url: '/myaccount/default/remove-photo',
            type: 'POST',
            data: {
                id:'edit-image-form',
                _csrf:_csrf
            },
            success: function (data) {
                if( typeof data != 'undefined'){
                    $('img[alt="profile_image"]').each(function () {
                        $(this).attr('src', data );
                    })
                }
            }
        });
    });
    // like-heart active
    $(".like-star").click(function(e){
        $(this).toggleClass("active");
        $(this).parent().siblings(".active").children(".like-star").removeClass('active');
        e.preventDefault();
    });

    //open menu
    var opener = $('.open-menu');
    var menu = $('.holder-nav');
    opener.on('click', function(e){
        menu.slideDown();
        menu.addClass('open');
        $('body').addClass("fix-page");
        return false;

    });
    $('.holder-nav .closed-menu, .holder-nav .bg-nav').click(function(){
        menu.slideUp();
        menu.removeClass('open');
        $('body').removeClass("fix-page");
        return false;
    });

//open search form
    var openerr = $('.search-query');
    var form = $('.holder-form-search');
    openerr.on('click', function(e){
        form.addClass('active');
        return false;
    });
    $('.closed-search-form, .bg-search').click(function(){
        form.slideUp();
        form.removeClass('active');
        return false;
    });


    $('.promotion').slick({
        dots: false,
        arrows: true,
        fade: true,
        //adaptiveHeight: true,
        autoplay: true,
        autoplaySpeed: 4000,
        // infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [

            {
                breakpoint: 851,
                settings: {
                    mobileFirst: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.car-slider').slick({
        dots: false,
        arrows: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1
    });



    // popp-form
    $(".forgot").click(function(){
        $('.for-login, .form-recovery').addClass("active");
        $('.tab-control li').removeClass("active");
        return false;
    });
    $('#user_logout').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('#logout').trigger('click');
    });
    //accardion aside right info
    $(".item .heading").click(function(e){
        $(this).next().slideToggle(400,function(){
            $(this).closest('.item').toggleClass('active');
        });
        $(this).closest('.item').siblings(".active").find(".expanded").slideUp(400,function(){
            $(this).closest('.item').removeClass('active');
        });
        e.preventDefault();
    });

    // END show/hide drop
    $(".view-list").click(function(){
        $('.view-list').toggleClass("active");
        $('.content .list-announcements').toggleClass("active");
        return false;
    });

    // filters holder-aside-left
    $(".filters").click(function(e){
        $(this).next().slideToggle(400,function(){
            $('.filters').toggleClass("active");
    });
        e.preventDefault();
    });

    // dibalenie klasa eske est
    var testElements = document.getElementsByClassName('edit-list');
    var testDivs = Array.prototype.filter.call(testElements, function(){
        $('.list-announcements').addClass("clone");
    });


    //popup-profile
    $(".btn-profile").click(function(){
        $('.popup-profile').fadeIn();
        return false;
    });
    $(".closed-popup-profile").click(function(){
        $('.popup-profile').fadeOut();
        return false;
    });
    $(document).click(function(event) {
        if ($(event.target).closest('.popup-profile').length) return;
        $('.popup-profile').fadeOut();
        event.stopPropagation();
    });

    // list-add-del
    $(document).on('click','.btn-change', function(e){
        e.preventDefault();
        var thisEl = $(this);
        if($(this).hasClass('add-input')){
            var numsList = $('.list-add-del');
            lastNum = '<li><div class="holder-input"><input class="input" type="text" placeholder="Город"></div><div class="holder-input"><a class="btn-change add-input" href="#"></a><input class="input" type="text" placeholder="Район"></div></li>';
            numsList.append(lastNum);
            thisEl.removeClass('add-input');
        } else{
            thisEl.closest('li').remove();
        }
    });
    // end list-add-del


    //up page
    $(window).scroll(function(){
        if ($(window).scrollTop() > $(window).height()/2) {
            $('.up:hidden').fadeIn(300);
        } else {
            $('.up:visible').fadeOut(300);
        }
    });
    $('.up').click(function(){
        $('body, html').stop().animate({scrollTop:0},300);
        return false;
    });




    //range-slider
    initUi();

    resetAutocomplete();
});

function initUi(){
    $( ".slider-range" ).each(function(){
        var _slider = $(this);
        var _values = $('.min_max_currentmin_currentmax',_slider).val().split('/');
        _slider.slider({
            range: true,
            min: parseInt(_values[0]),
            max: parseInt(_values[1]),
            step:1,
            values: [ parseInt(_values[2]), parseInt(_values[3]) ],
            slide: function(event, ui) {
                $(ui.handle).html('<span>'+ui.value+'</span>');
                $(this).closest('.range-slider').find('input.from').val(ui.values[0]);
                $(this).closest('.range-slider').find('input.to').val(ui.values[1]);
            },
            change: function(event, ui) {
                $(ui.handle).html('<span>'+ui.value+'</span>');
                $(this).closest('.range-slider').find('input.from').val(ui.values[0]);
                $(this).closest('.range-slider').find('input.to').val(ui.values[1]);
            }
        });
        $( ".ui-slider-handle",_slider).html("<span>"+_slider.slider('values',1)+"</span>");
        $( ".ui-slider-handle",_slider).eq(0).find('span').text(_slider.slider('values',0));
        $(this).closest('.range-slider').find('input.to').val(_slider.slider('values',1));
        $(this).closest('.range-slider').find('input.from').val(_slider.slider('values',0));
    });
}

function acardionMobileAside(){
    $(".aside-accordion .title").click(function(e){
        if ($(window).width() < 769) {
            $(this).next().slideToggle(400,function(){
                $(this).parent().toggleClass('active');
            });
            $(this).parent().siblings(".active").children(".aside-accordion .expanded").slideUp(400,function(){
                $(this).parent().removeClass('active');
            });
            e.preventDefault();
        }
    })
}

function slickWidth(){
    $('.group-content .content').css({
        'width':$('.group-content').width()-$('.aside-right').outerWidth()
    });
}
function initTabs(){
    $('.tabset ul.tab-control li a').on('click', function(){
        $('.for-login, .form-recovery').removeClass("active");
        var thisHold = $(this).closest(".tabset");
        var _ind = $(this).closest('li').index();
        thisHold.children('.tab-body').children(".tab").removeClass('active');
        thisHold.children('.tab-body').children("div.tab:eq("+_ind+")").addClass('active');
        $(this).closest("ul").find(".active").removeClass("active");
        $(this).parent().addClass("active");
        return false;
    });
}

function asideAccordion(){

        var opener = $('.aside-title');
        var menu = $('.aside-content');
        opener.on('click', function(e){
            menu.slideToggle();
            $(this).toggleClass('active');
        });

}

function accordion(){
    $(".btn-accordion").click(function(e){
        if ($(window).width() < 660) {
            if($(this).closest('.item-accordion').hasClass('open')){
                $(this).closest('.item-accordion').removeClass('open');
            } else {
                $(this).closest('.accordion').find('.item-accordion.open').removeClass('open');
                $(this).closest('.item-accordion').addClass('open');
            }
        }


    })
}

function blockText(){
    $('.btn-show-more').each(function(){
        $(this).on('click', function(){
            $(this).closest('.holder-box-hidden').find('.box-hidden').slideToggle();
            $(this).closest('.holder-box-hidden').toggleClass("active");
            $(this).toggleClass("active");
            return false;
        })
    });

}

function resolutions(){
    $('body').append('<div class="resolutions900"></div>');
}

function init_and_resize(){
    if($('.resolutions900').is(':visible')){
        $('.holder-nav .container').prepend($('.list-language'));
    }
    if($('.resolutions900').is(':hidden')){
        $('.top-head').append($('.list-language'));
    }
}


function resolutions1(){
    $('body').append('<div class="resolutions500"></div>');
}
function init_and_resize1(){
    if($('.resolutions660').is(':visible')){
        $('#nav').prepend($('.btn-ads'));
    }
    if($('.resolutions660').is(':hidden')){
        $('.holder-ads').append($('.btn-ads'));
    }
}
function resolutions2(){
    $('body').append('<div class="resolutions660"></div>');
}
function init_and_resize2(){
    if($('.resolutions500').is(':visible')){
        $('#nav').append($('.log-registration'));
    }
    if($('.resolutions500').is(':hidden')){
        $('.top-head').append($('.log-registration'));
    }
    if($('.resolutions500').is(':hidden')){
        $('.top-head').append($('.open-menu'));
    }
}
function resolutions3(){
    $('body').append('<div class="resolutions768"></div>');
}
function init_and_resize3(){
    if($('.resolutions768').is(':visible')){
        $('.content .title-text').append($('.holder-aside-right'));
        $('.info-car').prepend($('.aside-profile'));
        $('.holder-filters .block-filter').append($('.holder-aside-left'));
        $('.holder-filters .block-filter').prepend($('.form-content'));
        // $('.block-filter').prepend($('.aside-profile'));
        $('.holder-information .block-filter').prepend($('.aside-profile'));
    }
    if($('.resolutions768').is(':hidden')){
        $('.aside-right').prepend($('.holder-aside-right'));
        $('.aside-right').prepend($('.aside-profile'));
        $('.aside-left').append($('.holder-aside-left'));
        $('.holder-filters').prepend($('.form-content'));
        $('.aside-left').prepend($('.aside-profile'));
    }
}



function initDropCity(){
    var availableTags = [
         "Киев",
         "Харьков",
         "Одесса",
         "Днепропетровск",
         "Донецк",
         "Запорожье",
         "Львов",
         "Кривой Рог",
         "Николаев",
         "Мариуполь",
         "Луганск",
         "Севастополь",
         "Винница",
         "Макеевка",
         "Симферополь",
         "Херсон",
         "Полтава",
         "Чернигов",
         "Черкассы",
         "Житомир",
         "Сумы",
         "Хмельницкий",
         "Горловка",
         "Ровно",
         "Кировоград",
         "Днепродзержинск",
         "Черновцы",
         "Кременчуг",
         "Ивано-Франковск",
         "Тернополь",
         "Белая Церковь",
         "Луцк",
         "Краматорск",
         "Мелитополь",
         "Керчь",
         "Никополь",
         "Северодонецк",
         "Славянск",
         "Бердянск",
         "Ужгород",
         "Алчевск",
         "Павлоград",
         "Евпатория",
         "Лисичанск",
         "Каменец-Подольский"
    ];
    $( ".tags-city").autocomplete({
        source: Object.values(avaibleCities)
    });
}
function initDropDistrict(){
    var availableTags = [
        "Киевский район",
        "Московский район",
        "Немышлянский район",
        "Новобаварский район",
        "Индустриальный район",
        "Основянский район",
        "Слободской район",
        "Холодногорский район",
        "Шевченковский район"
    ];
    $( ".district" ).autocomplete({
        source: availableTags
    });
}

function resetAutocomplete() {
    if( $('input').is('[type=email]')) {
        $('input').on('focus', function (e) {
            if( $(this).attr('readonly') == true || $(this).is('[readonly]')){
                $(this).removeAttr('readonly');
                $(this).trigger('blur');
                $(this).trigger('focus');
            }
        })
    }
}


