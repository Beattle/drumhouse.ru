<?php echo $header; ?>
<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      	<table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><input type="text" name="name" value="<?php echo $name; ?>" size="70" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_code; ?></td>
              <td>
                <input type="text" name="code" value="<?php echo $code; ?>" size="20" />
                <input type="hidden" name="preview_url" value="<?php echo $image; ?>" id="preview_url" size="70" />
                <a onclick="createPreview();" class="button"><span><?php echo $text_preview; ?></span></a>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td valign="top">
                <img src="<?php echo $preview; ?>" alt="" id="preview" class="image" width="160" height="135" onclick="image_upload('image', 'preview');" />
                <br />
                <input type="text" name="image" value="<?php echo $image; ?>" id="image" size="70" />
                <a onclick="$('#preview').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');" class="button"><span><?php echo $text_clear; ?></span></a>
              </td>
            </tr>
            <tr>
                <td><?php echo $entry_description; ?></td>
                <td><textarea name="description" id="description"><?php echo isset($description) ? $description : ''; ?></textarea></td>
              </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['category_id'], $video_category)) { ?>
                    <input type="checkbox" name="video_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="video_category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $video_store)) { ?>
                    <input type="checkbox" name="video_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="video_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $video_store)) { ?>
                    <input type="checkbox" name="video_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="video_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            
            <tr>
              <td><?php echo $entry_related; ?></td>
              <td><input type="text" name="related" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div class="scrollbox" id="video-related">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($video_related as $video_related) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="video-related<?php echo $video_related['video_id']; ?>" class="<?php echo $class; ?>"> <?php echo $video_related['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="video_related[]" value="<?php echo $video_related['video_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function createPreview() {
    var url  = 'http://img.youtube.com/vi/';
    var code = $("[name='code']").val();

    url = url + code + '/0.jpg';
    $('#preview_url').attr('value', url);

    $.ajax({
    	url: 'index.php?route=catalog/video/upload&token=<?php echo $token; ?>&url=' +  encodeURIComponent(url) + '&code=' +  encodeURIComponent(code),
    	dataType: 'json',
    	success: function(json) {
            //alert(json['image']);
            //alert(json['image_url']);
            $('#preview').attr('src', json['image_url']);
            $('#image').attr('value', json['image']);
    	},
        error: function(json) {
            alert('error');
    	}
    });

};
//--></script>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--

CKEDITOR.replace('description', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});

//--></script>

<script type="text/javascript"><!--
$('input[name=\'related\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/video/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.video_id
					}
				}));
			}
		});

	}, 
	select: function(event, ui) {
		$('#video-related' + ui.item.value).remove();
		
		$('#video-related').append('<div id="video-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="video_related[]" value="' + ui.item.value + '" /></div>');

		$('#video-related div:odd').attr('class', 'odd');
		$('#video-related div:even').attr('class', 'even');
				
		return false;
	}
});

$('#video-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#video-related div:odd').attr('class', 'odd');
	$('#video-related div:even').attr('class', 'even');	
});
//--></script>

<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ( $('#' + field).val()) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" width="160" height="135" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>
<?php echo $footer; ?>