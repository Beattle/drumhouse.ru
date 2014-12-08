
<?php if($comments) { ?>
	<?php foreach($comments as $comment) { ?>

    	<div class="b-comment">
    		<p class="comment-autor"><?php echo $comment['news_comment_author'];?></p>
    		<p class="comment-date"><?php echo $comment['news_comment_date_added'];?></p>
    		<?php echo $comment['news_comment_text']; ?>
    	</div>

	<?php } ?>
	<div class="page-stats page-stats4">
        <div id="pagination"><?php echo $pagination; ?></div>
        <?php echo $total_comment; ?>
	</div>

<?php } ?>
