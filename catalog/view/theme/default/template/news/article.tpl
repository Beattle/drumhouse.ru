<?php echo $header; ?>

    <div class="leftblock">
		<div class="b-col">

            <div class="path">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php } ?>
            </div>

			<h1 class="pt10"><?php echo $heading_title; ?></h1>

            <div class="page-txt_b">
              <?php echo $description; ?>
            </div>

			<div class="under-txt under-txt2">
				<div class="ya">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div>
                </div>
				<ul class="small-links">
					<li>&larr; <a href="<?php echo $category_href; ?>">Перейти в рубрику «<?php echo $category; ?>»</a></li>
					<li>&larr; <a href="<?php echo $parent_href; ?>">Перейти к списку <?php echo $parent; ?></a></li>
				</ul>
			</div>

			<div class="comments">
            <?php if($comment_total) { ?>
    			<h3>Комментарии пользователей</h3>
            <?php } ?>

		    <div id="comment-list"></div>
		    </div>


            <?php if($allow_comment) { ?>

			  <h3>Напишите комментарий</h3>
			  <div class="add-comment">
    			  <div class="add-comment_line">
    			    <p>Ваше имя:</p>
			        <input type="text" name="comment_name" />
    			  </div>
    			  <div class="add-comment_line">
    			    <p>Ваш комментарий:</p>
        			<textarea rows="7" cols="83" name="comment_text"></textarea>
    			  </div>

    			  <div class="add-code">
    			    <p>Введите код, указанный на картинке:</p>
        		    <img src="index.php?route=news/article/captcha" alt="" id="captcha" />
        			<input type="text" name="captcha" value="" />
    				<div class="add-code-send"><input type="submit" value="Отправить" class="btn1" id="add-comment" /></div>
    			  </div>

			  </div>

            <?php } ?>

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
$('.stars a').bind('click',function(){
	var stars = $(this).attr('rel');
	$.ajax({
		type: 'POST',
		url: 'index.php?route=news/article/vote&news_id=<?php echo $news_id; ?>',
		data : 'stars='+stars+'',
		dataType: 'json',
		beforeSend: function() {
		$('.vote').html('<img src="catalog/view/theme/default/image/loading.gif" id="loading" style="padding-left: 5px;" />');
	},
		success:function(json){
			if(json.error)
			{
				$('.vote').html(json.error);
			}
			if(json.success)
			{
				$('.vote').html(json.success);
				$('.stars').hide();
			}
		}
	})
});
<?php if($allow_comment) { ?>
$('#pagination .links a').live('click', function() {
	$('#comment-list').slideUp('slow');
		
	$('#comment-list').load(this.href);
	
	$('#comment-list').slideDown('slow');
	
	return false;
});		
$('#comment-list').load('index.php?route=news/article/comment&news_id=<?php echo $news_id; ?>');
$('#add-comment').bind('click',function(){
	$.ajax({
		type: 'POST',
		url: 'index.php?route=news/article/addcomment&news_id=<?php echo $news_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'comment_name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'comment_text\']').val()) + '&email=' + encodeURIComponent($('input[name=\'comment_email\']').val()) + '&title='+  encodeURIComponent($('input[name=\'comment_title\']').val()) + '&website=' + encodeURIComponent($('input[name=\'comment_website\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('#comment-list').append('<div id="load"><img src="catalog/view/theme/default/image/loading.gif" id="loading" style="padding-left: 5px;" /></div>');
		},
		success: function(data) {
			if (data.error) {
				$('#load').remove();
				$('.warning,.success').remove();
				$('#no-comment').remove();
				$('#comment-list').after('<div class="warning">' + data.error + '</div>');
			}

			if (data.publish == true) {
				$('#comment-list').load('index.php?route=news/article/comment&news_id=<?php echo $news_id; ?>');
				$('#load').remove();
				$('#no-comment').remove();
				$('.warning,.success').remove();
				clear();
			}
			if(data.publish == false)
			{
                alert(data.text_thank);
				$('#load').remove();
				$('.warning ,.success').remove();
				$('#comment-list').after('<div class="success">' + data.text_thank + '</div>');
				clear();
			}
		}
	});
});
function clear()
{
	$('input[name=\'comment_name\']').val('');
	$('textarea[name=\'comment_text\']').val('');
	$('input[name=\'captcha\']').val('');
	$('input[name=\'comment_title\']').val('');
	$('input[name=\'comment_email\']').val('');
	$('input[name=\'comment_website\']').val('');
}
<?php } ?>
//--></script>
<?php echo $footer; ?>