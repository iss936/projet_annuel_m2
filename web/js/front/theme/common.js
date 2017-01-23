 (function($) {
   "use strict";
   //init
   

    
   //btn-hack in auth effect
    var btn;
    if (document.querySelector('.btn-hack')) {
        btn = document.querySelector('.btn-hack');
        var btnFront;
        btnFront = btn.querySelector('#auth_menu'); // !== null;
        if (btnFront) {
            var btnYes = btn.querySelector('.btn-back .yes'),
            btnNo = btn.querySelector('.btn-back .no');
            jQuery('#reg_close').on('click', function (event) {
                // event.preventDefault();
                // $(this).parents(".is-open").removeClass("is-open");
            });
            jQuery('#auth_menu').on('click', function (event) {
                event.preventDefault();
                var mx = event.clientX - btn.offsetLeft,
                my = event.clientY - btn.offsetTop;
                event.preventDefault();
                var w = btn.offsetWidth,
                h = btn.offsetHeight;
                var directions = [{
                    id : 'top',
                    x : w / 2,
                    y : 0
                }, {
                    id : 'right',
                    x : w,
                    y : h / 2
                }, {
                    id : 'bottom',
                    x : w / 2,
                    y : h
                }, {
                    id : 'left',
                    x : 0,
                    y : h / 2
                }
                ];
                directions.sort(function (a, b) {
                    return distance(mx, my, a.x, a.y) - distance(mx, my, b.x, b.y);
                });
                btn.setAttribute('data-direction', directions.shift().id);
                btn.classList.add('is-open');
                return false;
            });

        }
    }
            function distance(x1, y1, x2, y2) {
                var dx = x1 - x2;
                var dy = y1 - y2;
                return Math.sqrt(dx * dx + dy * dy);
            }

   
    //menu-top effect
    $(document).on('mouseenter','.menu-top-right a',function(){
       $(this).siblings().addClass('menu-top-a-hover');
    });
    $(document).on('mouseleave','.menu-top-right a',function(){
       $(this).siblings().removeClass('menu-top-a-hover');
    });
    //megamenu show
    $(document).on('mouseenter','.head_nav li a',function(){
        $('.megamenu').fadeOut(300);
    });
    $(document).on('mouseenter','#megamenu_a',function(){
        $('.megamenu').fadeIn(300);
    });
    $(document).on('mouseleave','.megamenu',function(){
        $('.megamenu').fadeOut(300);
    });
    //small-beats active
    $(document).on('click','.small_beats a',function(e){
        e.preventDefault();
        $(this).addClass('active');
        $(this).parent().siblings().find('a').removeClass('active');
    });
    //menu-xs click adaptive
    $(document).on('click','.menu_xs',function(e){
        $('header .navigate').fadeToggle(300);
    });
    //index-4-columns effect
         //mega effect
        $(document).on("click",'.index-front-column-1',function(e){     
     
        var url_img = $('.index-front-column-1').css('background').match(/url\((.*?)\)/);    
               
        $('.heading-block').css({
            'background-image': url_img[0]

        });
      
        $(this).addClass('animated fadeOut');
        $('body').addClass('column-1');
        $('.index-front-column-2').addClass('animated fadeOutRight');
        $('.index-front-column-3').addClass('animated fadeOutRight');
        $('.index-front-column-4').addClass('animated fadeOutRight');
        $('.i-1').fadeIn(500);
        $('.i-1').siblings('ul').hide();
        var text_li = $('.i-1').find('li').eq(2).html();
        $('.heading-block-href h1').find('span').eq(0).empty().append(text_li);
        var h_width = $('.heading-block-info').width();
        var h_height = $('.heading-block-info').height();
        // $('.heading-block-info').css({
        //     'margin-left': ((h_width/2)*(-1)) + 'px'
        // });
        // $('.heading-block-info').css({
        //     'margin-top': ((h_height/2)*(-1)) + 'px'
        // });
        $(this).parent().addClass('zindex-off');
        $('.heading_blog header').addClass('animated fadeInDown');
        $('.top_line').addClass('animated fadeInDown');
        $('.home').css({
            'overflow-y':'visible'
        });
    });
    $(document).on("click",'.index-front-column-2',function(e){
        $(this).addClass('animated fadeOut');
        $('body').addClass('column-2');
        $('.index-front-column-1').addClass('animated fadeOutLeft');
        $('.index-front-column-3').addClass('animated fadeOutRight');
        $('.index-front-column-4').addClass('animated fadeOutRight');
    
        var url_img = $('.index-front-column-2').css('background').match(/url\((.*?)\)/);        
        
        $('.heading-block').css({
            'background-image': url_img[0]
        });
        $('.i-2').fadeIn(500);
        $('.i-2').siblings('ul').hide();
        var text_li = $('.i-2').find('li').eq(2).html();
        $('.heading-block-href h1').find('span').eq(0).empty().append(text_li);
        var h_width = $('.heading-block-info').width();
        var h_height = $('.heading-block-info').height();
        // $('.heading-block-info').css({
        //     'margin-left': ((h_width/2)*(-1)) + 'px'
        // });
        // $('.heading-block-info').css({
        //     'margin-top': ((h_height/2)*(-1)) + 'px'
        // });
        $(this).parent().addClass('zindex-off');
        $('.home').css({
            'overflow-y':'visible'
        });
    });
    
    $(document).on("click",'.index-front-column-3',function(e){

        $(this).addClass('animated fadeOut');
        $('body').addClass('column-3');
        $('.index-front-column-1').addClass('animated fadeOutLeft');
        $('.index-front-column-2').addClass('animated fadeOutLeft');
        $('.index-front-column-4').addClass('animated fadeOutRight');
        
        var url_img = $('.index-front-column-3').css('background').match(/url\((.*?)\)/);        

        $('.heading-block').css({
            'background-image': url_img[0]
        });
        
        $('.i-3').fadeIn(500);
        $('.i-3').siblings('ul').hide();
        var text_li = $('.i-3').find('li').eq(2).html();
        $('.heading-block-href h1').find('span').eq(0).empty().append(text_li);
        var h_width = $('.heading-block-info').width();
        var h_height = $('.heading-block-info').height();
        // $('.heading-block-info').css({
        //     'margin-left': ((h_width/2)*(-1)) + 'px'
        // });
        // $('.heading-block-info').css({
        //     'margin-top': ((h_height/2)*(-1)) + 'px'
        // });
        $(this).parent().addClass('zindex-off');
        $('.home').css({
            'overflow-y':'visible'
        });
    });
    
    $(document).on("click",'.index-front-column-4',function(e){
        $(this).addClass('animated fadeOut');
        $('body').addClass('column-4');
        $('.index-front-column-1').addClass('animated fadeOutLeft');
        $('.index-front-column-2').addClass('animated fadeOutLeft');
        $('.index-front-column-3').addClass('animated fadeOutLeft');
        
        var url_img = $('.index-front-column-4').css('background').match(/url\((.*?)\)/);        
        
        $('.heading-block').css({
            'background-image': url_img[0]
        });
        $('.i-4').fadeIn(500);
        $('.i-4').siblings('ul').hide();
        var text_li = $('.i-4').find('li').eq(2).html();
        $('.heading-block-href h1').find('span').eq(0).empty().append(text_li);
        var h_width = $('.heading-block-info').width();
        var h_height = $('.heading-block-info').height();
        // $('.heading-block-info').css({
        //     'margin-left': ((h_width/2)*(-1)) + 'px'
        // });
        // $('.heading-block-info').css({
        //     'margin-top': ((h_height/2)*(-1)) + 'px'
        // });
        $(this).parent().addClass('zindex-off');
        $('.home').css({
            'overflow-y':'visible'
        });
    });
     //owl-person
        $("#owl-demo-person").owlCarousel({

        navigation : true, // Show next and prev buttons
        slideSpeed : 700,
        paginationSpeed : 700,
        singleItem:true,
        autoPlay:true,
        // "singleItem:true" is a shortcut for:
        items : 1
        // itemsDesktop : false,
        // itemsDesktopSmall : false,
        // itemsTablet: false,
        // itemsMobile : false

        });
        //owl-person1
        $("#owl-demo-person1").owlCarousel({

        autoPlay: 2000, //Set AutoPlay to 3 seconds

        items : 3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]

        });
        
        //init selectpicker
        $('.selectpicker').selectpicker();

        //best apps slider
    
    
            if(typeof myowlCarousel == "function") {
                $("#owl-demo5").owlCarousel({

                // Most important owl features
                items : 10,
                itemsCustom : false,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [980,3],
                itemsTablet: [768,3],
                itemsTabletSmall: false,
                itemsMobile : [479,3],
                singleItem : false,
                itemsScaleUp : false  ,
                pagination:false
            });
        }       
        if(typeof myowlCarousel == "function") {      

          $("#owl-demo").owlCarousel({

          navigation : true, // Show next and prev buttons
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem:true,
          pagination:false
   
          
         });
      }   
        //range

        $("#range").ionRangeSlider({
            hide_min_max: true,
            keyboard: true,
            type: 'double',
            step: 1,
            // prefix: "years ",
            grid: true
        });

        // add arrow in menu-children item
        $('.head_nav > .menu-item-has-children').children('a').append('<i class="fa fa-angle-down"></i>');
        $('.sub-menu .menu-item-has-children').children('a').append('<i class="fa fa-caret-right"></i>');
        //auth fade

        $('.reg_image_container').addClass("reg_opacity_in");
        //Carousel items

        var owl = $("#owl-demo5"),
        owl6 = $("#owl-demo6");
               
        if(typeof myowlCarousel == "function") { 
        owl.owlCarousel({
            items : 10, //10 items above 1000px browser width
            itemsDesktop : [1000,8], //5 items between 1000px and 901px
            itemsDesktopSmall : [900,6], // betweem 900px and 601px
            itemsTablet: [600,4], //2 items between 600 and 0
            pagination: false,
            itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
            });
        }
        if(typeof myowlCarousel == "function") { 
        owl6.owlCarousel({
            items : 5, //10 items above 1000px browser width
            itemsDesktop : [1000,8], //5 items between 1000px and 901px
            itemsDesktopSmall : [900,6], // betweem 900px and 601px
            itemsTablet: [600,4], //2 items between 600 and 0
            pagination: false,
            itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        });
   }
     // Custom Navigation Events
     $(document).on('click','.user_photo .next',function(){
        owl.trigger('owl.next');
     });
     $(document).on('click','.user_question .next',function(){
         owl6.trigger('owl.next');
     });

    $('#owl-demo6 .owl-wrapper-outer').append('<div class="photos_gradient"></div>');
    //Navigation sub-menu open
    if($(window).width() > 768){
    $(document).on('mouseenter','.menustyle_classic .head_nav .menu-item-has-children',function(){
        $(this).children('.sub-menu').fadeIn(300);
    });
    $(document).on('mouseleave','.menustyle_classic .head_nav .menu-item-has-children',function(){
        $(this).children('.sub-menu').fadeOut(300);
    });
    }
   
 

})(jQuery);

    "use strict";

    if (typeof window.initialize_map  === 'undefined') {
        window.initialize_map  = function() {
          
        }
    }
   
   
     var fmr_ajaxurl = 'http://freelance.vioo.ru/wp-admin/admin-ajax.php';
            var fmr_gpid = '1805';
            var fmr_cpage = '';
            var global_map_styles = [];
            var templateUrl = 'http://freelance.vioo.ru/wp-content/themes/frame_fl';
            var pluginsUrl = 'http://freelance.vioo.ru/wp-content/plugins';
                        var fmr_tags = [{value: 'PHP'},{value: 'HTML'},{value: 'CSSf'}];





 
    

   
    

  
    
   

    

   



  

  
    
    
   
    
   

   
    
  
           





