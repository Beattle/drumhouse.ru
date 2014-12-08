<?php echo $header; ?>

    <div class="leftblock">
		<div class="b-col">

            <div class="path">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php } ?>
            </div>

			<h1><?php echo $heading_title; ?></h1>
			<div class="item-big">
				<div class="item-big_im">
                    <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="fancybox" rel="fancybox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
					<p class="item-big_im_zoom"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="fancybox" rel="fancybox">Увеличить</a></p>
				</div>
				<div class="item-big_info">
					<table class="item-bif_t">
						<tr>
							<td><b>Рейтинг:</b></td>
							<td class="td1">
                                <?php if ($review_status && $rating > 0) { ?>
                                  <div class="rating"><img src="catalog/view/theme/default/image/i/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" /></div>
                                <?php } ?>
                            </td>
						</tr>
						<tr>
							<td><b>Наличие:</b></td>
							<td class="td1"> <?php echo $stock; ?></td>
						</tr>
						<tr>
							<td><b>Артикул:</b></td>
							<td class="td1"> <?php echo $sku; ?></td>
						</tr>
						<tr>
							<td><b>Производитель:</b></td>
							<td class="td1">
                                <?php if ($manufacturer) { ?>
                                  <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a>
                                <?php } ?>
                            </td>
						</tr>
						<tr class="td-price">
							<td><b>Цена:</b></td>
							<td>
                                <?php if ($price) { ?>
                                  <?php if (!$special) { ?>
          						    <p class="item-price-new"><?php echo $price; ?></p>
                                  <?php } else { ?>
          						    <p class="item-price-old"><s><?php echo $price; ?></s></p>
          							<p class="item-price-new"><?php echo $special; ?></p>
                                  <?php } ?>
                                <?php } ?>
							</td>
						</tr>
					</table>

					<div class="item-big_tobasket">
						<div class="item-big_tobasket_col">
                        <input type="text" name="quantity" value="<?php echo $minimum; ?>" />
                        <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
						<p>Количество:</p>
						</div>
						 <div class="item-to-basket">
						    <a id="button-cart" href="javascript(0)" class="item-basket-ico"></a>
							<p class="item-nal">В корзину!</p>

						 </div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="ya">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div>
                </div>
			</div>

			<div class="b-tabs2">
			<ul class="tab-nav2">
				<li class="active"><a href="#tab-body3">Описание</a><i class="div-l"></i><i class="blue-line"></i></li>
                <?php if ($images):?><li><a href="#tab-body4">Фото<?php if ($total_images) { echo ' (' . $total_images . ')'; } ?></a><i class="blue-line"></i></li><?php endif;?>
                <?php if ($videos):?><li><a href="#tab-body5">Видео<?php if ($total_videos) { echo ' (' . $total_videos . ')'; } ?></a><i class="blue-line"></i></li><?php endif;?>
				<li><a href="#tab-body6">Отзывы</a><i class="blue-line"></i></li>
                <?php if ($products):?><li><a href="#tab-body7">Рекомендуем</a></li><?php endif;?>
			</ul>

			<div class="tab2-body page-txt" id="tab-body3">
                <?php echo $description; ?>
			</div>

			<div class="tab2-body" id="tab-body4">
                <?php if ($images) { ?>
				  <!--<div class="image-additional">-->
				  <div class="img-video">
                  <?php foreach ($images as $image) { ?>
					<div class="b-img-video">
                      <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" id="galleyimg" rel="prettyPhoto[gallery]"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
					</div>
                  <?php } ?>
                </div>
                <?php } ?>
			</div>

			<div class="tab2-body" id="tab-body5">
                <?php if ($videos) { ?>
				  <div class="img-video">
                  <?php foreach ($videos as $video) { ?>
					<div class="b-img-video">
                      <a href="<?php echo $video['href']; ?>" title="<?php echo $heading_title; ?>" id="galleyimg" rel="prettyPhoto[gallery]"><img src="<?php echo $video['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
					</div>
                  <?php } ?>
                </div>
                <?php } ?>
			</div>

			<div class="tab2-body" id="tab-body6">
                <div id="review"></div>

    			<h3 id="review-title">Написать отзыв</h3>
  			    <div class="add-comment">
      			  <div class="add-comment_line">
      			    <p>Ваше имя:</p>
  			        <input type="text" name="comment_name" />
      			  </div>
      			  <div class="add-comment_line">
      			    <p>Ваш комментарий:</p>
          			<textarea rows="7" cols="83" name="comment_text"></textarea>
      			  </div>

      			  <div class="add-comment_line">
                    &nbsp;&nbsp;<?php echo $entry_rating; ?>&nbsp;&nbsp;<span><?php echo $entry_bad; ?></span>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp; <span><?php echo $entry_good; ?></span><br />
      			  </div>

      			  <div class="add-code">
      			    <p>Введите код, указанный на картинке:</p>
          		    <img src="index.php?route=product/product/captcha" alt="" id="captcha" />
          			<input type="text" name="captcha" value="" />
      				<div class="add-code-send"><input type="submit" value="Отправить" class="btn1" id="button-review" /></div>
      			  </div>
  			    </div>

			</div>

			<div class="tab2-body" id="tab-body7">
				<div class="items">
                <?php if ($products) { ?>
                    <?php foreach ($products as $product) { ?>

    					<div class="b-item">
    					  <div class="item-title">
    					    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?> <div class="item-im"><img src="<?php echo $product['thumb']; ?>" id="image<?php echo $product['product_id']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></div></a>
                            <?php if ($product['status_new']) { ?>
        					    <div class="item-status">
        						  <span class="item-status-new"></span>
        						</div>
            				    <!--<span class="item-status">Новинка!</span>-->
                            <?php } else {
                                if ($product['status_hit']) { ?>
        						    <div class="item-status">
        							  <span class="item-status-top"></span>
        							</div>
            						<!--<span class="item-status">Хит!</span>-->
                                <?php } else { ?>
            						<!--<span class="item-status">&nbsp;</span>-->
                                <?php } ?>
                            <?php } ?>
    					  </div>

                        <?php if ($product['rating']) { ?>
        				    <span class="star"><img src="catalog/view/theme/default/image/i/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></span>
                        <?php } ?>

    					  <p class="item-info">
                            <?php echo $product['description']; ?>
                          </p>
    					  <div class="item-bot">
                          <?php if ($product['price']) { ?>
                            <?php if (!$product['special']) { ?>
    						    <p class="item-price-old"><s><br /></s></p>
    						    <p class="item-price-new"><?php echo $product['price']; ?></p>
                            <?php } else { ?>
    						    <p class="item-price-old"><s><?php echo $product['price']; ?></s></p>
    							<p class="item-price-new"><?php echo $product['special']; ?></p>
                            <?php } ?>
                          <?php } ?>

    						<div class="item-to-basket">
    						  <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="item-basket-ico"></a>
    						  <p class="item-nal">Есть в наличии</p>
    						</div>
    					  </div>
    					</div>

                    <?php } ?>
                <?php } ?>
				</div>
			</div>

			</div>
		</div><!--end b-col-->
    </div><!--end leftblock-->

    <div class="rightblock">
        <?php echo $column_right; ?>
    </div><!--end rightblock -->
  <div class="clear"></div>

<script type="text/javascript"><!--
$('.fancybox').fancybox({cyclic: true});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {

    //alert('button-cart');

	$.ajax({
		url: 'index.php?route=checkout/cart/update',
		type: 'post',
		data: $('.item-big_tobasket_col input[type=\'text\'], .item-big_tobasket_col input[type=\'hidden\'], .item-big_tobasket_col input[type=\'radio\']:checked, .item-big_tobasket_col input[type=\'checkbox\']:checked, .item-big_tobasket_col, .item-big_tobasket_col textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
					$('.warning').fadeIn('slow');
				}
				
				for (i in json['error']) {
					$('#option-' + i).after('<span class="error">' + json['error'][i] + '</span>');
				}
			}	 
						
			if (json['success']) {
				//$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				//$('.success').fadeIn('slow');
					
				$('#cart_total').html(json['total']);
			    $('#module_cart .basket-body').html(json['output']);

                animateProduct($('#image'), $('#module_cart'));

				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});

    return false;
});

function animateProduct(image, cart) {

	image.before('<img src="' + image.attr('src') + '" id="temp_animate" style="position: absolute; top: ' + image.top + 'px; left: ' + image.left + 'px;" />');

    var cart_offset  = cart.offset();
    var image_offset = image.offset();

    var top  = cart_offset.top - image_offset.top;
    var left = cart_offset.left - image_offset.left;

    //alert(cart_offset.top - image_offset.top);

    //alert(cart_offset.top - cart.height());
    //alert(cart_offset.left - cart.width());

    params = {
        top:    top  + 'px',
        left:   left + 'px',
        opacity: 0.0,
        width:  cart.width(),
        height: cart.height()
    };

    $('#temp_animate').animate(params, "slow", false, function () {
        $('#temp_animate').remove();
    });
}

//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" id="loading" style="padding-left: 5px;" />');
	},
	onComplete: function(file, json) {
		$('.error').remove();
		
		if (json.success) {
			alert(json.success);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json.file);
		}
		
		if (json.error) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json.error + '</span>');
		}
		
		$('#loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').slideUp('slow');
		
	$('#review').load(this.href);
	
	$('#review').slideDown('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'comment_name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'comment_text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review-title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review-title').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'comment_name\']').val('');
				$('textarea[name=\'comment_text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script>
<?php echo $footer; ?>
