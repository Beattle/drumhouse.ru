<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; // if ($keywords) echo " - ".$keywords; if ($description) echo " - ".$description; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/style.css" />
<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie.css"><![endif]-->
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/fonts.css" />


<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.9.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.9.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<link rel="stylesheet" type="text/css" href="catalog/view/news/prettyPhoto.css" media="screen" />
<script type="text/javascript" src="catalog/view/news/js/jquery.prettyPhoto.js"></script>

<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<!--<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.cycle.js"></script>-->
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/main.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php echo $google_analytics; ?>

<script language="javascript">
var bg_image = '<?php echo $bg_image; ?>';

$(function() {
    var topBg = $(".top-bg");
    topBg.ready(function(){
        if (bg_image) {
	        topBg.animate({opacity:0}, 0, "linear", function(){
		        topBg.css("background-image","url('<?php echo $bg_image; ?>')");
		        topBg.animate({opacity:1}, 0);
	        });
        }
    });
});
</script>

<script language="javascript">
$(document).ready(function(){
    $(".cat .arr").click(function(){
	    //$(this).parent().toggleClass("cat-active").next("ul").slideToggle(200).siblings("ul:visible").slideUp(200).prev("p").removeClass("cat-active");
		$(this).parent().toggleClass("cat-active").next("ul").slideToggle("slow").siblings("ul:visible").slideUp("slow").prev("p").removeClass("cat-active");
		return false;

	});

    $("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'facebook', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
		keyboard_shortcuts: true
	});
});
</script>
<script type="text/javascript" charset="utf-8">
$(function () {
    var tabContainers = $('div.b-tabs > div');
    tabContainers.hide().filter(':first').show();

    $('.tab-nav a').click(function () {
        tabContainers.hide();
        tabContainers.filter(this.hash).show();
        $('.tab-nav li').removeClass('active').removeClass('active-l').removeClass('active-r');;
        $(this).parents("li").addClass('active');
        $(this).parents("li").next().addClass('active-r');
        $(this).parents("li").prev().addClass('active-l');
        return false;
    }).filter(':first').click();
});
</script>

<script type="text/javascript" charset="utf-8">
$(function () {
    var tabContainers = $('div.b-tabs2 > div');
    tabContainers.hide().filter(':first').show();

    $('.tab-nav2 a').click(function () {
        tabContainers.hide();
        tabContainers.filter(this.hash).show();
        $('.tab-nav2 li').removeClass('active').removeClass('active-l').removeClass('active-r');
        $(this).parents("li").addClass('active');
        $(this).parents("li").next("li").addClass('active-r');
        $(this).parents("li").prev("li").addClass('active-l');

        arrangeItem();

        return false;
    }).filter(':first').click();
});
</script>

<script type="text/javascript"><!--
var banner = function() {
	$('#banner_head').cycle({
		before: function(current, next) {
			$(next).parent().height($(next).outerHeight());
		}
	});
}

setTimeout(banner, 2000);
//--></script>

</head>

<body>

<div class="wrapper">
  <div class="page">
  <div class="head">

	   <p class="logo">
	   	<a href="/"><img src="<?php echo $logo; ?>" title="<?php echo $logoname; ?>" alt="<?php echo $logoname; ?>" /> <?php echo $logoname; ?></a>
	   </p>
	    <!-- ========== MENU ========== -->
	    <ul class="t-nav">
            <?php
                $a = 'http://' . $_SERVER['SERVER_NAME'] . str_replace('&amp;', '&', $_SERVER['REQUEST_URI']);
                foreach ($menu as $item) {
                  echo '<li';
                  $it = str_replace('&amp;', '&', $item['href']);
                  if ($it == $a) {
                    echo ' class="active">';
                    echo '<span>' . $item['title'] . '</span></li>';
                  } else {
                    echo '>';
                    echo '<a href="' . $item['href'] . '">' . $item['title'] . '</a></li>';
                  }
                }
            ?>
        </ul>
		<!-- ========================== -->
<!--
	   <ul class="t-nav">
	   	<li><a href="index.php?route=information/information&information_id=4">О магазине</a></li>
		<li class="active">Каталог</li>
		<li><a href="index.php?route=news/category&catid=1">Новости</a></li>
		<li><a href="index.php?route=information/information&information_id=6">Доставка</a></li>
		<li><a href="index.php?route=information/information&information_id=7">Оплата</a></li>
		<li><a href="#">Видео</a></li>
		<li><a href="index.php?route=news/category&catid=2">Статьи</a></li>
		<li><a href="index.php?route=information/contact">Контакты</a></li>
	   </ul>
-->
  </div><!--end head -->

    <div class="leftblock">

        <div id="banner_head" class="banner">
          <?php foreach ($banners as $banner) { ?>
          <?php if ($banner['link']) { ?>
            <div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></div>
          <?php } else { ?>
            <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></div>
          <?php } ?>
          <?php } ?>
        </div>

		<div class="sidebar">
        </div><!--end sidebar-->

		<div class="content">
		</div><!--end content-->
		<div class="clear"></div>

    </div><!--end leftblock-->

    <div class="rightblock">
        <div class="contacts">
        	<p class="contact-title"><?php echo $contacts_title; ?></p>
            <p class="contact-tel"><?php echo $contacts_code; ?> <span><?php echo $contacts_phone; ?></span></p>
			<p class="contact-tel" style="border-top: 1px solid #f3f3f3;">+7 (800) <span>555-86-04</span></p>
            <ul class="contact-other">
                <!--<li><a href="<?php echo $contacts_skype_href; ?>"><?php echo $contacts_skype_name; ?></a><i class="contact-ico1"></i></li>-->
                <li> <?php echo $contacts_icq; ?><i class="contact-ico2"></i></li>
            </ul>
            <i class="tel-ico"></i>
        </div>
    </div><!--end rightblock -->
  <div class="clear"></div>

  <div id="notification"></div>
