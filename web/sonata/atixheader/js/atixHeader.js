if (typeof(window.jQuery) === 'undefined') {
    alert("Attention le header a besoin d'un jQuery pour pouvoir fonctionner");
} else {
    $(document).ready(function() {
        //Sidebar hide/show childrens
        $('.sidebarSite-nav li.has-children > a ').click(function(e){
            $(this).parent().find(' > ul > li').toggleClass('open');
            $(this).parent().toggleClass('open-category')
            e.preventDefault();
        });

        //Sidebar
        $('body').prepend($('.sidebarSite'));
        $('.sidebarSite-close, .menu-toggle').click(function(){
            $('body').toggleClass('open-sidebar');
            if($('body').hasClass('open-sidebar'))
                $('body').removeClass('remove-sidebar');
            else
                $('body').addClass('remove-sidebar');
        });
        $('body').click(function(e){
            var lengths = $(e.target).parents('.sidebarSite, .menu-toggle').length;
            if(lengths == 0)
            $('body').removeClass('open-sidebar');
        });
        $('.sidebarSite').height($(window).height()+15);
        $(window).resize(function(){
            $('.sidebarSite').height($(window).height());
            if($('body').hasClass('open-sidebar')){
                $('body').removeClass('open-sidebar');
                $('body').addClass('remove-sidebar');
            }
        })

        //popovers
        $('.headerSite-popover').each(function(){
            var popover=$(this);
            $(this).parent().find('> a').click(function(){
                var visible = !popover.hasClass('headerSite-popover__hidden');
                $('.headerSite-popover').addClass('headerSite-popover__hidden');
                if(!visible) popover.toggleClass('headerSite-popover__hidden');
            });
        });
        $('body').click(function(e){
            var lengths = $(e.target).parent().find(' > .headerSite-popover').length + $(e.target).parents('a').first().parent().find(' > .headerSite-popover').length;
            if(lengths == 0)
            $('.headerSite-popover').addClass('headerSite-popover__hidden');
        });

        //TODO ::: with hammer : get menu sliding on touch
        // delete Hammer.defaults.cssProps.userSelect;
        // var hammertime = new Hammer($('body')[0], {});
        // var max = 275;
        // var cStep = 0;
        // cStep = $('.sidebarSite').position().left;
        // hammertime.on('pan', function(ev) {
        //     $('body').removeClass('open-sidebar');
        //     $('body').removeClass('remove-sidebar');
        //     var delta = ev.deltaX;
        //     var nextStep = cStep + delta;
        //     if(nextStep >=-max && nextStep <0)
        //     $('.sidebarSite').css('left', nextStep);
        //     if(ev.isFinal) {
        //         $('.sidebarSite').removeAttr('style');
        //         if(ev.direction == 4) {
        //             $('body').addClass('open-sidebar');
        //             $('body').removeClass('remove-sidebar');
        //             cStep = 0;
        //         }else{
        //             $('body').removeClass('open-sidebar');
        //             $('body').addClass('remove-sidebar');
        //             cStep = -max;
        //         }
        //     }
        // });
    });
}
