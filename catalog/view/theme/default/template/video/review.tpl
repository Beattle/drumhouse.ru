
<?php if($reviews) { ?>
	<?php foreach($reviews as $review) { ?>

    	<div class="b-comment">
    		<p class="comment-autor"><?php echo $review['author']; ?></p>
    		<p class="comment-date"><?php echo $review['date_added']; ?></p>
    		<?php echo $review['text']; ?>
    	</div>

	<?php } ?>
	<div class="page-stats page-stats4">
        <div id="pagination"><?php echo $pagination; ?></div>
        <?php echo $total_comment; ?>
	</div>

<?php } ?>