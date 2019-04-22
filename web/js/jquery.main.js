$(document).ready(function(){
    window.mobilecheck = function() {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    if(window.mobilecheck == true) {
        $('.slider-arrow').css({opacity:1});
    }

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
        $('.list-announcements li').matchHeight();
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

    $('.main-slider-announcements .list-announcements').slick({
        dots: false,
        arrows: true,
        speed: 300,
        slidesToShow: 4,
        // slidesToScroll: 1,
        rows: 3,
        prevArrow:"<button class='slick-prev pull-left'><i class='fas fa-long-arrow-alt-left'></i></button>",
        nextArrow:"<button  class='slick-next pull-right'><i class='fas fa-long-arrow-alt-right' aria-hidden='true'></i></button>",
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    rows: 1,
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 820,
                settings: {
                    rows: 1,
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 540,
                settings: {
                    rows: 1,
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
    $('.list-img').on('change', 'input[type=file]', function (e) {
        var fileSrc  = e.target.files;
        var input = $(this).clone().val('');
        $(this).removeAttr('id');
        $(this).after(input);

        if (fileSrc) {
            var images = Object.values(fileSrc);
            images.forEach(function(element) {
                var reader = new FileReader();
                reader.onloadend = function () {
                    var image = new Image();
                    image.src = reader.result;

                    var img = '<li><a href="#" class="holder-img" style="background: url('+image.src+') no-repeat center center; background-size:cover;"><i class="delete-adv-image fas fa-times-circle"></i><img src="/images/edit_image.png"></a></li>';
                    $('#add-adv-image').before(img);
                };
                reader.readAsDataURL(element);
            });
        }
    });
    $('body').on('click','a.holder-img', function (e) {
        e.preventDefault();
       $(this).parents('li').remove();
    });

    $('body').on('click', 'i.delete-adv-image', function () {
        var imageID = '';
        var _csrf = $('[name = "_csrf"]').val();
        if(typeof $(this).attr('data-id') != 'undefined' && $(this).attr('data-id') != '') {
            imageID = $(this).attr('data-id');
            $.ajax({
                    url: window.deletePath,
                    type: 'POST',
                    data: {
                        id: imageID,
                        _csrf:_csrf
                    },
                    success: function (data) {
                        if( typeof data != 'undefined'){
                            console.log('ok');
                        } else {
                            return false;
                        }
                    }
            });
        }
    });

    $('#createPost').find('select#category_id').on('change', function(e) {
        var form = $('#createPost');
        var _csrf = form.find('input[name="_csrf"]').val();
        var catId = $(this).val();
        var catUrl = form.attr('data-catUrl');

        $.post(catUrl, { id: $(this).val(),_csrf: _csrf })
            .done(function( data ) {
                var data = JSON.parse(data);
                $('#subcat_id').html(data.data).dropdown('update');

                var pjax_id = "filters";
                var url =  $('#createPost').attr('action');
                var _csrf = form.find('input[name="_csrf"]').val();

                $.pjax.reload({
                    type: 'POST',
                    container:'#'+pjax_id,
                    data: {
                        catId: catId,
                        _csrf:_csrf
                    },
                    url: url
                });
                $(document).on('pjax:start', function (e) {
                    $('.loader').toggleClass('hidden');
                });
                $(document).on('pjax:beforeReplace', function (e) {
                    $('.loader').addClass('hidden');
                });
                $(document).on('pjax:success', function (e) {
                    $('.dropdown').dropdown();
                });
            });
    });
    $('#delete-photo').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var form = $('#edit-profile-form');
        var _csrf = form.find('input[name="_csrf"]').val();

        $.ajax({
            url: window.deleteImage,
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

    $('body').on('click', '.btn-rates', function(e){
        var menu = $(this).closest('li').find('.holder-rates');
        e.preventDefault();
        menu.slideToggle();
        $(this).toggleClass("active");
        $(this).parents(".edit-list").addClass("z-i"); //добавляем класс текущей (нажатой)
    });
    // like-heart active
    $(".like-star").on('click', function(e){

        var id = $(this).attr('data-id');
        var _csrf = $('[name = "_csrf"]').val();
        var $self = $(this);
        if(! $(this).hasClass('active')) {
            $.ajax({
                url: '/myaccount/default/make-fav',
                type: 'POST',
                data: {
                    id: id,
                    _csrf:_csrf
                },
                success: function (data) {
                    $self.toggleClass("active");
                    $self.parent().siblings(".active").children(".like-star").removeClass('active');
                }
            });
        } else {
            $.ajax({
                url: '/myaccount/default/remove-fav',
                type: 'POST',
                data: {
                    id: id,
                    _csrf:_csrf
                },
                success: function (data) {
                    $self.toggleClass("active");
                    $self.parent().siblings(".active").children(".like-star").removeClass('active');
                }
            });
        }

        e.preventDefault();
    });

    $('.pjax-buttons').on('click', function (e) {
       e.preventDefault();
        var pjax_id = "search-sort";
        var url = $('#sortingForm').attr('action');
        var page = $('.pagination').find('.active').next().find('a').attr('data-page');
        $.pjax.reload({container:'#'+pjax_id, url: url, page: ++page });
        return false;
    });

    //MyAccount posts
    $('body').on('click', '.ad-status > li a', function (e) {
        e.preventDefault();

       $('.ad-status li').removeClass('active');
       $(this).parent().toggleClass('active');

        var pjax_id = "account-posts";
        var url = $(this).attr('href');

        $.pjax.reload({container:'#'+pjax_id, url: url});

        $(document).on('pjax:start', function (e) {
            $('.loader').toggleClass('hidden');
        });
        $(document).on('pjax:beforeReplace', function (e) {
            $('.loader').addClass('hidden');
        });

    });

    $('body').on('click', '.ajax-load a', function (e) {
        e.preventDefault();

        if(! $('.pagination').find('.next').hasClass('disabled') ) {
            var page = (typeof  $('.pagination > .active').next().find('a').attr('data-page') != 'undefined')? $('.pagination > .active:last').next().find('a').attr('data-page') : '';
            var form = $('#sortingForm');
            var filter = $('.aside-left > form');
            var _csrf = $('[name = "_csrf"]').val();
            var orderBy = form.find('input[name=orderBy]').val();
            var city = form.find('input[name=city]').val();
            var district = form.find('input[name=district]').val();
            var minPrice = filter.find('input[name=minPrice]').val();
            var minDistance = filter.find('input[name=minDistance]').val();
            var maxPrice = filter.find('input[name=maxPrice]').val();
            var maxDistance = filter.find('input[name=maxDistance]').val();
            var stickingArea = [];

            $.each($("input[name='stickingArea[]']:checked"), function(){
                stickingArea.push($(this).val());

            });

            if( typeof page != 'undefined' && !isNaN(page) ) {
                page = parseInt(page);
                ++page;

                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        page: page,
                        orderBy: orderBy,
                        city: city,
                        district: district,
                        minPrice: minPrice,
                        maxPrice: maxPrice,
                        minDistance: minDistance,
                        maxDistance: maxDistance,
                        stickingArea: stickingArea,
                        action: 'lazyLoad',
                        _csrf:_csrf,
                    },
                    success: function (response) {
                        if(typeof response != 'undefined' && response != '') {
                            $('li.ajax-load').remove();
                            $('#search-sort > ul').append(response);
                            $('.pagination > .active').next().addClass('active');
                            setTimeout(refreshAnouncements, 300);
                        }
                    }
                });
            }
        }
    });

    function refreshAnouncements() {
        // $('.list-announcements li').matchHeight();
    }
    //open menu
    $('body').on('click', '.open-menu', function(e){
        var menu = $('.holder-nav');
        menu.slideDown();
        menu.addClass('open');
        $('body').addClass("fix-page");
        return false;

    });
    $('.holder-nav .closed-menu, .holder-nav .bg-nav').click(function(){
        var menu = $('.holder-nav');
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

    $('.prev-page').on('click', function (e) {
       e.preventDefault();
       e.stopPropagation();
       $('.pagination').find('.prev > a').trigger('click');
    });

    $('.next-page').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.pagination').find('.next > a').trigger('click');
    });

    $('#sortingForm').find('input').on('blur', function (e) {
        $('#sortingForm').trigger('submit');
    });

    $('#sortingForm').find('select').on('change', function (e) {
        $('#sortingForm').trigger('submit');
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
        var parents = {
          city: $('#advertisementpost-city'),
          district: $('#advertisementpost-city_district')
        };
        var cityName = parents.city.attr('name');
        var districtName = parents.district.attr('name');
        if($(this).hasClass('add-input')){
            var numsList = $('.list-add-del');
            lastNum = '<li><div class="holder-input"><input class="input" type="text" name="'+cityName+'" placeholder="'+parents.city.attr('placeholder')+'"></div><div class="holder-input"><a class="btn-change add-input" href="#"></a><input class="input" name="'+districtName+'" type="text" placeholder="'+parents.district.attr('placeholder')+'"></div></li>';
            numsList.append(lastNum);
            thisEl.removeClass('add-input');
            $('.list-add-del > li:last').find('input:first').autocomplete({
                source: Object.values(avaibleCities)
            });
        } else{
            thisEl.closest('li').remove();
        }
    });
    // end list-add-del

    $(document).on('click', '.liqpay_submit', function (e) {
       e.preventDefault();
       let $form = $(this).parents('form');
       var _csrf = $('[name = "_csrf"]').val();

       let requestObj = {
         rate: $form.attr('data-rate'),
         advertisement: $form.attr('data-advertisement'),
         data: $form.find('input[name=data]').val(),
         _csrf: $('[name = "_csrf"]').val(),
       };

       $.ajax({
           url: $form.attr('data-orderurl'),
           type: 'POST',
           data: requestObj,
           success: function (response) {
                if( typeof response != 'undefined' && response != '') {
                    $form.trigger('submit');
                }
           }
       })

    });

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


    $(document).click(function(event) {
        if ($(event.target).closest('.holder-rates').length) return;
        if ($(event.target).closest('.edit-list').length) return;
        $('.holder-rates, .btn-rates').removeClass("active");
        $('.edit-list').removeClass("z-i");
        $('.holder-rates').fadeOut();
        event.stopPropagation();
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
                var wrapper = $(this).closest('.range-slider');
                $(ui.handle).html('<span>'+ui.value+'</span>');
                wrapper.find('input.from').val(ui.values[0]);
                wrapper.find('input.to').val(ui.values[1]);
                wrapper.find('.minVal').val(ui.values[0]);
                wrapper.find('.maxVal').val(ui.values[1]);
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
    if( $(document).find('input').is('.tags-city')) {
        $('.tags-city').autocomplete({
              source: Object.values(avaibleCities)
        });
    }
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


