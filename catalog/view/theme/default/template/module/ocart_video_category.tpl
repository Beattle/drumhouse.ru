	<div class="nav nav-inner">
        <?php foreach ($categories as $category) { ?>

          <?php
            $class  = '';
            if ($category['category_id'] == $category_id) {
                $class  = ' class="active"';
            } else {
                $class  = '';
            }
          ?>

		  <p<?php echo $class; ?>><a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a></p>

        <?php } ?>

		<i class="sh-line-wrap"><i class="sh-line"></i></i>
	</div>
