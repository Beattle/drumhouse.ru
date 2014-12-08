<?php
class ModelNewsInstall extends Model
{
	public function install()
	{
		$this->db->query("DELETE FROM " .DB_PREFIX. "setting WHERE `group`='newssetting'");
		$this->db->query("INSERT INTO " .DB_PREFIX. "setting VALUES (NULL, 0, 'newssetting', 'news_config_article_sharescript', '&lt;!-- AddThis Button BEGIN --&gt;\r\n&lt;div class=&quot;addthis_toolbox addthis_default_style &quot;&gt;\r\n&lt;a class=&quot;addthis_button_facebook_like&quot; fb:like:layout=&quot;button_count&quot;&gt;&lt;/a&gt;\r\n&lt;a class=&quot;addthis_button_tweet&quot;&gt;&lt;/a&gt;\r\n&lt;a class=&quot;addthis_counter addthis_pill_style&quot;&gt;&lt;/a&gt;\r\n&lt;/div&gt;\r\n&lt;script type=&quot;text/javascript&quot; src=&quot;http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e3bc9f52f94dc69&quot;&gt;&lt;/script&gt;\r\n&lt;!-- AddThis Button END --&gt;', 0)
		,(NULL, 0, 'newssetting', 'news_config_article_showvote', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_article_showdate', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_comment_autopublish', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_gravatar_h', '60', 0)
		,(NULL, 0, 'newssetting', 'news_config_gravatar_w', '60', 0)
		,(NULL, 0, 'newssetting', 'news_config_show_gravatar', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_show_field_website', '0', 0)
		,(NULL, 0, 'newssetting', 'news_config_show_field_title', '0', 0)
		,(NULL, 0, 'newssetting', 'news_config_showcommentcount', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_showreadmore', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_commentperpage', '10', 0)
		,(NULL, 0, 'newssetting', 'news_config_datetime', 'd-m-Y H:i:s', 0)
		,(NULL, 0, 'newssetting', 'news_config_item', '10', 0)
		,(NULL, 0, 'newssetting', 'news_config_catthumb_w', '120', 0)
		,(NULL, 0, 'newssetting', 'news_config_catthumb_h', '120', 0)
		,(NULL, 0, 'newssetting', 'news_config_desc_limit', '550', 0)
		,(NULL, 0, 'newssetting', 'news_config_subcategory', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_imagesthumb_h', '100', 0)
		,(NULL, 0, 'newssetting', 'news_config_imagesperpage', '10', 0)
		,(NULL, 0, 'newssetting', 'news_config_imagesthumb_w', '200', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallery_vote', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallery_count', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallery_creatdate', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallerysub', '1', 0)
		,(NULL, 0, 'newssetting', 'news_config_albumsthumb_h', '100', 0)
		,(NULL, 0, 'newssetting', 'news_config_albumsthumb_w', '200', 0)
		,(NULL, 0, 'newssetting', 'news_config_albumsperpage', '10', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallerytheme', 'pp_default', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallery_order', '10', 0)
		,(NULL, 0, 'newssetting', 'news_config_gallerytop', '1', 0)	
		,(NULL, 0, 'newscms', 'news_version', '1.4', 0)");
		
		 $this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news");
		 $this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news (
				  `news_id` int(11) NOT NULL auto_increment,
				  `news_image` varchar(255) default NULL,
				  `news_status` tinyint(1) NOT NULL default '0',
				  `news_sort_order` int(11) NOT NULL,
				  `news_date_added` datetime NOT NULL,
				  `news_date_modified` datetime NOT NULL,
				  `news_viewed` int(11) NOT NULL,
				  `news_comment` tinyint(1) NOT NULL default '1',
				  `news_top` tinyint(1) NOT NULL default '0',
				  `news_vote` int(11) NOT NULL,
				  `news_showdate` tinyint(1) NOT NULL default '1',
				  `news_showvote` tinyint(1) NOT NULL default '1',
				  `news_showview` tinyint(1) NOT NULL default '1',
				  `news_showrelated` tinyint(1) NOT NULL default '1',
				  `news_showproduct` tinyint(1) NOT NULL default '1',
				  PRIMARY KEY  (`news_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
				
		 $this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category");
		 $this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_category (
				  `news_category_id` int(11) NOT NULL auto_increment,
				  `news_category_image` varchar(255) default NULL,
				  `news_category_parent_id` int(11) NOT NULL,
				  `news_category_top` tinyint(1) NOT NULL default '0',
				  `news_category_column` int(3) NOT NULL,
				  `news_category_sort_order` int(3) NOT NULL default '0',
				  `news_category_status` tinyint(1) NOT NULL,
				  `news_category_date_added` datetime NOT NULL,
				  `news_category_date_modified` datetime NOT NULL,
				  PRIMARY KEY  (`news_category_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
				
		 $this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category_description");
		 $this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_category_description(
				  `news_category_id` int(11) NOT NULL,
				  `language_id` int(11) NOT NULL,
				  `news_category_name` varchar(255) NOT NULL,
				  `news_category_description` text NOT NULL,
				  `news_category_meta_description` varchar(255) NOT NULL,
				  `news_category_meta_keyword` varchar(255) NOT NULL,
				  PRIMARY KEY  (`news_category_id`,`language_id`),
				  KEY `news_category_name` (`news_category_name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8");


			$this->db->query("DROP TABLE IF EXISTS ".DB_PREFIX."news_category_to_layout");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_category_to_layout (
				  `news_category_id` int(11) NOT NULL,
				  `store_id` int(11) NOT NULL,
				  `layout_id` int(11) NOT NULL,
				  PRIMARY KEY  (`news_category_id`,`store_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8");

			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category_to_store");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_category_to_store (
			  `news_category_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_category_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");


			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_comment");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_comment(
			  `news_comment_id` int(11) NOT NULL auto_increment,
			  `news_news_id` int(11) NOT NULL,
			  `news_comment_author` varchar(255) NOT NULL,
			  `news_comment_status` tinyint(1) NOT NULL,
			  `news_comment_date_added` datetime NOT NULL,
			  `news_comment_date_modified` datetime NOT NULL,
			  `news_comment_text` text NOT NULL,
			  `news_comment_title` varchar(255) NOT NULL,
			  `news_comment_email` varchar(255) NOT NULL,
			  `news_comment_link` varchar(255) NOT NULL,
			  PRIMARY KEY  (`news_comment_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_description");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_description (
			  `news_id` int(11) NOT NULL auto_increment,
			  `language_id` int(11) NOT NULL,
			  `news_titles` varchar(255) NOT NULL,
			  `news_description` text NOT NULL,
			  `news_meta_description` varchar(255) NOT NULL,
			  `news_meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY  (`news_id`,`language_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
			
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_tag");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_tag (
			  `news_tag_id` int(11) NOT NULL auto_increment,
			  `news_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `news_tag` varchar(255) NOT NULL,
			  PRIMARY KEY  (`news_tag_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_to_category");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_to_category (
			  `news_id` int(11) NOT NULL,
			  `news_category_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`news_category_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
			
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_to_layout");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_to_layout (
			  `news_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
			
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_to_store");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_to_store (
			  `news_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
			
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_related");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_related (
			  `news_id` int(11) NOT NULL,
			  `related_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`related_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
			//update v4
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery (
			  `news_gallery_id` int(11) NOT NULL auto_increment,
			  `news_gallery_image` varchar(255) NOT NULL,
			  `news_gallery_status` tinyint(1) NOT NULL default '0',
			  `news_gallery_order` int(11) NOT NULL,
			  `news_gallery_added` datetime NOT NULL,
			  `news_gallery_modified` datetime NOT NULL,
			  `news_gallery_viewed` int(11) NOT NULL,
			  `news_gallery_vote` int(11) NOT NULL,
			  `news_gallery_showdate` tinyint(1) NOT NULL default '1',
			  `news_gallery_showvote` tinyint(1) NOT NULL default '1',
			  `news_gallery_showviewed` tinyint(1) NOT NULL default '1',
			  PRIMARY KEY  (`news_gallery_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album (
			  `news_gallery_album_id` int(11) NOT NULL auto_increment,
			  `news_gallery_album_image` varchar(255) default NULL,
			  `news_gallery_album_parent_id` int(11) NOT NULL,
			  `news_gallery_album_sort_order` int(11) NOT NULL,
			  `news_gallery_album_status` tinyint(1) NOT NULL,
			  `news_gallery_album_date_added` datetime NOT NULL,
			  `news_gallery_album_date_modified` datetime NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_description");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album_description (
			  `news_gallery_album_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `news_gallery_album_name` varchar(255) NOT NULL,
			  `news_gallery_album_description` text NOT NULL,
			  `news_gallery_album_meta_description` varchar(255) NOT NULL,
			  `news_gallery_album_meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`,`language_id`),
			  KEY `news_gallery_category_name` (`news_gallery_album_name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_to_layout");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album_to_layout (
			  `news_gallery_album_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_to_store");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album_to_store (
			  `news_gallery_album_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_description");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_description (
			  `news_gallery_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `news_gallery_titles` varchar(255) NOT NULL,
			  `news_gallery_description` text NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_album");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_to_album (
			  `news_gallery_id` int(11) NOT NULL,
			  `news_gallery_album_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`news_gallery_album_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_layout");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_to_layout (
			  `news_gallery_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_store");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_to_store (
			  `news_gallery_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_related_product");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_related_product (
			  `news_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");	
			
	}
	public function uninstall()
	{
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category_description");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category_to_layout");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_category_to_store");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_comment");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_description");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_tag");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_to_category");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_to_layout");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_to_store");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_related");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery");
		
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_description");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_to_layout");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_to_store");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_description");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_album");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_layout");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_store");
		$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_related_product");
		
		$this->db->query("DELETE FROM " .DB_PREFIX. "setting WHERE `group`='newssetting'");
		$this->db->query("DELETE FROM " .DB_PREFIX. "setting WHERE `group`='newscms'");
		$this->db->query("DELETE FROM " .DB_PREFIX. "setting WHERE `group`='newscategory' AND `key`='newscategory_module'");
		$this->db->query("DELETE FROM " .DB_PREFIX. "setting WHERE `group`='newsarticle' AND `key`='newsarticle_module'");
		
		$this->db->query("DELETE FROM " .DB_PREFIX. "extension WHERE `type`='module' AND `code`='newscategory'");
		$this->db->query("DELETE FROM " .DB_PREFIX. "extension WHERE `type`='module' AND `code`='newsarticle'");
	}
	public function update($version)
	{
		$this->load->model('setting/setting');
		//update for version 1.3
		if($version == '13')
		{
			$this->model_setting_setting->editSetting('newscms',array('news_version' => '1.3'));
			
			$this->db->query("
			ALTER TABLE ".DB_PREFIX."news ADD `news_showdate` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `news_vote` ,
			ADD `news_showvote` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `news_showdate` ,
			ADD `news_showview` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `news_showvote` ,
			ADD `news_showrelated` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `news_showview`");
			
			
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_related");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_related (
			  `news_id` int(11) NOT NULL,
			  `related_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`related_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		}
		if($version == '14'){
			
			$this->model_setting_setting->editSetting('newscms',array('news_version' => '1.4'));
			
			$this->db->query("
			ALTER TABLE ".DB_PREFIX."news ADD `news_showproduct` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `news_showrelated`");
			
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery (
			  `news_gallery_id` int(11) NOT NULL auto_increment,
			  `news_gallery_image` varchar(255) NOT NULL,
			  `news_gallery_status` tinyint(1) NOT NULL default '0',
			  `news_gallery_order` int(11) NOT NULL,
			  `news_gallery_added` datetime NOT NULL,
			  `news_gallery_modified` datetime NOT NULL,
			  `news_gallery_viewed` int(11) NOT NULL,
			  `news_gallery_vote` int(11) NOT NULL,
			  `news_gallery_showdate` tinyint(1) NOT NULL default '1',
			  `news_gallery_showvote` tinyint(1) NOT NULL default '1',
			  `news_gallery_showviewed` tinyint(1) NOT NULL default '1',
			  PRIMARY KEY  (`news_gallery_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album (
			  `news_gallery_album_id` int(11) NOT NULL auto_increment,
			  `news_gallery_album_image` varchar(255) default NULL,
			  `news_gallery_album_parent_id` int(11) NOT NULL,
			  `news_gallery_album_sort_order` int(11) NOT NULL,
			  `news_gallery_album_status` tinyint(1) NOT NULL,
			  `news_gallery_album_date_added` datetime NOT NULL,
			  `news_gallery_album_date_modified` datetime NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_description");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album_description (
			  `news_gallery_album_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `news_gallery_album_name` varchar(255) NOT NULL,
			  `news_gallery_album_description` text NOT NULL,
			  `news_gallery_album_meta_description` varchar(255) NOT NULL,
			  `news_gallery_album_meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`,`language_id`),
			  KEY `news_gallery_category_name` (`news_gallery_album_name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_to_layout");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album_to_layout (
			  `news_gallery_album_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_album_to_store");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_album_to_store (
			  `news_gallery_album_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_album_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_description");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_description (
			  `news_gallery_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `news_gallery_titles` varchar(255) NOT NULL,
			  `news_gallery_description` text NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_album");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_to_album (
			  `news_gallery_id` int(11) NOT NULL,
			  `news_gallery_album_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`news_gallery_album_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_layout");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_to_layout (
			  `news_gallery_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_gallery_to_store");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_gallery_to_store (
			  `news_gallery_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_gallery_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
			$this->db->query("DROP TABLE IF EXISTS " .DB_PREFIX. "news_related_product");
			$this->db->query("CREATE TABLE IF NOT EXISTS " .DB_PREFIX. "news_related_product (
			  `news_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  PRIMARY KEY  (`news_id`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		}
	}
}
?>
