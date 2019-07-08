<div id="responsive-menu-container" class="slide-left" >
    <div id="responsive-menu-wrapper">
        <div class="nav">
            <div class="col-2">
                <a class="nav-link header-search-button" href="javascriptO:;void" id="mobile-search-button"></a>
			</div>    
			<div class="col-8">
				
			</div>    
			<div class="col-2">
                <?php get_template_part( 'partials/responsive-menu/button' );?>
			</div>    
        </div>
        <div class="header-logo">
            <?php get_template_part( 'partials/header-logo' );?>
        </div>
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'mobile-mega-menu',
                    'menu_class'     => 'responsive-menu nav-item',
                    'items_wrap'     => '<ul id="%1$s" class="navbar-nav">%3$s</ul>',
                )
            );
        ?>   
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'mobile-mega-menu-secondary',
                    'menu_class'     => 'responsive-menu nav-item',
                    'items_wrap'     => '<ul id="%1$s" class="navbar-nav">%3$s</ul>',
                )
            );
        ?>   
        <?php if(is_user_logged_in()){?>
        <ul class="navbar-nav" id="wc-logout">
            <li class="menu-item">
                <a href="<?=wc_logout_url()?>" class="dashicons-upload"><?php  _e( 'Logout', 'woocommerce' )?></a>
            </li>
        </ul>
        <?php }?>
    </div>
</div>
<script>
(function ($, root, undefined) {
	$(function () {
		'use strict';
		$(document).ready(function() {
            var ResponsiveMenu = {
                trigger: '.responsive-menu-button',
                animationSpeed: 500,
                breakpoint: 80000,
                pushButton: 'off',
                animationType: 'slide',
                animationSide: 'left',
                pageWrapper: '',
                isOpen: false,
                triggerTypes: 'click',
                activeClass: 'is-active',
                container: '#responsive-menu-container',
                openClass: 'responsive-menu-open',
                accordion: 'off',
                activeArrow: '▲',
                inactiveArrow: '▼',
                wrapper: '#responsive-menu-wrapper',
                closeOnBodyClick: 'off',
                closeOnLinkClick: 'off',
                itemTriggerSubMenu: 'off',
                linkElement: '.responsive-menu-item-link',
                subMenuTransitionTime: 200,
                openMenu: function() {
                    $(this.trigger).addClass(this.activeClass);
                    $('html').addClass(this.openClass);
                    $('.responsive-menu-button-icon-active').hide();
                    $('.responsive-menu-button-icon-inactive').show();
                    this.setButtonTextOpen();
                    this.setWrapperTranslate();
                    this.isOpen = true;
                },
                closeMenu: function() {
                    $(this.trigger).removeClass(this.activeClass);
                    $('html').removeClass(this.openClass);
                    $('.responsive-menu-button-icon-inactive').hide();
                    $('.responsive-menu-button-icon-active').show();
                    this.setButtonText();
                    this.clearWrapperTranslate();
                    this.isOpen = false;
                },
                setButtonText: function() {
                    if($('.responsive-menu-button-text-open').length > 0 && $('.responsive-menu-button-text').length > 0) {
                        $('.responsive-menu-button-text-open').hide();
                        $('.responsive-menu-button-text').show();
                    }
                },
                setButtonTextOpen: function() {
                    if($('.responsive-menu-button-text').length > 0 && $('.responsive-menu-button-text-open').length > 0) {
                        $('.responsive-menu-button-text').hide();
                        $('.responsive-menu-button-text-open').show();
                    }
                },
                triggerMenu: function() {
                    this.isOpen ? this.closeMenu() : this.openMenu();
                },
                triggerSubArrow: function(subarrow) {
                    var sub_menu = $(subarrow).parent().siblings('.responsive-menu-submenu');
                    var self = this;
                    if(this.accordion == 'on') {
                        /* Get Top Most Parent and the siblings */
                        var top_siblings = sub_menu.parents('.responsive-menu-item-has-children').last().siblings('.responsive-menu-item-has-children');
                        var first_siblings = sub_menu.parents('.responsive-menu-item-has-children').first().siblings('.responsive-menu-item-has-children');
                        /* Close up just the top level parents to key the rest as it was */
                        top_siblings.children('.responsive-menu-submenu').slideUp(self.subMenuTransitionTime, 'linear').removeClass('responsive-menu-submenu-open');
                        /* Set each parent arrow to inactive */
                        top_siblings.each(function() {
                            $(this).find('.responsive-menu-subarrow').first().html(self.inactiveArrow);
                            $(this).find('.responsive-menu-subarrow').first().removeClass('responsive-menu-subarrow-active');
                        });
                        /* Now Repeat for the current item siblings */
                        first_siblings.children('.responsive-menu-submenu').slideUp(self.subMenuTransitionTime, 'linear').removeClass('responsive-menu-submenu-open');
                        first_siblings.each(function() {
                            $(this).find('.responsive-menu-subarrow').first().html(self.inactiveArrow);
                            $(this).find('.responsive-menu-subarrow').first().removeClass('responsive-menu-subarrow-active');
                        });
                    }
                    if(sub_menu.hasClass('responsive-menu-submenu-open')) {
                        sub_menu.slideUp(self.subMenuTransitionTime, 'linear').removeClass('responsive-menu-submenu-open');
                        $(subarrow).html(this.inactiveArrow);
                        $(subarrow).removeClass('responsive-menu-subarrow-active');
                    } else {
                        sub_menu.slideDown(self.subMenuTransitionTime, 'linear').addClass('responsive-menu-submenu-open');
                        $(subarrow).html(this.activeArrow);
                        $(subarrow).addClass('responsive-menu-subarrow-active');
                    }
                },
                menuHeight: function() {
                    return $(this.container).height();
                },
                menuWidth: function() {
                    return $(this.container).width();
                },
                wrapperHeight: function() {
                    return $(this.wrapper).height();
                },
                setWrapperTranslate: function() {
                    return;
                    switch(this.animationSide) {
                        case 'left':
                            translate = 'translateX(' + this.menuWidth() + 'px)'; break;
                        case 'right':
                            translate = 'translateX(-' + this.menuWidth() + 'px)'; break;
                        case 'top':
                            translate = 'translateY(' + this.wrapperHeight() + 'px)'; break;
                        case 'bottom':
                            translate = 'translateY(-' + this.menuHeight() + 'px)'; break;
                    }
                    if(this.animationType == 'push') {
                        $(this.pageWrapper).css({'transform':translate});
                        $('html, body').css('overflow-x', 'hidden');
                    }
                    if(this.pushButton == 'on') {
                        $('#responsive-menu-button').css({'transform':translate});
                    }
                },
                clearWrapperTranslate: function() {
                    var self = this;
                    if(this.animationType == 'push') {
                        $(this.pageWrapper).css({'transform':''});
                        setTimeout(function() {
                            $('html, body').css('overflow-x', '');
                        }, self.animationSpeed);
                    }
                    if(this.pushButton == 'on') {
                        $('#responsive-menu-button').css({'transform':''});
                    }
                },
                init: function() {
                    var self = this;
                    $(this.trigger).on(this.triggerTypes, function(e){
                        e.stopPropagation();
                        self.triggerMenu();
                    });
                    $(this.trigger).mouseup(function(){
                        $(self.trigger).blur();
                    });
                    $('.responsive-menu-subarrow').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        self.triggerSubArrow(this);
                    });
                    $(window).resize(function() {
                        if($(window).width() > self.breakpoint) {
                            if(self.isOpen){
                                self.closeMenu();
                            }
                        } else {
                            if($('.responsive-menu-open').length>0){
                                self.setWrapperTranslate();
                            }
                        }
                    });
                    if(this.closeOnLinkClick == 'on') {
                        $(this.linkElement).on('click', function(e) {
                            e.preventDefault();
                            /* Fix for when close menu on parent clicks is on */
                            if(self.itemTriggerSubMenu == 'on' && $(this).is('.responsive-menu-item-has-children > ' + self.linkElement)) {
                                return;
                            }
                            old_href = $(this).attr('href');
                            old_target = typeof $(this).attr('target') == 'undefined' ? '_self' : $(this).attr('target');
                            if(self.isOpen) {
                                if($(e.target).closest('.responsive-menu-subarrow').length) {
                                    return;
                                }
                                self.closeMenu();
                                setTimeout(function() {
                                    window.open(old_href, old_target);
                                }, self.animationSpeed);
                            }
                        });
                    }
                    if(this.closeOnBodyClick == 'on') {
                        $(document).on('click', 'body', function(e) {
                            if(self.isOpen) {
                                if($(e.target).closest('#responsive-menu-container').length || $(e.target).closest('#responsive-menu-button').length) {
                                    return;
                                }
                            }
                            self.closeMenu();
                        });
                    }
                    if(this.itemTriggerSubMenu == 'on') {
                        $('.responsive-menu-item-has-children > ' + this.linkElement).on('click', function(e) {
                            e.preventDefault();
                            self.triggerSubArrow($(this).children('.responsive-menu-subarrow').first());
                        });
                    }
                }
            };
            ResponsiveMenu.init();
        });
    });
})(jQuery, this);    
</script>