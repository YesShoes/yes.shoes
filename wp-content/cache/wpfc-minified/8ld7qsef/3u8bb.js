"use strict";function after_load_ajax_list(a,e){var n="undefined"!=typeof e?e:!1;a("body").trigger("nasa_after_load_ajax_first",[n]),a("body").trigger("nasa_init_topbar_categories"),init_widgets(a),_eventMore||a("body").trigger("nasa_parallax_breadcrum"),init_wishlist_icons(a),init_compare_icons(a),_eventMore=!1,a("body").trigger("nasa_after_load_ajax")}function nasa_tab_slide_style(a,e,n){n=n?n:500,a(e).find(".nasa-slide-tab").length<=0&&a(e).append('<li class="nasa-slide-tab"></li>');var s=a(e).find(".nasa-slide-tab"),t=a(e).find(".nasa-tab.active");a(e).find(".nasa-tab-icon").length&&a(e).find(".nasa-tab > a").css({padding:"15px 30px"});var i=parseInt(a(e).css("border-top-width"));i=i?i:0;var o=a(t).position();a(s).show().animate({height:a(t).height()+2*i,width:a(t).width()+2*i,top:o.top-i,left:o.left-i},n)}function load_compare(a){if(a("#nasa-compare-sidebar-content").length&&!_compare_init&&(_compare_init=!0,"undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url)){var e=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_load_compare"),n=a(".nasa-wrap-table-compare").length?!0:!1;a.ajax({url:e,type:"post",dataType:"json",cache:!1,data:{compare_table:n},beforeSend:function(){},success:function(e){"undefined"!=typeof e.success&&"1"===e.success&&a("#nasa-compare-sidebar-content").replaceWith(e.content),a(".nasa-compare-list-bottom").find(".nasa-loader").remove()},error:function(){}})}}function add_compare_product(a,e){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var n=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_add_compare_product"),s=e(".nasa-wrap-table-compare").length?!0:!1;e.ajax({url:n,type:"post",dataType:"json",cache:!1,data:{pid:a,compare_table:s},beforeSend:function(){show_compare(e),e(".nasa-compare-list-bottom").find(".nasa-loader").length<=0&&e(".nasa-compare-list-bottom").append('<div class="nasa-loader"></div>')},success:function(n){"undefined"!=typeof n.result_compare&&"success"===n.result_compare&&(e("#nasa-compare-sidebar-content").length?"no-change"===n.mini_compare?load_compare(e):e("#nasa-compare-sidebar-content").replaceWith(n.mini_compare):"no-change"!==n.mini_compare&&e(".nasa-compare-list").length&&e(".nasa-compare-list").replaceWith(n.mini_compare),"no-change"!==n.mini_compare?(e(".nasa-mini-number.compare-number").length&&(e(".nasa-mini-number.compare-number").html(convert_count_items(e,n.count_compare)),0===n.count_compare?e(".nasa-mini-number.compare-number").hasClass("nasa-product-empty")||e(".nasa-mini-number.compare-number").addClass("nasa-product-empty"):e(".nasa-mini-number.compare-number").hasClass("nasa-product-empty")&&e(".nasa-mini-number.compare-number").removeClass("nasa-product-empty")),e(".nasa-compare-success").html(n.mess_compare),e(".nasa-compare-success").fadeIn(200),s&&e(".nasa-wrap-table-compare").replaceWith(n.result_table)):(e(".nasa-compare-exists").html(n.mess_compare),e(".nasa-compare-exists").fadeIn(200)),e('.nasa-compare[data-prod="'+a+'"]').hasClass("added")||e('.nasa-compare[data-prod="'+a+'"]').addClass("added"),e('.nasa-compare[data-prod="'+a+'"]').hasClass("nasa-added")||e('.nasa-compare[data-prod="'+a+'"]').addClass("nasa-added"),setTimeout(function(){e(".nasa-compare-success").fadeOut(200),e(".nasa-compare-exists").fadeOut(200)},2e3)),e(".nasa-compare-list-bottom").find(".nasa-loader").remove()},error:function(){}})}}function remove_compare_product(a,e){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var n=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_remove_compare_product"),s=e(".nasa-wrap-table-compare").length?!0:!1;e.ajax({url:n,type:"post",dataType:"json",cache:!1,data:{pid:a,compare_table:s},beforeSend:function(){e(".nasa-compare-list-bottom").find(".nasa-loader").length<=0&&e(".nasa-compare-list-bottom").append('<div class="nasa-loader"></div>'),e("table.nasa-table-compare tr.remove-item td.nasa-compare-view-product_"+a).length&&e("table.nasa-table-compare").css("opacity","0.3").prepend('<div class="nasa-loader"></div>')},success:function(n){"undefined"!=typeof n.result_compare&&"success"===n.result_compare&&("no-change"!==n.mini_compare&&e("#nasa-compare-sidebar-content").length?e("#nasa-compare-sidebar-content").replaceWith(n.mini_compare):"no-change"!==n.mini_compare&&e(".nasa-compare-list").length&&e(".nasa-compare-list").replaceWith(n.mini_compare),"no-change"!==n.mini_compare&&e(".nasa-compare-list").length?(e('.nasa-compare[data-prod="'+a+'"]').removeClass("added"),e('.nasa-compare[data-prod="'+a+'"]').removeClass("nasa-added"),e(".nasa-mini-number.compare-number").length&&(e(".nasa-mini-number.compare-number").html(convert_count_items(e,n.count_compare)),0===n.count_compare?e(".nasa-mini-number.compare-number").hasClass("nasa-product-empty")||e(".nasa-mini-number.compare-number").addClass("nasa-product-empty"):e(".nasa-mini-number.compare-number").hasClass("nasa-product-empty")&&e(".nasa-mini-number.compare-number").removeClass("nasa-product-empty")),e(".nasa-compare-success").html(n.mess_compare),e(".nasa-compare-success").fadeIn(200),s&&e(".nasa-wrap-table-compare").replaceWith(n.result_table)):(e(".nasa-compare-exists").html(n.mess_compare),e(".nasa-compare-exists").fadeIn(200)),setTimeout(function(){e(".nasa-compare-success").fadeOut(200),e(".nasa-compare-exists").fadeOut(200),0===n.count_compare&&e(".nasa-close-mini-compare").trigger("click")},2e3)),e("table.nasa-table-compare").find(".nasa-loader").remove(),e(".nasa-compare-list-bottom").find(".nasa-loader").remove()},error:function(){}})}}function remove_all_compare_product(a){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var e=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_remove_all_compare"),n=a(".nasa-wrap-table-compare").length?!0:!1;a.ajax({url:e,type:"post",dataType:"json",cache:!1,data:{compare_table:n},beforeSend:function(){a(".nasa-compare-list-bottom").find(".nasa-loader").length<=0&&a(".nasa-compare-list-bottom").append('<div class="nasa-loader"></div>')},success:function(e){"success"===e.result_compare&&("no-change"!==e.mini_compare&&a(".nasa-compare-list").length?(a(".nasa-compare-list").replaceWith(e.mini_compare),a(".nasa-compare").removeClass("added"),a(".nasa-compare").removeClass("nasa-added"),a(".nasa-mini-number.compare-number").length&&(a(".nasa-mini-number.compare-number").html("0"),a(".nasa-mini-number.compare-number").hasClass("nasa-product-empty")||a(".nasa-mini-number.compare-number").addClass("nasa-product-empty")),a(".nasa-compare-success").html(e.mess_compare),a(".nasa-compare-success").fadeIn(200),n&&a(".nasa-wrap-table-compare").replaceWith(e.result_table)):(a(".nasa-compare-exists").html(e.mess_compare),a(".nasa-compare-exists").fadeIn(200)),setTimeout(function(){a(".nasa-compare-success").fadeOut(200),a(".nasa-compare-exists").fadeOut(200),a(".nasa-close-mini-compare").trigger("click")},1e3)),a(".nasa-compare-list-bottom").find(".nasa-loader").remove()},error:function(){}})}}function show_compare(a){a("body").trigger("nasa_append_style_off_canvas"),a(".nasa-compare-list-bottom").length&&(a(".transparent-window").show(),a(".nasa-show-compare").length&&!a(".nasa-show-compare").hasClass("nasa-showed")&&a(".nasa-show-compare").addClass("nasa-showed"),a(".nasa-compare-list-bottom").hasClass("nasa-active")||a(".nasa-compare-list-bottom").addClass("nasa-active"))}function hide_compare(a){a(".nasa-compare-list-bottom").length&&(a(".transparent-window").fadeOut(550),a(".nasa-show-compare").length&&a(".nasa-show-compare").hasClass("nasa-showed")&&a(".nasa-show-compare").removeClass("nasa-showed"),a(".nasa-compare-list-bottom").removeClass("nasa-active"))}function nasa_single_add_to_cart(a,e,n,s,t,i,o,r){var c=a(e).parents("form.cart");if("grouped"===t)return a(c).length&&(a(c).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').length?a(c).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').val("1"):a(c).find(".nasa-custom-fields").append('<input type="hidden" name="nasa_cart_sidebar" value="1" />'),a(c).submit()),void 0;if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var d=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_single_add_to_cart"),l={product_id:n,quantity:s,product_type:t,variation_id:i,variation:o,data_wislist:r};a(c).length&&("simple"===t&&a(c).find(".nasa-custom-fields").append('<input type="hidden" name="add-to-cart" value="'+n+'" />'),l=a(c).serializeArray(),a(c).find('.nasa-custom-fields [name="add-to-cart"]').remove()),a.ajax({url:d,type:"post",dataType:"json",cache:!1,data:l,beforeSend:function(){a(e).removeClass("added"),a(e).removeClass("nasa-added"),a(e).addClass("loading")},success:function(s){if(s.error)if(a(e).hasClass("add-to-cart-grid")){var t=a(e).attr("href");window.location.href=t}else set_nasa_notice(a,s.message),a(e).removeClass("loading");else if("undefined"!=typeof s.redirect&&s.redirect)window.location.href=s.redirect;else{var i=s.fragments;if(i&&(a.each(i,function(e,n){a(e).addClass("updating"),a(e).replaceWith(n)}),a(e).hasClass("added")||a(e).addClass("added"),a(e).hasClass("nasa-added")||a(e).addClass("nasa-added")),a(".wishlist_sidebar").length&&"undefined"!=typeof s.wishlist){if(a(".wishlist_sidebar").replaceWith(s.wishlist),setTimeout(function(){init_wishlist_icons(a,!0)},350),a(".nasa-mini-number.wishlist-number").length){var o=parseInt(s.wishlistcount);a(".nasa-mini-number.wishlist-number").html(convert_count_items(a,o)),o>0?a(".nasa-mini-number.wishlist-number").removeClass("nasa-product-empty"):0!==o||a(".wishlist-number").hasClass("nasa-product-empty")||a(".nasa-mini-number.wishlist-number").addClass("nasa-product-empty")}a(".add-to-wishlist-"+n).length&&(a(".add-to-wishlist-"+n).find(".yith-wcwl-add-button").show(),a(".add-to-wishlist-"+n).find(".yith-wcwl-wishlistaddedbrowse").hide(),a(".add-to-wishlist-"+n).find(".yith-wcwl-wishlistexistsbrowse").hide())}1===a(".page-shopping-cart").length&&a.ajax({url:window.location.href,type:"get",dataType:"html",cache:!1,data:{},success:function(e){var n=a.parseHTML(e);if(1===a(".nasa-shopping-cart-form").length){var s=a(".nasa-shopping-cart-form",n),t=a(".cart_totals",n),i=a(".woocommerce-error, .woocommerce-message, .woocommerce-info",n);a(".nasa-shopping-cart-form").replaceWith(s),i.length&&a(".nasa-shopping-cart-form").before(i),a(".cart_totals").replaceWith(t)}else{var o=a(".page-shopping-cart",n);a(".page-shopping-cart").replaceWith(o)}a("body").trigger("updated_cart_totals"),a("body").trigger("updated_wc_div"),a(".nasa-shopping-cart-form").find('input[name="update_cart"]').prop("disabled",!0)}}),a("body").trigger("added_to_cart",[s.fragments,s.cart_hash,e])}}})}return!1}function load_combo_popup(a,e){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var n=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_combo_products"),s=a(e).parents(".product-item");if(!a(e).hasClass("nasaing")){a(".btn-combo-link").addClass("nasaing");var t=a(e).attr("data-prod");t&&a.ajax({url:n,type:"post",dataType:"json",cache:!1,data:{id:t,title_columns:2},beforeSend:function(){a(s).append('<div class="nasa-loader" style="top:50%"></div>'),a(s).find(".product-inner").css("opacity","0.3")},success:function(e){a.magnificPopup.open({mainClass:"my-mfp-slide-bottom nasa-combo-popup-wrap",closeMarkup:'<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="'+a('input[name="nasa-close-string"]').val()+'"></a>',items:{src:'<div class="row nasa-combo-popup nasa-combo-row comboed-row zoom-anim-dialog" data-prod="'+t+'">'+e.content+"</div>",type:"inline"},removalDelay:300,callbacks:{afterClose:function(){}}}),a("body").trigger("nasa_load_slick_slider"),setTimeout(function(){if(a(".btn-combo-link").removeClass("nasaing"),a(s).find(".nasa-loader").remove(),a(s).find(".product-inner").css("opacity","1"),"undefined"!=typeof wow_enable&&wow_enable){var e,n;a(".nasa-combo-popup").find(".product-item").each(function(){var s=a(this);e=a(s).attr("data-wow"),n=parseInt(a(s).attr("data-wow-delay")),a(s).css({visibility:"visible","animation-delay":n+"ms","animation-name":e}).addClass("animated")})}else a(".nasa-combo-popup").find(".product-item").css({visibility:"visible"})},500)},error:function(){a(".btn-combo-link").removeClass("nasaing")}})}}}function recursive_convert_item(a,e){var n=a(e).next();!a(n).length||a(n).hasClass("nasa-main")||a(n).hasClass("nasa-wrap-mains")||(a(e).find(".sub-menu").append(n),recursive_convert_item(a,e))}function convert_mega_menu(a,e){var n=a(e).clone();return a(n).find(".nav-column-links > .sub-menu > .menu-item.nasa-main").length&&(a(n).find(".nav-column-links > .sub-menu > .menu-item.nasa-main").each(function(){var e=a(this),n=a(e).parent();a(n).find(".nasa-wrap-mains").length<1&&a(n).append('<li class="nasa-wrap-mains hidden-tag"></li>'),a(e).hasClass("menu-item-has-children")||a(e).addClass("menu-item-has-children"),a(e).hasClass("menu-parent-item")||a(e).addClass("menu-parent-item"),a(e).find(".sub-menu").length<1&&a(e).append('<div class="nav-column-links"><ul class="sub-menu"></ul></div>'),recursive_convert_item(a,e),a(n).find(".nasa-wrap-mains").append(e)}),a(n).find(".nav-column-links > .sub-menu > .nasa-wrap-mains").each(function(){var e=a(this).parent().parent().parent();a(e).after(a(this).html()),a(this).remove()})),a(n).html()}function init_menu_mobile(a,e){var n="undefined"==typeof e?!1:e;if(n&&a("#nasa-menu-sidebar-content .nasa-menu-for-mobile").remove(),a("body").trigger("nasa_before_init_menu_mobile"),a("#nasa-menu-sidebar-content .nasa-menu-for-mobile").length<=0){var s=a("body").hasClass("nasa-in-mobile")?!0:!1,t="",i="";if(a(".nasa-main-menu").length){var o=a(".nasa-main-menu");i=convert_mega_menu(a,o),s&&a(o).remove()}else a(".header-type-builder .header-nav").length&&a(".header-type-builder .header-nav").each(function(){var e=a(this);i=convert_mega_menu(a,e)});if(a(".nasa-vertical-header .vertical-menu-wrapper").length){var r=a(".nasa-vertical-header .vertical-menu-wrapper"),c=convert_mega_menu(a,r),d=a(".nasa-vertical-header .nasa-title-vertical-menu").html(),l='<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-parent-item default-menu root-item nasa-menu-none-event li_accordion"><a href="javascript:void(0);">'+d+'</a><div class="nav-dropdown-mobile"><ul class="sub-menu">'+c+"</ul></div></li>";a(".nasa-vertical-header").hasClass("nasa-focus-menu")?t=l+i:t+=i+l,s&&a(".nasa-vertical-header").remove()}else t=i;a("#heading-menu-mobile").length&&(t='<li class="menu-item root-item menu-item-heading">'+a("#heading-menu-mobile").html()+"</li>"+t),a(".nasa-shortcode-menu.vertical-menu").length&&a(".nasa-shortcode-menu.vertical-menu").each(function(){var e=a(this),n=a(e).find(".vertical-menu-wrapper").html(),i=a(e).find(".section-title").html();i=a("#nasa-menu-sidebar-content").hasClass("nasa-light-new")?'<a href="javascript:void(0);">'+i+"</a>":'<h5 class="menu-item-heading margin-top-35 margin-bottom-10">'+i+"</h5>";var o='<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-parent-item default-menu root-item nasa-menu-none-event li_accordion">'+i+'<div class="nav-dropdown-mobile"><ul class="sub-menu">'+n+"</ul></div></li>";t+=o,s&&a(e).remove()}),a(".nasa-topbar-menu").length&&(t+=a(".nasa-topbar-menu").html(),s&&a(".nasa-topbar-menu").remove()),a("#tmpl-nasa-mobile-account").length&&(t+=a("#nasa-menu-sidebar-content").hasClass("nasa-light-new")&&a("#tmpl-nasa-mobile-account").find(".nasa-menu-item-account").length?'<li class="menu-item root-item menu-item-account menu-item-has-children root-item">'+a("#tmpl-nasa-mobile-account").find(".nasa-menu-item-account").html()+"</li>":'<li class="menu-item root-item menu-item-account">'+a("#tmpl-nasa-mobile-account").html()+"</li>",a("#tmpl-nasa-mobile-account").remove());var m="";a(".header-switch-languages").length&&(m=a(".header-switch-languages").html(),s&&a(".header-switch-languages").remove()),a(".header-multi-languages").length&&(m=a(".header-multi-languages").html(),s&&a(".header-multi-languages").remove()),t=a("#nasa-menu-sidebar-content").hasClass("nasa-light-new")?'<ul id="mobile-navigation" class="header-nav nasa-menu-accordion nasa-menu-for-mobile">'+t+m+"</ul>":'<ul id="mobile-navigation" class="header-nav nasa-menu-accordion nasa-menu-for-mobile">'+m+t+"</ul>",a("#nasa-menu-sidebar-content #mobile-navigation").length?a("#nasa-menu-sidebar-content #mobile-navigation").replaceWith(t):a("#nasa-menu-sidebar-content .nasa-mobile-nav-wrap").append(t);var p=a("#nasa-menu-sidebar-content #mobile-navigation");if(a(p).find(".nasa-select-currencies").length){var u=a(p).find(".nasa-select-currencies");if(a(u).find(".wcml_currency_switcher").length){var h=a(u).find(".wcml_currency_switcher").attr("class");h+=" menu-item-has-children root-item li_accordion";var _=a(u).find(".wcml-cs-active-currency").clone();a(_).addClass(h),a(_).find(".wcml-cs-submenu").addClass("sub-menu"),a(p).find(".nasa-select-currencies").replaceWith(_)}a("body").trigger("nasa_after_render_currencies_switcher",[u])}a(p).find(".root-item > a").removeAttr("style"),a(p).find(".nav-dropdown").attr("class","nav-dropdown-mobile").removeAttr("style"),a(p).find(".nav-column-links").addClass("nav-dropdown-mobile"),a(p).find(".sub-menu").each(function(){a(this).parent(".nav-dropdown-mobile").length||a(this).wrap('<div class="nav-dropdown-mobile"></div>')}),a(p).find(".nav-dropdown-mobile").find(".sub-menu").removeAttr("style"),a(p).find("hr.hr-nasa-megamenu").remove(),a(p).find("li").each(function(){a(this).hasClass("menu-item-has-children")&&(a(this).addClass("li_accordion"),a(this).hasClass("current-menu-ancestor")||a(this).hasClass("current-menu-parent")||a(this).hasClass("current-menu-item")?(a(this).addClass("active"),a(this).prepend('<a href="javascript:void(0);" class="accordion"></a>')):a(this).prepend('<a href="javascript:void(0);" class="accordion"></a>').find(">.nav-dropdown-mobile").hide())}),a(p).find("a").removeAttr("style"),a("body").trigger("nasa_after_load_mobile_menu")}}function position_menu_mobile(a){if(a("#nasa-menu-sidebar-content").length&&a("#mobile-navigation").length&&a("#mobile-navigation").length&&"1"!==a("#mobile-navigation").attr("data-show")){a("#nasa-menu-sidebar-content").removeClass("nasa-active");var e=a("#wpadminbar").length?a("#wpadminbar").height():0;e>0&&a("#nasa-menu-sidebar-content").css({top:e})}}function init_mini_wishlist(a){if(a('input[name="nasa_wishlist_cookie_name"]').length){var e=get_wishlist_ids(a);if(e.length&&a(".nasa-mini-number.wishlist-number").length){var n=e.length;a(".nasa-mini-number.wishlist-number").html(convert_count_items(a,n)),n>0&&a(".nasa-mini-number.wishlist-number").removeClass("nasa-product-empty"),0!==n||a(".wishlist-number").hasClass("nasa-product-empty")||a(".nasa-mini-number.wishlist-number").addClass("nasa-product-empty")}}}function init_wishlist_icons(a,e){var n="undefined"==typeof e?!1:e;if(a('input[name="nasa_wishlist_cookie_name"]').length){var s=get_wishlist_ids(a);s.length&&a(".btn-wishlist").each(function(){var e=a(this),t=a(e).attr("data-prod");-1!==s.indexOf(t)?(a(e).hasClass("nasa-added")||a(e).addClass("nasa-added"),a(e).find(".wishlist-icon").hasClass("added")||a(e).find(".wishlist-icon").addClass("added")):n&&(a(e).hasClass("nasa-added")&&a(e).removeClass("nasa-added"),a(e).find(".wishlist-icon").hasClass("added")&&a(e).find(".wishlist-icon").removeClass("added"))})}else if(a(".wishlist_sidebar .wishlist_table").length||a(".wishlist_sidebar .nasa_yith_wishlist_premium-wrap .wishlist_table").length){var s=[];a(".wishlist_sidebar .wishlist_table .nasa-tr-wishlist-item").length&&a(".wishlist_sidebar .wishlist_table .nasa-tr-wishlist-item").each(function(){s.push(a(this).attr("data-row-id"))}),a(".wishlist_sidebar .nasa_yith_wishlist_premium-wrap .wishlist_table tbody tr").length&&a(".wishlist_sidebar .nasa_yith_wishlist_premium-wrap .wishlist_table tbody tr").each(function(){s.push(a(this).attr("data-row-id"))}),a(".btn-wishlist").each(function(){var e=a(this),t=a(e).attr("data-prod");-1!==s.indexOf(t)?(a(e).hasClass("nasa-added")||a(e).addClass("nasa-added"),a(e).find(".wishlist-icon").hasClass("added")||a(e).find(".wishlist-icon").addClass("added")):n&&(a(e).hasClass("nasa-added")&&a(e).removeClass("nasa-added"),a(e).find(".wishlist-icon").hasClass("added")&&a(e).find(".wishlist-icon").removeClass("added"))})}}function init_compare_icons(a,e){var n="undefined"!=typeof e?e:!1,s=get_compare_ids(a);if(n&&a(".nasa-mini-number.compare-number").length){var t=s.length;a(".nasa-mini-number.compare-number").html(convert_count_items(a,t)),0>=t?a(".nasa-mini-number.compare-number").hasClass("nasa-product-empty")||a(".nasa-mini-number.compare-number").addClass("nasa-product-empty"):a(".nasa-mini-number.compare-number").removeClass("nasa-product-empty")}s.length&&a(".btn-compare").length&&a(".btn-compare").each(function(){var e=a(this),n=a(e).attr("data-prod");-1!==s.indexOf(n)?(a(e).hasClass("added")||a(e).addClass("added"),a(e).hasClass("nasa-added")||a(e).addClass("nasa-added")):(a(e).removeClass("added"),a(e).removeClass("nasa-added"))})}function after_added_to_cart(a){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var e=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_after_add_to_cart");a.ajax({url:e,type:"post",dataType:"json",cache:!1,data:{nasa_action:"nasa_after_add_to_cart"},beforeSend:function(){a("body").trigger("nasa_append_style_off_canvas")},success:function(e){"1"===e.success?(a(".nasa-after-add-to-cart-popup").length?(a(".nasa-after-add-to-cart-popup .nasa-after-add-to-cart-wrap").html(e.content),a(".nasa-after-add-to-cart-popup .nasa-slick-slider").length&&after_load_ajax_list(a,!1)):a.magnificPopup.open({items:{src:'<div class="nasa-after-add-to-cart-popup nasa-bot-to-top"><div class="nasa-after-add-to-cart-wrap">'+e.content+"</div></div>",type:"inline"},closeMarkup:'<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="'+a('input[name="nasa-close-string"]').val()+'"></a>',callbacks:{open:function(){a(".nasa-after-add-to-cart-popup .nasa-slick-slider").length&&after_load_ajax_list(a,!1)},beforeClose:function(){this.st.removalDelay=350}}}),setTimeout(function(){a(".after-add-to-cart-shop_table").addClass("shop_table"),a(".nasa-table-wrap").addClass("nasa-active")},100),a(".black-window").trigger("click")):a.magnificPopup.close(),a(".nasa-after-add-to-cart-wrap").removeAttr("style"),a(".nasa-after-add-to-cart-wrap").removeClass("processing"),setTimeout(function(){init_shipping_free_notification(a)},300)},error:function(){a.magnificPopup.close()}})}}function reload_mini_cart(a){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var e=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_reload_fragments");a.ajax({url:e,type:"post",dataType:"json",cache:!1,data:{time:(new Date).getTime()},success:function(e){e&&e.fragments&&(a.each(e.fragments,function(e,n){a(e).length&&a(e).replaceWith(n)}),a("body").trigger("added_to_cart",[e.fragments,e.cart_hash,!1]),a("body").trigger("wc_fragments_refreshed"),init_shipping_free_notification(a)),a("#cart-sidebar").find(".nasa-loader").remove()},error:function(){a(document.body).trigger("wc_fragments_ajax_error"),a("#cart-sidebar").find(".nasa-loader").remove()}})}}function init_shipping_free_notification(a,e){if(a(".nasa-total-condition").length){var n="undefined"!=typeof e?e:!1;a("form.nasa-shopping-cart-form").length&&a("#cart-sidebar .nasa-total-condition").length&&a("#cart-sidebar .nasa-total-condition").remove(),a(".nasa-total-condition").each(function(){if(!a(this).hasClass("nasa-active")){a(this).addClass("nasa-active");var e=a(this).attr("data-per");a(this).find(".nasa-subtotal-condition").css({width:e+"%"}),e>=100?(a(this).parents(".nasa-total-condition-wrap").addClass("free"),_confetti_run||(_confetti_run=!0,n&&a("body").trigger("nasa_confetti_restart",[2500]))):_confetti_run=!1}})}}function init_widgets(a){a(".widget").length&&!a("body").hasClass("nasa-disable-toggle-widgets")&&a(".widget").each(function(){var e=a(this);if(!a(e).hasClass("nasa-inited")){var n=a(e).attr("id"),s="";if(a(e).find(".widget-title").length&&(s=a(e).find(".widget-title").clone(),a(e).find(".widget-title").remove()),n&&""!==s){var t=a.cookie(n),i='<a href="javascript:void(0);" class="nasa-toggle-widget"></a>',o='<div class="nasa-open-toggle"></div>';"hide"===t&&(i='<a href="javascript:void(0);" class="nasa-toggle-widget nasa-hide"></a>',o='<div class="nasa-open-toggle widget-hidden"></div>'),a(e).wrapInner(o),a(e).prepend(i),a(e).prepend(s)}a(e).addClass("nasa-inited")}})}function init_nasa_notices(a){a(".woocommerce-notices-wrapper").length&&a(".woocommerce-notices-wrapper").each(function(){var e=a(this);if(a(e).find(".cart-empty").length){var n=a(e).find(".cart-empty");a(e).after(n)}a(e).find("*").length&&a(e).find(".nasa-close-notice").length<=0&&a(e).append('<a class="nasa-close-notice" href="javascript:void(0);"></a>')})}function set_nasa_notice(a,e){a(".woocommerce-notices-wrapper").length<=0&&a("body").append('<div class="woocommerce-notices-wrapper"></div>'),a(".woocommerce-notices-wrapper").html(e),init_nasa_notices(a)}function get_compare_ids(a){if(a('input[name="nasa_woocompare_cookie_name"]').length){var e=a('input[name="nasa_woocompare_cookie_name"]').val(),n=a.cookie(e);return n&&(n=n.replace("[","").replace("]","").split(",").map(String),1===n.length&&!n[0])?[]:"undefined"!=typeof n&&n.length?n:[]}return[]}function get_wishlist_ids(a){if(a('input[name="nasa_wishlist_cookie_name"]').length){var e=a('input[name="nasa_wishlist_cookie_name"]').val(),n=a.cookie(e);return n&&(n=n.replace("[","").replace("]","").split(",").map(String),1===n.length&&!n[0])?[]:"undefined"!=typeof n&&n.length?n:[]}return[]}function load_wishlist(a){if(a("#nasa-wishlist-sidebar-content").length&&!_wishlist_init&&(_wishlist_init=!0,"undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url)){var e=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_load_wishlist");a.ajax({url:e,type:"post",dataType:"json",cache:!1,data:{},beforeSend:function(){},success:function(e){if("undefined"!=typeof e.success&&"1"===e.success&&(a("#nasa-wishlist-sidebar-content").replaceWith(e.content),a(".nasa-tr-wishlist-item.item-invisible").length)){var n=[];a(".nasa-tr-wishlist-item.item-invisible").each(function(){var e=a(this).attr("data-row-id");e&&n.push(e),a(this).remove()});var s=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%","nasa_remove_wishlist_hidden");a.ajax({url:s,type:"post",dataType:"json",cache:!1,data:{product_ids:n},beforeSend:function(){},success:function(e){if("undefined"!=typeof e.success&&"1"===e.success){var n=parseInt(e.count);a(".nasa-mini-number.wishlist-number").html(convert_count_items(a,n)),n>0?a(".nasa-mini-number.wishlist-number").removeClass("nasa-product-empty"):0!==n||a(".nasa-mini-number.wishlist-number").hasClass("nasa-product-empty")||a(".nasa-mini-number.wishlist-number").addClass("nasa-product-empty")}},error:function(){}})}},error:function(){}})}}function nasa_process_wishlist(a,e,n){if("undefined"!=typeof nasa_ajax_params&&"undefined"!=typeof nasa_ajax_params.wc_ajax_url){var s=nasa_ajax_params.wc_ajax_url.toString().replace("%%endpoint%%",n),t={product_id:e};a(".widget_shopping_wishlist_content").length&&(t.show_content="1"),a.ajax({url:s,type:"post",dataType:"json",cache:!1,data:t,beforeSend:function(){a(".nasa-close-notice").length&&a(".nasa-close-notice").trigger("click"),"undefined"!=typeof _nasa_clear_notice_wishlist&&clearTimeout(_nasa_clear_notice_wishlist)},success:function(s){if("undefined"!=typeof s.success&&"1"===s.success){var t=parseInt(s.count);a(".nasa-mini-number.wishlist-number").html(convert_count_items(a,t)),t>0?a(".nasa-mini-number.wishlist-number").removeClass("nasa-product-empty"):0!==t||a(".nasa-mini-number.wishlist-number").hasClass("nasa-product-empty")||a(".nasa-mini-number.wishlist-number").addClass("nasa-product-empty"),"nasa_add_to_wishlist"===n&&a('.btn-wishlist[data-prod="'+e+'"]').each(function(){a(this).hasClass("nasa-added")||a(this).addClass("nasa-added")}),"nasa_remove_from_wishlist"===n&&a('.btn-wishlist[data-prod="'+e+'"]').removeClass("nasa-added"),a(".widget_shopping_wishlist_content").length&&"undefined"!=typeof s.content&&s.content&&a(".widget_shopping_wishlist_content").replaceWith(s.content),"undefined"!=typeof s.mess&&s.mess&&set_nasa_notice(a,s.mess),_nasa_clear_notice_wishlist=setTimeout(function(){a(".nasa-close-notice").length&&a(".nasa-close-notice").trigger("click")},5e3),a("body").trigger("nasa_processed_wishlist",[e,n])}a(".btn-wishlist").removeClass("nasa-disabled")},error:function(){a(".btn-wishlist").removeClass("nasa-disabled")}})}}function convert_count_items(a,e){var n=parseInt(e);return a('input[name="nasa_less_total_items"]').length&&"1"===a('input[name="nasa_less_total_items"]').val()?n>9?"9+":n.toString():n.toString()}function animate_scroll_to_top(a,e,n){var s="undefined"==typeof n?500:n,t=0;"undefined"!=typeof e&&e&&a(e).length&&(t=a(e).offset().top),t&&(a("body").find(".nasa-header-sticky").length&&a(".sticky-wrapper").length&&(t-=100),a("#wpadminbar").length&&(t-=a("#wpadminbar").height()),t-=10),a("html, body").animate({scrollTop:t},s)}function init_accordion(a){a(".nasa-accordions-content .nasa-accordion-title a").length&&a(".nasa-accordions-content").each(function(){a(this).hasClass("nasa-inited")||(a(this).addClass("nasa-inited"),a(this).hasClass("nasa-accodion-first-hide")?(a(this).find(".nasa-accordion.first").removeClass("active"),a(this).find(".nasa-panel.first").removeClass("active"),a(this).removeClass("nasa-accodion-first-hide")):a(this).find(".nasa-panel.first.active").slideDown(200))})}function init_bottom_bar_mobile(a){if(a(".top-bar-wrap-type-1").length&&a("body").addClass("nasa-top-bar-in-mobile"),a("#tmpl-nasa-bottom-bar").length){var e=a("#tmpl-nasa-bottom-bar").html();a("#tmpl-nasa-bottom-bar").replaceWith(e)}a(".toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar").length||a(".dokan-single-store").length&&a(".dokan-store-sidebar").length?a(".nasa-bot-item.nasa-bot-item-sidebar").removeClass("hidden-tag"):a(".nasa-bot-item.nasa-bot-item-search").removeClass("hidden-tag");var n=a(".nasa-bottom-bar-icons .nasa-bot-item").length-a(".nasa-bottom-bar-icons .nasa-bot-item.hidden-tag").length;n&&a(".nasa-bottom-bar-icons").addClass("nasa-"+n.toString()+"-columns"),a(".nasa-bottom-bar-icons").hasClass("nasa-active")||(a(".nasa-bottom-bar-icons").addClass("nasa-active"),a("body").css({"padding-bottom":a(".nasa-bottom-bar-icons").outerHeight()}))}var _eventMore=!1,_compare_init=!1,_wishlist_init=!1,_nasa_clear_notice_wishlist;