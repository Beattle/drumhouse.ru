	<div class="nav nav-inner">
        <?php foreach ($news_categories as $news_category) { ?>

          <?php
            $class  = '';
            if ($news_category['news_category_id'] == $child_news_category_id) {
                $class  = ' class="active"';
            } else {
                $class  = '';
            }
          ?>

		  <p<?php echo $class; ?>><a href="<?php echo $news_category['href']; ?>"><span><?php echo $news_category['news_category_name']; ?></span></a></p>

        <?php } ?>

		<i class="sh-line-wrap"><i class="sh-line"></i></i>
	</div>
