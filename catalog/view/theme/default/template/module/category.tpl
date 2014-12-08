    <div class="nav">
        <?php foreach ($categories as $category) { ?>

          <?php
            $class  = '';
            $style  = '';
            if ($category['category_id'] == $category_id) {
                if ($category['children']) {
                    $class  = ' class="cat cat-active cat-current"';
                    $style  = ' style="display:block"';
                }
            } else {
                if ($category['children']) {
                    $class  = ' class="cat"';
                }
            }
          ?>

          <?php if ($category['category_id'] == $category_id && $child_id == 0) { ?>
		    <p<?php echo $class; ?>><span><?php echo $category['name']; ?></span><i class="arr"><i></i></i></p>
          <?php } else { ?>
		    <p<?php echo $class; ?>><a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a><i class="arr"><i></i></i></p>
          <?php } ?>

          <?php if ($category['children']) { ?>
            <ul<?php echo $style; ?>>
              <?php foreach ($category['children'] as $child) { ?>
                  <?php if ($child['category_id'] == $child_id) { ?>
                    <li class="active">
                      <?php echo $child['name']; ?>
                    </li>
                  <?php } else { ?>
                    <li>
                      <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                    </li>
                  <?php } ?>
              <?php } ?>
          </ul>
          <?php } ?>

        <?php } ?>

		<i class="sh-line-wrap"><i class="sh-line"></i></i>
	</div>
