(function ($) {
    'use strict';

    $(function(){
        if ($('.tlp-color').length && $.fn.wpColorPicker) {
            var cOptions = {
                defaultColor: false,
                change: function (event, ui) {
                    setTimeout(function(){  renderTlpPortfolioPreview(); }, 500);
                },
                clear: function () {
                    setTimeout(function(){  renderTlpPortfolioPreview(); }, 500);
                },
                hide: true,
                palettes: true
            };
            $('.tlp-color').wpColorPicker( cOptions );
        }
    });

    if ($(".tlp-date").length) {
        $('.tlp-date').datepicker({
            'format': tlp_portfolio_obj.tlp_date_format,
            'autoclose': true
        });
    }
    if ($("select.rt-select2").length && $.fn.select2) {
        $("select.rt-select2").select2({
            theme: "classic",
            dropdownAutoWidth: true,
            width: '100%'
        });
    }

    // if ($("#tlp_portfolio_sc_settings_meta .rt-color").length && $.fn.wpColorPicker) {
    //     var cOptions = {
    //         defaultColor: false,
    //         change: function (event, ui) {
    //             setTimeout(function(){  renderTlpPortfolioPreview(); }, 500);
    //         },
    //         clear: function () {
    //             setTimeout(function(){  renderTlpPortfolioPreview(); }, 500);
    //         },
    //         hide: true,
    //         palettes: true
    //     };
    //     $("#tlp_portfolio_sc_settings_meta .rt-color").wpColorPicker(cOptions);
    // }


    /* rt tab active navigatiosn */
    $("#tlp_portfolio_sc_settings_meta .rt-tab-nav li").on('click', 'a', function (e) {
        e.preventDefault();
        var container = $(this).parents('.rt-tab-container');
        var nav = container.children('.rt-tab-nav');
        var content = container.children(".rt-tab-content");
        var $this, $id;
        $this = $(this);
        $id = $this.attr('href');
        content.hide();
        nav.find('li').removeClass('active');
        $this.parent().addClass('active');
        container.find($id).show();
    });

    // imageSize();
    // $("#rt-feature-img-size").on('change', function () {
    //     imageSize();
    // });

    // function imageSize() {
    //     var size = $("#rt-feature-img-size").val();
    //     if (size == "pfp_custom") {
    //         $(".rt-custom-image-size-wrap").show();
    //     } else {
    //         $(".rt-custom-image-size-wrap").hide();
    //     }
    // }

    /* Settings */
    $("#tlp-portfolio-settings").on('click', '#tlpSaveButton', function (e) {
        e.preventDefault();
        var button = $(this),
            form = button.closest('form'),
            responseHolder = $('#response'),
            arg = form.serialize();
        responseHolder.hide();
        AjaxCall(button, 'tlpPortSettings', arg, function (data) {
            if (data.error) {
                responseHolder.removeClass('error');
                responseHolder.show('slow').text(data.msg);
            } else {
                responseHolder.addClass('error');
                responseHolder.show('slow').text(data.msg);
            }
        });
        return false;
    });

    /* ShortCode preview */
    function useEffectImageSize() {
        /* custom image size jquery */
        var fImageSize = $("#pfp_image_size").val();
        if (fImageSize == "pfp_custom") {
            $("#pfp_custom_image_size_holder").show();
        } else {
            $("#pfp_custom_image_size_holder").hide();
        }
    }

    function useEffectDetailLink() {
        var item = $(".rt-field-wrapper.pfp-detail-page-link-item");
        if ($("#pfp_detail_page_link").is(":checked")) {
            item.show();
        } else {
            item.hide();
        }
    }

    function useEffectDetailLinkType() {
        if ($("#pfp_detail_page_link").is(":checked")) {
            var val = $("#pfp_detail_page_link_type").find("input[name=pfp_detail_page_link_type]:checked").val(),
                item = $("#pfp_link_target_holder");
            if (val == "external_link") {
                item.show();
            } else {
                item.hide();
            }
        } else {
            $(".rt-field-wrapper.pfp-detail-page-link-item").hide();
        }
    }

    function useEffectLayout() {
        var layout = $("#rtpfp-pfp_layout_type input[name=pfp_layout_type]:checked").val(),
            // layout_type = $("#rtpfp-pfp_layout input[name=pfp_layout]:checked").val(),
            isIsotope = false,
            isCarousel = false;
            // console.log( layout );
        if (layout) {
            isCarousel = layout.match(/^carousel/i);
            isIsotope = layout.match(/^isotope/i);
            $("#pfp_carousel_autoplay_timeout_holder").hide();
            if (isCarousel) {
                $(".rt-field-wrapper.pfp-carousel-item").show();
                $(".rt-field-wrapper.pfp-isotope-item,.rt-field-wrapper.pagination, #pfp_column_holder").hide();

                var autoPlay = $("#pfp_carousel_options-autoplay").prop("checked");
                if (autoPlay) {
                    $("#pfp_carousel_autoplay_timeout_holder").show();
                }

            } else if (isIsotope) {
                $(".rt-field-wrapper.pfp-isotope-item,#pfp_column_holder").show();
                $(".rt-field-wrapper.pfp-carousel-item").hide();
                $(".rt-field-wrapper.pagination, .rt-field-wrapper.pfp-pagination-item").hide();
            } else {
                $(".rt-field-wrapper.pfp-isotope-item,.rt-field-wrapper.pfp-carousel-item").hide();
                $(".rt-field-wrapper.pagination, #pfp_column_holder").show();
            }
        }
        if ( ! layout ) {
            $("#rtpfp-pfp_layout_type input[name=pfp_layout_type]").first().prop('checked', true);
            $("#rtpfp-pfp_layout input[name=pfp_layout]").first().prop('checked', true);
            $(".rt-field-wrapper.pfp-carousel-item").hide();
            $(".rt-field-wrapper.pfp-isotope-item").hide();
            $("#pfp_carousel_autoplay_timeout_holder").hide();
            $("#pfp_layout_holder").show();
            RTP_FPuselayoutType();
        }


        if ($("#pfp_pagination").is(':checked') && ! ( isCarousel || isIsotope ) ) {
            $(".rt-field-wrapper.pfp-pagination-item").show();
        } else {
            $(".rt-field-wrapper.pfp-pagination-item").hide();
        }

        useEffectImageSize();
        useEffectDetailLink();
        useEffectDetailLinkType();
    }

    function AjaxCall(element, action, arg, handle) {
        var data;
        if (action) data = "action=" + action;
        if (arg) data = arg + "&action=" + action;
        if (arg && !action) data = arg;
        var n = data.search(tlp_portfolio_obj.nonceId);
        if (n < 0) {
            data = data + "&" + tlp_portfolio_obj.nonceId + "=" + tlp_portfolio_obj.nonce;
        }
        $.ajax({
            type: "post",
            url: ajaxurl,
            data: data,
            beforeSend: function () {
                $("<span class='tlp_loading'></span>").insertAfter(element);
            },
            success: function (data) {
                $(".tlp_loading").remove();
                handle(data);
            }
        });
    }

    function TlpPortfolioPreviewAjaxCall(element, action, arg, callack) {
        var data;
        if (action) data = "action=" + action;
        if (arg) data = arg + "&action=" + action;
        if (arg && !action) data = arg;

        var n = data.search(tlp_portfolio_obj.nonceId);
        if (n < 0) {
            data = data + "&" + tlp_portfolio_obj.nonceId + "=" + tlp_portfolio_obj.nonce;
        }
        var previewHolder = $('#pfp-preview-container'),
            response = $('#pfp-response .spinner');
        $.ajax({
            type: "post",
            url: tlp_portfolio_obj.ajaxurl,
            data: data,
            beforeSend: function () {
                previewHolder.addClass('loading');
                response.addClass('is-active');
            },
            success: function (data) {
                previewHolder.removeClass('loading');
                response.removeClass('is-active');
                callack(data);
            }
        });
    }

    function renderTlpPortfolioPreview() {
        var target = $('#tlp_portfolio_sc_settings_meta');
        if (target.length) {
            var data = target.find('input[name],select[name],textarea[name]').serialize();
            // Add Shortcode ID
            data = data + '&' + $.param({'sc_id': $('#post_ID').val() || 0});
            TlpPortfolioPreviewAjaxCall(null, 'tlp_portfolio_preview_ajax_call', data, function (data) {
                if (!data.error) {
                    $("#pfp-preview-container").html(data.data);
                    initTlpPortfolio();
                    initRtppCaroselPortfolio();
                }
            });
        }
    }
    
    /**
     * Layout type selector
     */
    function RTP_FPuselayoutType(){
        var layout_type = $("#rtpfp-pfp_layout_type input[name=pfp_layout_type]:checked");
        var layout_type_value = layout_type.val();
        $('#rtpfp-pfp_layout .radio-image').hide();
        var selector = ".radio-image." + layout_type_value ;
        if( ! layout_type_value ){
            var selectChildByValue = $("#rtpfp-pfp_layout input[name=pfp_layout]:checked") ;
            var ownParent = selectChildByValue.parent('.radio-image');
            var parentId = ownParent.attr('data-type');
            $("#rtpfp-pfp_layout_type input[id=" + parentId + "]").prop('checked', true);
            selector = ".radio-image." + parentId ;
            if( ! selectChildByValue.val() ){
                $('#pfp_layout_holder').hide();
                // console.log( 'All is well ' + selectChildByValue );
            }else{
                $('#pfp_layout_holder').show();
            }
        }
        $(selector).show();
    }

    $("#pfp_image_size").on('change', function () {
        useEffectImageSize();
    });
    $("#rtpfp-pfp_layout_type input[name=pfp_layout_type]").on('change', function () {
        $('#pfp_layout_holder').show();
        RTP_FPuselayoutType();
        useEffectLayout();

    });

    // $("#rtpfp-pfp_layout input[name=pfp_layout]").on('change', function () {
    //     useEffectLayout();
    // });

    $("#pfp_pagination").on('change', function () {
        if (this.checked) {
            $(".rt-field-wrapper.pfp-pagination-item").show();
        } else {
            $(".rt-field-wrapper.pfp-pagination-item").hide();
        }
    });

    $("#pfp_carousel_options-autoplay").on('change', function () {
        if (this.checked) {
            $("#pfp_carousel_autoplay_timeout_holder").show();
        } else {
            $("#pfp_carousel_autoplay_timeout_holder").hide();
        }
    });

    $("#pfp_detail_page_link").on('change', function () {
        useEffectDetailLink();
    });
    $("#pfp_detail_page_link_type").on("click", "input[type='radio']", function () {
        useEffectDetailLinkType();
    });

    $("#tlp_portfolio_sc_settings_meta").on('change', 'select,input', function () {
        renderTlpPortfolioPreview();
    });
    $("#tlp_portfolio_sc_settings_meta").on("input propertychange", function () {
        renderTlpPortfolioPreview();
    });
    RTP_FPuselayoutType();
    useEffectLayout();
    renderTlpPortfolioPreview();

})(jQuery);
