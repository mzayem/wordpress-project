(function ($, window) {

    window.pfpFixLazyLoadToAll = function () {
        $('.tlp-portfolio-container').each(function () {
            // jetpack Lazy load
            $(this).find('img.jetpack-lazy-image:not(.jetpack-lazy-image--handled)').each(function () {
                $(this).addClass('jetpack-lazy-image--handled').removeAttr('srcset').removeAttr('data-lazy-src').attr('data-lazy-loaded', 1);
            });

            //
            $(this).find('img.lazyload').each(function () {
                var src = $(this).attr('data-src') || '';
                if (src) {
                    $(this).attr('src', src).removeClass('lazyload').addClass('lazyloaded');
                }
            });

            $(this).find("img[data-lazy-src]:not(.lazyloaded)").each(function () {
                $imgUrl = $(this).data("lazy-src");
                $(this).attr('src', $imgUrl).addClass('lazyloaded');
            });
        });
    };

    window.pfpFixLazyLoad = function (container) {
        if (container === undefined)
            return;

        // jetpack Lazy load
        container.find('img.jetpack-lazy-image:not(.jetpack-lazy-image--handled)').each(function () {
            $(this).addClass('jetpack-lazy-image--handled').removeAttr('srcset').removeAttr('data-lazy-src').attr('data-lazy-loaded', 1);
        });

        //
        container.find('img.lazyload').each(function () {
            var src = $(this).attr('data-src') || '';
            if (src) {
                $(this).attr('src', src).removeClass('lazyload').addClass('lazyloaded');
            }
        });

        container.find("img[data-lazy-src]:not(.lazyloaded)").each(function () {
            var imgUrl = $(this).data("lazy-src");
            $(this).attr('src', imgUrl).addClass('lazyloaded');
        });
    };

    // window.pfpOverlayIconResize = function () {
        // $('.tlp-item').each(function () {
        //     var holder_height = $(this).height();
        //     var a_height = $(this).find('.tlp-overlay .link-icon').height();
        //     var h = (holder_height - a_height) / 2;
        //     $(this).find('.link-icon').css('margin-top', h + 'px');
        // });
    // };

    window.initTlpPortfolio = function () {
        $(".tlp-portfolio-container").each(function () {
            var container = $(this),
                isIsotope = container.hasClass("is-isotope"),
                isCarousel = container.find('is-carousel');
            pfpFixLazyLoad(container);
            setTimeout(function () {
                container.imagesLoaded().progress(function (instance, image) {
                    container.trigger('pfp_image_loading');
                }).done(function (instance) {
                    container.trigger('pfp_item_before_load');
                    if (isIsotope) {
                        var isoHolder = container.find('.tlp-portfolio-isotope');
                        if (isoHolder.length) {
                            isoHolder.isotope({
                                itemSelector: '.tlp-isotope-item',
                            });
                            container.trigger('pfp_item_after_load');
                            setTimeout(function () {
                                isoHolder.isotope();
                            }, 10);
                            var $isotopeButtonGroup = container.find('.tlp-portfolio-isotope-button');
                            $isotopeButtonGroup.on('click', 'button', function (e) {
                                e.preventDefault();
                                var filterValue = $(this).attr('data-filter');
                                isoHolder.isotope({filter: filterValue});
                                $(this).parent().find('.selected').removeClass('selected');
                                $(this).addClass('selected');
                            });
                        }
                    }
                    setTimeout(function () {
                        $(document).trigger("pfp_loaded");
                    }, 10);
                });
            }, 10);
        });
    };

    window.initPfpMagicPopup = function () {
        if ($.fn.magnificPopup) {
            $('.tlp-portfolio-container').each(function () {
                $(this).magnificPopup({
                    delegate: '.tlp-zoom',
                    type: 'image',
                    preload: [1, 3],
                    gallery: {
                        enabled: true
                    }
                });
            });
        }
    };

    window.initRtppCaroselPortfolio =  function(){
        $('.is-carousel').each(function () {
            var container = $(this);
            // id = $.trim(container.attr('id')),
            var caro = container.find('.pfp-carousel');
            if (caro.length) {
                var items = caro.data('items'),
                    loop = caro.data('loop'),
                    nav = caro.data('nav'),
                    dots = caro.data('dots'),
                    autoplay = caro.data('autoplay'),
                    autoPlayHoverPause = caro.data('autoplay-hover-pause'),
                    autoPlayTimeOut = caro.data('autoplay-timeout'),
                    autoHeight = caro.data('autoheight'),
                    lazyLoad = caro.data('lazyload'),
                    rtl = caro.data('rtl'),
                    desktopcolumn = caro.data('desktopcolumn'),
                    tabcolumn = caro.data('tabcolumn'),
                    mobilecolumn = caro.data('mobilecolumn'),
                    smartSpeed = caro.data('smart-speed');
                caro.owlCarousel({
                    items: items ? items : desktopcolumn,
                    loop: loop ? true : false,
                    nav: nav ? true : false,
                    dots: dots ? true : false,
                    navText: ["<i class=\'demo-icon icon-left-open\'></i>", "<i class=\'demo-icon icon-right-open\'></i>"],
                    autoplay: autoplay ? true : false,
                    autoplayHoverPause: autoPlayHoverPause ? true : false,
                    autoplayTimeout: autoPlayTimeOut ? autoPlayTimeOut : 5000,
                    smartSpeed: smartSpeed ? smartSpeed : 250,
                    autoHeight: autoHeight ? true : false,
                    lazyLoad: lazyLoad ? true : false,
                    rtl: rtl ? true : false,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: mobilecolumn ? mobilecolumn : 1
                        },
                        600: {
                            items: tabcolumn ? tabcolumn : 2
                        },
                        1000: {
                            items: items ? items : 3
                        }
                    }
                });
                caro.parents('.rt-row').removeClass('pfp-pre-loader');
            }
            
        });
        
        // console.log('Ready');
    }

    $(document).on('pfp_loaded pfp_item_after_load', function () {
        initPfpMagicPopup();
        // pfpOverlayIconResize();
    });
    $(function () {
        initPfpMagicPopup();
        initTlpPortfolio();
    });
    $(window).on('resize', function () {
        $(".tlp-portfolio-container").trigger("pfp_loaded");
    });

    $(window).on('load', function () {
        initRtppCaroselPortfolio();
    });

     // Elementor Frontend Load
    $( window ).on( 'elementor/frontend/init', function() {
        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function(){
                initRtppCaroselPortfolio();
            } );
        }
    } );


})(jQuery, window);
