<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if($albums) { ?>
  		<ul class="gallery">
  		<?php foreach($albums as $album) { ?>
			<li style="width:<?php echo ($this->config->get('news_config_albumsthumb_w')+30);?>px" class="album">
				<a href="<?php echo $album['href']; ?>" title="<?php echo $album['album_name']; ?>"><img src="<?php echo $album['thumb']; ?>" title="<?php echo $album['album_name']; ?>" alt="<?php echo $album['album_name']; ?>" /></a>
				<div class="albumname">
					<?php echo $album['album_name']; ?>
				</div>
				<?php if($this->config->get('news_config_gallery_count')) { ?>
				<div class="albumcount">
					<?php echo $album['album_imgcount']; ?>
				</div>
				<?php if($this->config->get('news_config_gallery_vote')){ ?>
					 <div class="startnone">
						<?php for($i = 1;$i <=5; $i++) :?>
							<?php if($i <= $album['album_numvote']) :?>
				                <a class="sta">&nbsp;&nbsp;&nbsp;&nbsp;</a>
							<?php else :?>
			                    <a class="gry">&nbsp;&nbsp;&nbsp;&nbsp;</a>
							<?php endif; ?>
						<?php endfor; ?>
			       </div>
				<?php } ?>	
				<?php } ?>
				
				<?php if($this->config->get('news_config_gallery_creatdate')){ ?>
				<div class="albumdate">
					<?php echo $album['album_date']; ?>
				</div>
				<?php } ?>

				<?php if($album['album_desc']){ ?>
				<div class="albumdesc">
					<?php echo $album['album_desc']; ?>
				</div>
				<?php } ?>
			</li>

		<?php } ?>
		</ul>
  <?php }else{ ?>
  	
  <?php } ?>
<div class="pagination"><?php echo $pagination; ?></div>
  <?php echo $content_bottom; ?></div>
<link href="catalog/view/news/global.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<?php echo $footer; ?>