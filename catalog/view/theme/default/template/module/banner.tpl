<div id="banner<?php echo $module; ?>" class="banner">
  <?php foreach ($banners as $banner) { ?>
  <?php if ($banner['link']) { ?>
  <div>3333<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></div>
  <?php } else { ?>
  <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></div>
  <?php } ?>
  <?php } ?>
</div>
<script type="text/javascript"><!--
// var banner = function() {
	// $('#banner<?php echo $module; ?>').cycle({
		// before: function(current, next) {
			// $(next).parent().height($(next).outerHeight());
		// }
	// });
// }

// setTimeout(banner, 2000);
//--></script>