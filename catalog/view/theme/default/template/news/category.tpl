<?php echo $header; ?>

    <div class="leftblock">

        <?php echo $content_top; ?>

		<div class="sidebar">
            <?php echo $column_left; ?>
        </div><!--end sidebar-->

		<div class="content">
            <div class="path">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php } ?>
            </div>

            <?php echo $column_center; ?>

			<h1 class="mb15"><?php echo $heading_title; ?></h1>

            <?php if ($news_articles) { ?>
              <?php foreach ($news_articles as $article) { ?>

			    <div class="b-central-content">
			 	  <p class="b-central-content_title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></p>
                  <?php if ($article['thumb']) { ?>
				    <a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['title']; ?>" alt="<?php echo $article['title']; ?>" /></a>
	              <?php } ?>
				  <p class="b-central-content_sub-info"><?php echo $article['create_date'];?>&nbsp; |&nbsp; <a href="<?php echo $article['category_href']; ?>"><?php echo $article['category']; ?></a>  &nbsp;|&nbsp; <a href="<?php echo $article['comment_href']; ?>#comment-list" class="comment-col"><?php echo $article['comment']; ?><i></i></a></p>

                  <?php echo $article['begin_description']; ?>

			   </div>
              <?php } ?>
            <?php } ?>

			<div class="page-stats page-stats-alt">
              <div class="page-nav"><?php echo $pagination; ?></div>
              <?php echo $total_pages; ?>
			</div>

       	    <p class="to-top"><a onclick="jQuery('html, body').animate({scrollTop: '0px'}, 800);" >Вверх страницы</a></p>

		</div><!--end content-->
		<div class="clear"></div>
    </div><!--end leftblock-->

    <div class="rightblock">
        <?php echo $column_right; ?>
    </div><!--end rightblock -->
  <div class="clear"></div>

<?php echo $footer; ?>