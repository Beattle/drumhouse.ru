<?php echo $header; ?>

    <div class="leftblock">
		<div class="b-col">

            <div class="path">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php } ?>
            </div>

			<h1><?php echo $heading_title; ?></h1>
			<div class="video">
                <iframe class="restrain" title="YouTube video player" width="640" height="390" src="//www.youtube.com/embed/<?php echo $code; ?>" frameborder="0" style="position:relative; z-index:10;"></iframe>
			</div>

            <?php echo $description; ?>

			<div class="under-txt under-txt2">
				<div class="ya">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div>
                </div>
				<ul class="small-links">
					<li>&larr; <a href="<?php echo $category_href; ?>">Перейти в рубрику «<?php echo $category; ?>»</a></li>
					<li>&larr; <a href="<?php echo $video_href; ?>">Перейти к списку видео</a></li>
				</ul>
			</div>

			<div class="comments">
            <?php if($comment_total) { ?>
    			<h3>Комментарии пользователей</h3>
            <?php } ?>

		    <div id="comment-list"></div>
		    </div>


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
                    <div class="add-code-send"><a id="button-review" class="button"><span>Отправить</span></a></div>
    			  </div>

			  </div>

		</div><!--end b-col-->
    </div><!--end leftblock-->

    <div class="rightblock">
        <?php echo $column_right; ?>
    </div><!--end rightblock -->
  <div class="clear"></div>

<script type="text/javascript"><!--
$('#comment-list .pagination a').live('click', function() {
	$('#comment-list').slideUp('slow');

	$('#comment-list').load(this.href);
	
	$('#comment-list').slideDown('slow');
	
	return false;
});			

$('#comment-list').load('index.php?route=video/video/review&video_id=<?php echo $video_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=video/video/write&video_id=<?php echo $video_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'comment_name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'comment_text\']').val()) + '&rating=5' + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#comment-list').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#comment-list').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#comment-list').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'comment_name\']').val('');
				$('textarea[name=\'comment_text\']').val('');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<?php echo $footer; ?>