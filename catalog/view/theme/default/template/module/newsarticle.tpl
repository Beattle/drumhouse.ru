		<div class="b-tabs">
			<ul class="tab-nav">
				<li class="active"><a href="#tab-body1">Статьи</a></li>
				<li><a href="#tab-body2">Новости</a></li>
			</ul>

			<div class="tab-body" id="tab-body1">

          	<?php if($articles2) { ?>
		      <?php $k = 1; ?>
		      <?php foreach($articles2 as $article) { ?>

              	<?php if($k++ == 1) { ?>
				    <div class="tab-body-bl tab-body-bl-first">
              	<?php } else { ?>
    		        <?php echo '<div class="tab-body-bl">'; ?>
              	<?php } ?>

					<p class="tab-body-title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></p>
					<div class="tab-body-n">

					<p class="tab-body-date"><span><?php echo $article['create_date']; ?> |</span> <a href="<?php echo $article['category_href']; ?>"><?php echo $article['category']; ?></a></p>

                    <?php echo $article['description']; ?>

					<p class="tab-body-comment"><a href="<?php echo $article['comment_href']; ?>#comment-list">Комментарии</a> (<?php echo $article['comment'];?>) </p>
					</div>
				</div>

          	  <?php } ?>
          	<?php } ?>

				<p class="tab-body-all"><a href="<?php echo $articles_all2; ?>">Все статьи</a></p>

				<i class="sh-line-wrap"><i class="sh-line"></i></i>
			</div>
			<div class="tab-body" id="tab-body2">

          	<?php if($articles) { ?>
		      <?php $k = 1; ?>
		      <?php foreach($articles as $article) { ?>

              	<?php if($k++ == 1) { ?>
				    <div class="tab-body-bl tab-body-bl-first">
              	<?php } else { ?>
    		        <?php echo '<div class="tab-body-bl">'; ?>
              	<?php } ?>

					<p class="tab-body-title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></p>
					<div class="tab-body-n">

					<p class="tab-body-date"><span><?php echo $article['create_date']; ?> |</span> <a href="<?php echo $article['category_href']; ?>"><?php echo $article['category']; ?></a></p>

                    <?php echo $article['description']; ?>

					<p class="tab-body-comment"><a href="<?php echo $article['comment_href']; ?>#comment-list">Комментарии</a> (<?php echo $article['comment'];?>) </p>
					</div>
				</div>

          	  <?php } ?>
          	<?php } ?>

				<p class="tab-body-all"><a href="<?php echo $articles_all; ?>">Все новости</a></p>

				<i class="sh-line-wrap"><i class="sh-line"></i></i>
			</div>


		</div>



