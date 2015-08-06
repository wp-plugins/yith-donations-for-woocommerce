<?php
/**
 * Premium Tab
 *
 * @author Your Inspiration Themes
 * @package YITH Donations for WooCommerce
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly
?>

<style>
.section{
    margin-left: -20px;
    margin-right: -20px;
    font-family: "Raleway",san-serif;
}
.section h1{
    text-align: center;
    text-transform: uppercase;
    color: #808a97;
    font-size: 35px;
    font-weight: 700;
    line-height: normal;
    display: inline-block;
    width: 100%;
    margin: 50px 0 0;
}
.section ul{
    list-style-type: disc;
    padding-left: 15px;
}
.section:nth-child(even){
    background-color: #fff;
}
.section:nth-child(odd){
    background-color: #f1f1f1;
}
.section .section-title img{
    display: table-cell;
    vertical-align: middle;
    width: auto;
    margin-right: 15px;
}
.section h2,
.section h3 {
    display: inline-block;
    vertical-align: middle;
    padding: 0;
    font-size: 24px;
    font-weight: 700;
    color: #808a97;
    text-transform: uppercase;
}

.section .section-title h2{
    display: table-cell;
    vertical-align: middle;
    line-height: 25px;
}

.section-title{
    display: table;
}

.section h3 {
    font-size: 14px;
    line-height: 28px;
    margin-bottom: 0;
    display: block;
}

.section p{
    font-size: 13px;
    margin: 25px 0;
}
.section ul li{
    margin-bottom: 4px;
}
.landing-container{
    max-width: 750px;
    margin-left: auto;
    margin-right: auto;
    padding: 50px 0 30px;
}
.landing-container:after{
    display: block;
    clear: both;
    content: '';
}
.landing-container .col-1,
.landing-container .col-2{
    float: left;
    box-sizing: border-box;
    padding: 0 15px;
}
.landing-container .col-1 img{
    width: 100%;
}
.landing-container .col-1{
    width: 55%;
}
.landing-container .col-2{
    width: 45%;
}
.premium-cta{
    background-color: #808a97;
    color: #fff;
    border-radius: 6px;
    padding: 20px 15px;
}
.premium-cta:after{
    content: '';
    display: block;
    clear: both;
}
.premium-cta p{
    margin: 7px 0;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
    width: 60%;
}
.premium-cta a.button{
    border-radius: 6px;
    height: 60px;
    float: right;
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/upgrade.png) #ff643f no-repeat 13px 13px;
    border-color: #ff643f;
    box-shadow: none;
    outline: none;
    color: #fff;
    position: relative;
    padding: 9px 50px 9px 70px;
}
.premium-cta a.button:hover,
.premium-cta a.button:active,
.premium-cta a.button:focus{
    color: #fff;
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/upgrade.png) #971d00 no-repeat 13px 13px;
    border-color: #971d00;
    box-shadow: none;
    outline: none;
}
.premium-cta a.button:focus{
    top: 1px;
}
.premium-cta a.button span{
    line-height: 13px;
}
.premium-cta a.button .highlight{
    display: block;
    font-size: 20px;
    font-weight: 700;
    line-height: 20px;
}
.premium-cta .highlight{
    text-transform: uppercase;
    background: none;
    font-weight: 800;
    color: #fff;
}

.section.one{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/01-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.two{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/02-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.three{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/03-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.four{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/04-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.five{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/05-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.six{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/06-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.seven{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/07-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.eight{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/08-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.nine{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/09-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.ten{
    background: url(<?php echo YWCDS_ASSETS_URL ?>images/10-bg.png) no-repeat #fff; background-position: 85% 75%
}


@media (max-width: 768px) {
    .section{margin: 0}
    .premium-cta p{
        width: 100%;
    }
    .premium-cta{
        text-align: center;
    }
    .premium-cta a.button{
        float: none;
    }
}

@media (max-width: 480px){
    .wrap{
        margin-right: 0;
    }
    .section{
        margin: 0;
    }
    .landing-container .col-1,
    .landing-container .col-2{
        width: 100%;
        padding: 0 15px;
    }
    .section-odd .col-1 {
        float: left;
        margin-right: -100%;
    }
    .section-odd .col-2 {
        float: right;
        margin-top: 65%;
    }
}

@media (max-width: 320px){
    .premium-cta a.button{
        padding: 9px 20px 9px 70px;
    }

    .section .section-title img{
        display: none;
    }
}
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH Donations for WooCommerce%2$s to benefit from all features!','yith-wcaf'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-wcaf');?></span>
                    <span><?php _e('to the premium version','yith-wcaf');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-wcaf');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/01.png" alt="<?php _e( 'Minimum and maximum amount','yith-wcaf') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Minimum and maximum amount','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Among the many market requests, many users ask to make a donation of a specific amount range. The %1$sYITH Donations for WooCommerce%2$s plugin consider this request, offering you the freedom to receive donations suitable for your needs.', 'yith-wcaf'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Cart page','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__(' Almost every user looks at the cart page before proceeding with the checkout: add a donation form in this %1$sstrategic%2$s place of the site to get more profitable and better results.  ', 'yith-wcaf'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/02.png" alt="<?php _e( 'cart page','yith-wcaf') ?>" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/03.png" alt="<?php _e( 'Donations from product pages','yith-wcaf') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Donations from product pages','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('With the premium version of the plugin, you will be free to add a donation form even in the %1$sdetail page%2$s of one or more products of the shop. And there\'s more: make the donation mandatory, even for small amount, for those products of the shop that you want to sell at ridiculous prices, or for gifts. A small kindness grant from your users.', 'yith-wcaf'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('Payment methods','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Set ad hoc payment methods for those who have decided to make a donation with their order. A useful strategy to diversify the %1$spayment systems%2$s on the order kinds of your shop.', 'yith-wcaf'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/04.png" alt="<?php _e( 'Payment methods','yith-wcaf') ?>" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/05.png" alt="<?php _e( 'Text and style','yith-wcaf') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('Text and style','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Change the details of the plugin.%3$sIf you don\'t like the defaults ones, write the %1$sbest text%2$s for your messages, and customize the %1$sstyle%2$s of the donation button added by the plugin.%3$sYou can get to the results you want directly from the settings panel.','yith-wcaf' ),'<b>','</b>','<br>' ) ?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('Order list','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('A useful report to find immediately the %1$sorders%2$s of your shop that contain a %1$sdonation.%2$sA rapid way to find those orders that have produced extra earnings to your shop.','yith-wcaf'),'<b>','</b>'); ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/06.png" alt="<?php _e( 'Order list','yith-wcaf') ?>" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/07.png" alt="<?php _e( 'Widget','yith-wcaf') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/07-icon.png" alt="icon 07" />
                    <h2><?php _e('Widget','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('With the %1$sYITH Donations for WooCommerce%2$s - Form widget, you will be free to show in sidebars the total amount of your users\' donations.Share with your followers a significant information that may be always more surprising.','yith-wcaf'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="eight section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/08-icon.png" alt="icon 08" />
                    <h2><?php _e('Shortcode','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Use the shortcode available with the premium version of the YITH Donations for WooCommerce plugin to add the donation form in every place of the pages of your site. In this way, you will be free to create a %1$stailored page that encourage your users%2$s to donate a small amount of money.','yith-wcaf'),'<b>','</b>'); ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/08.png" alt="<?php _e( 'Shortcode','yith-wcaf') ?>" />
            </div>
        </div>
    </div>
    <div class="nine section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCDS_ASSETS_URL ?>images/09.png" alt="<?php _e( 'User email','yith-wcaf') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCDS_ASSETS_URL ?>images/09-icon.png" alt="icon 09" />
                    <h2><?php _e('User email','yith-wcaf');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('For every donation, the plugin lets you send an email to %1$sthank the users%2$s for their donation. Go to the settings panel to change the text of the email, and write what you think suits the best for your users.','yith-wcaf'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH Donations for WooCommerce%2$s to benefit from all features!','yith-wcaf'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-wcaf');?></span>
                    <span><?php _e('to the premium version','yith-wcaf');?></span>
                </a>
            </div>
        </div>
    </div>
</div>
