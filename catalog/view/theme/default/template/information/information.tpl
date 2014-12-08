<?php echo $header; ?>

    <div class="leftblock">

		<div class="b-col">
<!--
            <div class="path">
                <?php //foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php //echo $breadcrumb['separator']; ?><a href="<?php //echo $breadcrumb['href']; ?>"><?php //echo $breadcrumb['text']; ?></a>
                <?php //} ?>
            </div>
-->
			<div class="page-txt">
			  <h1><?php echo $heading_title; ?></h1>
              <?php echo $description; ?>
			</div>
			<div class="under-txt">
				<div class="ya">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div>
                </div>
				<ul class="small-links">
					<li>&larr; <a href="<?php echo $href_news_store; ?>">Перейти в рубрику «Новости магазина»</a></li>
					<li>&larr; <a href="<?php echo $href_news; ?>">Перейти к списку новостей</a></li>
				</ul>
          	    <p class="to-top"><a onclick="jQuery('html, body').animate({scrollTop: '0px'}, 800);" >Вверх страницы</a></p>
			</div>

            <div class="buttons" style="display:none">
            	<div class="right"><input type="button" onclick="onContinue('<?php echo $continue; ?>')" id="button-continue" value="<?php echo $button_continue; ?>" class="btn1" /></div>
            </div>

		</div><!--end b-col-->
    </div><!--end leftblock-->

    <div class="rightblock">
        <?php echo $column_right; ?>
    </div><!--end rightblock -->
  <div class="clear"></div>


<script type="text/javascript"><!--
  $(document).ready(function(){

    var src;
    $('.page-txt_b img').each(function() {
        src = $(this).attr('src');
        $(this).wrap('<a href="' + src + '" id="galleyimg" rel="prettyPhoto[gallery]" title=""></a>');
        //alert(src);
    });

    $("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'facebook', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
		keyboard_shortcuts: true
	});
  });
//--></script>
<script type="text/javascript"><!--
function onContinue(url) {
	location = url;
}
//--></script>
<?php echo $footer; ?>
