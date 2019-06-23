$(document).ready(function () {$(".removeItem").click(function (e) {e.preventDefault();var href = $(this).attr('href');swal({title: 'آیا اطمینان دارید؟',text: "توجه کنید در صورت تایید این عمل قابل بازگشت نیست",type: 'warning',showCancelButton: true,confirmButtonColor: '#54b35c',cancelButtonColor: '#d33',confirmButtonText: 'بله',cancelButtonText: 'خیر'}).then(function (result) {if (result) {window.location = href;}});});});
$(document).ready(function () {
    jQuery("#nav").singlePageNav({
        offset: jQuery("#nav").outerHeight(),
        filter: ":not(.external)",
        speed: 1200,
        currentClass: "current",
        easing: "easeInOutExpo",
        updateHash: !0,
    }), $(window).scroll(function () {
        $(window).scrollTop() > 0 ? ($("#navigation").css("background-color", "#e52531"), $(".logo").css("display", "none", " border:none"), $(".logo1").css("display", "block", " border:none")) : ($("#navigation").css("background-color", "rgba(0, 0, 0, 0.0)"), $(".logo").css("display", "block", " border:none"), $(".logo1").css("display", "block", " border:none"))
    });
    var e = $(window).height();
    $("#slider, .carousel.slide, .carousel-inner, .carousel-inner .item").css("height", e), $(window).resize(function () {
        $("#slider, .carousel.slide, .carousel-inner, .carousel-inner .item").css("height", e)
    }), $(".project-wrapper").mixItUp(), $(window).scroll(function () {
        $(window).scrollTop() > 400 ? $("#back-top").fadeIn(200) : $("#back-top").fadeOut(200)
    }), $("#back-top").click(function () {
        $("html, body").stop().animate({scrollTop: 0}, 1500, "easeInOutExpo")
    })
}),$("nav.menu li").hover(function () {
    $("> ul", this).stop().slideDown(200)
}, function () {
    $("> ul", this).stop().slideUp(200)
}), $(".links li.have-sub a").click(function (e) {
    var o = $(this).parent("li").hasClass("noSub");
    o || e.preventDefault(), $(this).parent("li").siblings("li").children("ul").slideUp("fast"), $(this).parent("li").toggleClass("open-li");
    var n = $(this).parent().children("ul:first");
    n.slideToggle("down")
}), $(function () {
    $("a[href*=#]:not([href=#])").click(function () {
        if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
            var e = $(this.hash);
            if (e = e.length ? e : $("[name=" + this.hash.slice(1) + "]"), e.length) return $("html,body").animate({scrollTop: e.offset().top}, 1e3), !1
        }
    })
}), $(".search").click(function () {
    $("ul").toggleClass("active"), $(".search_box").toggleClass("search_box_active")
});
var seened=false;
    window.dataLayer = window.dataLayer || [];
var height = window.innerHeight;
    
    $(document).ready(function () {
        $('#offset').tooltipster({
            plugins: ['follower']
        });
        $('#digital').tooltipster({
            plugins: ['follower']
        });
        $('#student').tooltipster({
            plugins: ['follower']
        });
        $('#gift').tooltipster({
            plugins: ['follower']
        });
        $('#offset').tooltipster('content', 'لیست قیمت چاپ افست');
        $('#digital').tooltipster('content', 'لیست قیمت چاپ دیجیتال');
        $('#student').tooltipster('content', 'لیست قیمت خدمات دانشجویی');
        $('#gift').tooltipster('content', 'تخفیف روز');
        $("#banner").modal();
        $('[data-toggle="tooltip"]').tooltip();
    });
    var wow = new WOW({
        boxClass: 'wow', // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset: 120, // distance to the element when triggering the animation (default is 0)
        mobile: false, // trigger animations on mobile devices (default is true)
        live: true // act on asynchronously loaded content (default is true)
    });
    wow.init();
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 768) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            }
            else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }

        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });