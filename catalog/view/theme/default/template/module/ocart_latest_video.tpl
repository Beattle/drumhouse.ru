<div class="b-video-r">
  <?php foreach ($videos as $video) {?>
	<p class="b-video-r-title">
	  <a href="<?php echo $video['href']; ?>"><?php echo $video['name']; ?></a>
	</p>
	<p class="b-video-r-links"><a href="<?php echo $videos_href; ?>">Видео</a> | <a href="<?php echo $video['vcat_href']; ?>"><?php echo $video['vcat_name']; ?></a></p>
    <div style="text-align: center; align="center"">
        <object style="height: 165px; width: 245px"><param name="movie" value="http://www.youtube.com/v/<?php echo $video['link']; ?><?php echo $youtube_extension; ?>"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/<?php echo $video['link']; ?><?php echo $youtube_extension; ?>" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="245" height="165"></object>
    </div>
  <?php } ?>
</div>
