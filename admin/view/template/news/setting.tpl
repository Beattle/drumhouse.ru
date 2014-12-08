<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
	  <?php if(isset($update)){ ?>
	  	 <a class="button" href="<?php echo $update; ?>"><span><?php echo $button_update; ?></span></a>
	  <?php }?>
	  <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
   <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
		  	<tr class="trhead">
				<td colspan="2"><?php echo $head_news; ?></td>
			</tr>
          	<tr>
              <td><?php echo $entry_datetime; ?></td>
              <td><input type="text" name="news_config_datetime" value="<?php echo $news_config_datetime; ?>" size="20" />
			  </td>
            </tr>
        	<tr class="trhead">
				<td colspan="2"><?php echo $head_category; ?></td>
			</tr>
          	<tr>
              <td><span class="required">*</span><?php echo $entry_itemperpage; ?></td>
              <td><input type="text" name="news_config_item" value="<?php echo $news_config_item; ?>" size="3" />
                <?php if ($error_news_config_item) { ?>
                <span class="error"><?php echo $error_news_config_item; ?></span>
                <?php } ?>
			  </td>
            </tr>
			<tr>
              <td><span class="required">*</span><?php echo $entry_thumbsetting; ?></td>
              <td><?php echo $entry_thumbsetting_w;?><input type="text" name="news_config_catthumb_w" value="<?php echo $news_config_catthumb_w; ?>" size="3" />&nbsp;&nbsp;<?php echo $entry_thumbsetting_h;?><input type="text" name="news_config_catthumb_h" value="<?php echo $news_config_catthumb_h; ?>" size="3" />
                <?php if ($error_news_config_catthumb) { ?>
                <span class="error"><?php echo $error_news_config_catthumb; ?></span>
                <?php } ?>
			  </td>
            </tr>
			<tr>
              <td><span class="required">*</span><?php echo $entry_description_limit; ?></td>
              <td><input type="text" name="news_config_desc_limit" value="<?php echo $news_config_desc_limit; ?>" size="5" />
                <?php if ($error_news_config_desc_limit) { ?>
                <span class="error"><?php echo $error_news_config_desc_limit; ?></span>
                <?php } ?>
			  </td>
            </tr>
			<tr>
				<td><?php echo $entry_subcategory;?></td>
				<td>
					<input type="radio" name="news_config_subcategory" value="1" <?php if($news_config_subcategory==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_subcategory" value="0" <?php if($news_config_subcategory==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showcreatdate;?></td>
				<td>
					<input type="radio" name="news_config_showdate" value="1" <?php if($news_config_showdate==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_showdate" value="0" <?php if($news_config_showdate==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showvote;?></td>
				<td>
					<input type="radio" name="news_config_showvote" value="1" <?php if($news_config_showvote==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_showvote" value="0" <?php if($news_config_showvote==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showview;?></td>
				<td>
					<input type="radio" name="news_config_showview" value="1" <?php if($news_config_showview==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_showviews" value="0" <?php if($news_config_showview==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showcommentcount;?></td>
				<td>
					<input type="radio" name="news_config_showcommentcount" value="1" <?php if($news_config_showcommentcount==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_showcommentcount" value="0" <?php if($news_config_showcommentcount==0) echo 'checked';?> /> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showreadmore;?></td>
				<td>
					<input type="radio" name="news_config_showreadmore" value="1" <?php if($news_config_showreadmore==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_showreadmore" value="0" <?php if($news_config_showreadmore==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $entry_showdesc;?></td>
				<td>
					<input type="radio" name="news_config_showcatdesc" value="1" <?php if($news_config_showcatdesc==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_showcatdesc" value="0" <?php if($news_config_showcatdesc==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<!-- For Gallery -->
			<tr class="trhead">
				<td colspan="2"><?php echo $head_gallery; ?></td>
			</tr>
			<tr>
				<td><?php echo $entry_gallerytomenu; ?></td>
				<td><input type="radio" name="news_config_gallerytop" value="1" <?php if($news_config_gallerytop==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_gallerytop" value="0" <?php if($news_config_gallerytop==0) echo 'checked';?> /> <?php echo $entry_news_no; ?></td>
			</tr>
			<tr id="gallery-order">
				<td><?php echo $entry_gallery_order; ?></td>
				<td><input type="text" name="news_config_gallery_order" size="3" value="<?php echo $news_config_gallery_order; ?>" />
				<?php if($error_news_config_gallery_order){ ?>
					<span class="error"><?php echo $error_news_config_gallery_order; ?></span>
				<?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_gallery_theme; ?></td>
				<td>
					<select name="news_config_gallerytheme">                         
						<?php foreach($themes as $theme) { ?>
							<option <?php if($news_config_gallerytheme == $theme){ echo 'selected="selectes"';} ?> value="<?php echo $theme;?>"><?php echo $theme; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="trhead"><td colspan="2"><?php echo $entry_gallery_albums; ?></td></tr>
			<tr>
				<td><span class="required">*</span><?php echo $entry_albumsperpage; ?></td>
				<td><input type="text" name="news_config_albumsperpage" size="3" value="<?php echo $news_config_albumsperpage; ?> "/>
				<?php if($error_news_config_albums_perpage){ ?>
					<span class="error"><?php echo $error_news_config_albums_perpage; ?></span>
				<?php } ?>
				</td>
			</tr>
			<tr>
              <td><span class="required">*</span><?php echo $entry_albumsthumbsetting; ?></td>
              <td><?php echo $entry_thumbsetting_w;?><input type="text" name="news_config_albumsthumb_w" value="<?php echo $news_config_albumsthumb_w; ?>" size="3" />&nbsp;&nbsp;<?php echo $entry_thumbsetting_h;?><input type="text" name="news_config_albumsthumb_h" value="<?php echo $news_config_albumsthumb_h; ?>" size="3" />
                <?php if ($error_news_config_albumsthumb) { ?>
                <span class="error"><?php echo $error_news_config_albumsthumb; ?></span>
                <?php } ?>
			  </td>
            </tr>
			<!--option --->
			<tr>
				<td><?php echo $entry_gallerysub; ?></td>
				<td><input type="radio" name="news_config_gallerysub" value="1" <?php if($news_config_gallerysub==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_gallerysub" value="0" <?php if($news_config_gallerysub==0) echo 'checked';?> /> <?php echo $entry_news_no; ?></td>
			</tr>
			<tr>
				<td><?php echo $entry_gallery_showcreatdate; ?></td>
				<td><input type="radio" name="news_config_gallery_creatdate" value="1" <?php if($news_config_gallery_creatdate==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_gallery_creatdate" value="0" <?php if($news_config_gallery_creatdate==0) echo 'checked';?> /> <?php echo $entry_news_no; ?></td>
			</tr>
			<tr>
				<td><?php echo $entry_gallery_showcount; ?></td>
				<td><input type="radio" name="news_config_gallery_count" value="1" <?php if($news_config_gallery_count==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_gallery_count" value="0" <?php if($news_config_gallery_count==0) echo 'checked';?> /> <?php echo $entry_news_no; ?></td>
			</tr>
			<tr>
				<td><?php echo $entry_gallery_showvote; ?></td>
				<td><input type="radio" name="news_config_gallery_vote" value="1" <?php if($news_config_gallery_vote==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_gallery_vote" value="0" <?php if($news_config_gallery_vote==0) echo 'checked';?> /> <?php echo $entry_news_no; ?></td>
			</tr>
			<tr class="trhead"><td colspan="2"><?php echo $entry_gallery_images; ?></td></tr>
			<tr>
				<td><span class="required">*</span><?php echo $entry_imagesperpage; ?></td>
				<td><input type="text" name="news_config_imagesperpage" size="3" value="<?php echo $news_config_imagesperpage; ?> "/>
				<?php if($error_news_config_images_perpage){ ?>
					<span class="error"><?php echo $error_news_config_images_perpage; ?></span>
				<?php } ?>
				</td>
			</tr>
			
			<tr>
              <td><span class="required">*</span><?php echo $entry_imagesthumbsetting; ?></td>
              <td><?php echo $entry_thumbsetting_w;?><input type="text" name="news_config_imagesthumb_w" value="<?php echo $news_config_imagesthumb_w; ?>" size="3" />&nbsp;&nbsp;<?php echo $entry_thumbsetting_h;?><input type="text" name="news_config_imagesthumb_h" value="<?php echo $news_config_imagesthumb_h; ?>" size="3" />
                <?php if ($error_news_config_imagesthumb) { ?>
                <span class="error"><?php echo $error_news_config_imagesthumb; ?></span>
                <?php } ?>
			  </td>
            </tr>
			<!--- End For Gallery -->
		
			<tr class="trhead">
				<td colspan="2"><?php echo $head_comment; ?></td>
			</tr>
			<tr>
				<td><span class="required">*</span><?php echo $entry_commentperpage; ?></td>
				<td><input type="text" name="news_config_commentperpage" size="3" value="<?php echo $news_config_commentperpage;?> "/>
				 <?php if ($error_news_config_comment_perpage) { ?>
                <span class="error"><?php echo $error_news_config_comment_perpage; ?></span>
                <?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showfield_title;?></td>
				<td>
					<input type="radio" name="news_config_show_field_title" value="1" <?php if($news_config_show_field_title==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_show_field_title" value="0" <?php if($news_config_show_field_title==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_showfield_website;?></td>
				<td>
					<input type="radio" name="news_config_show_field_website" value="1" <?php if($news_config_show_field_website==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_show_field_website" value="0" <?php if($news_config_show_field_website==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_show_gravatar;?></td>
				<td>
					<input type="radio" name="news_config_show_gravatar" value="1" <?php if($news_config_show_gravatar==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_show_gravatar" value="0" <?php if($news_config_show_gravatar==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr id="gravatarrs">
				<td><span class="required">*</span><?php echo $entry_gravatar_resize;?></td>
				<td>
					<?php echo $entry_thumbsetting_w;?><input type="text" name="news_config_gravatar_w" value="<?php echo $news_config_gravatar_w; ?>" size="3" />&nbsp;&nbsp;<?php echo $entry_thumbsetting_h;?><input type="text" name="news_config_gravatar_h" value="<?php echo $news_config_gravatar_h; ?>" size="3" />
                <?php if ($error_gravatar_thumb) { ?>
                <span class="error"><?php echo $error_gravatar_thumb; ?></span>
                <?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_autopublish;?></td>
				<td>
					<input type="radio" name="news_config_comment_autopublish" value="1" <?php if($news_config_comment_autopublish==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_comment_autopublish" value="0" <?php if($news_config_comment_autopublish==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_automail;?></td>
				<td>
					<input type="radio" name="news_config_comment_automail" value="1" <?php if($news_config_comment_automail==1) echo 'checked';?>/> <?php echo $entry_news_yes; ?>
					<input type="radio" name="news_config_comment_automail" value="0" <?php if($news_config_comment_automail==0) echo 'checked';?>/> <?php echo $entry_news_no; ?>
				</td>
			</tr>
			<tr class="trhead"><td colspan="2"><?php echo $head_article; ?></td></tr>
			<tr>
				<td><?php echo $entry_article_sharescript; ?></td>
				<td>
					<textarea rows="5" cols="70" name="news_config_article_sharescript"><?php echo $news_config_article_sharescript; ?></textarea>
				</td>
			</tr>
          </table>
        </div>
      </form>
    </div>
<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
</div>

<script type="text/javascript"><!--

 if ($('input:radio[name=news_config_show_gravatar]:checked').val() == 1)
     	$('#gravatarrs').show();
    else
        $('#gravatarrs').hide();

$('input:radio[name=news_config_show_gravatar]').change(function(){
    if ($('input:radio[name=news_config_show_gravatar]:checked').val() == 1)
     	$('#gravatarrs').show();
    else
        $('#gravatarrs').hide();
});
 
 
 if ($('input:radio[name=news_config_gallerytop]:checked').val() == 1)
     	$('#gallery-order').show();
    else
        $('#gallery-order').hide();

$('input:radio[name=news_config_gallerytop]').change(function(){
    if ($('input:radio[name=news_config_gallerytop]:checked').val() == 1)
     	$('#gallery-order').show();
    else
        $('#gallery-order').hide();
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<style type="text/css">
	tr.trhead
	{
		background:#EFEFEF;
		font-size:14px;
		font-weight:bold;
		border:1px solid #ddd;
	}
</style>
<?php echo $footer; ?>