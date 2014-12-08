<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if($images) { ?>
  		<ul class="albums">
  		<?php foreach($images as $image) { ?>
			<li style="width:<?php echo ($this->config->get('news_config_imagesthumb_w')+20);?>px" class="album">
				<a id="galleyimg" href="<?php echo $image['popup']; ?>" rel="prettyPhoto[album]" title="<?php echo $image['image_desc']; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $image['image_name']; ?>" alt="<?php echo $image['image_name']; ?>" /></a>
				<?php if($image['image_name']){ ?>
					<div class="imagename">
						<?php echo $image['image_name']; ?>
					</div>
				<?php } ?>
				<?php if($image['image_showdate'] == 1){ ?>
					<div class="imagedate">
						<?php echo $image['image_date']; ?>
					</div>
				<?php } ?>
				<?php if($image['image_showvote']){?>
				  <div id="<?php echo $image['image_id']; ?>" class="stars">
						<?php for($i = 1;$i <=5; $i++) :?>
							<?php if($i <= $image['image_numvote']) :?>
				                <a class="sta">&nbsp;&nbsp;&nbsp;&nbsp;</a>
							<?php else :?>
			                    <a class="gry">&nbsp;&nbsp;&nbsp;&nbsp;</a>
							<?php endif; ?>
						<?php endfor; ?>
			       </div> 
				    <div class="imagevote"><?php echo $image['image_vote'];?></div>
				 <?php } ?>
				<?php if($image['image_showview']){ ?>
					<div class="imageview"><?php echo $image['image_view'];?></div>
				<?php }?>
			</li>

		<?php } ?>
		</ul>
  <?php }else{ ?>
  	
  <?php } ?>
<div class="pagination"><?php echo $pagination; ?></div>
  <?php echo $content_bottom; ?></div>
<link href="catalog/view/news/prettyPhoto.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="catalog/view/news/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" charset="utf-8"><!--
  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto({
		theme: '<?php echo $this->config->get('news_config_gallerytheme'); ?>', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
		keyboard_shortcuts: true
	});
  });
  
$('.album').each(function(){
	var stars = $(this).find('.stars');
	var vote = $(this).find('.imagevote');
	var img = $(this).find('#galleyimg');
	var id = $(stars).attr('id');
	$(stars).find('a').bind('click',function(){
		$.ajax({
		type: 'POST',
		url: 'index.php?route=news/gallery/vote&image_id='+id,
		data : 'image_id='+id+'',
		dataType: 'json',
		beforeSend: function() {
		$(vote).html('<img src="catalog/view/theme/default/image/loading.gif" id="loading" style="padding-left: 5px;" />');
	},
		success:function(json){
			if(json.error)
			{
				$(vote).html(json.error);
			}
			if(json.success)
			{
				$(vote).html(json.success);
				$(stars).hide();
			}
		}
	})
});
$(img).bind('click',function(){
		$.ajax({
		type: 'POST',
		url: 'index.php?route=news/gallery/view&image_id='+id,
		data : 'image_id='+id+'',
		dataType: 'json',
	})
	});
});
 //-->
</script>
<link href="catalog/view/news/global.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<?php echo $footer; ?>