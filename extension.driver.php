<?php

	require_once(TOOLKIT . '/class.entrymanager.php');
	
	
	Class extension_default_value_textarea extends Extension{
	
		public function install(){
			return $this->_Parent->Database->query("CREATE TABLE `tbl_fields_default_value_textarea` (
				`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`field_id` INT( 11 ) UNSIGNED NOT NULL ,
				`formatter` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
				`size` INT( 3 ) UNSIGNED NOT NULL,
				`default-value` TEXT NULL
				)
			");
		}
		
		public function uninstall(){
			return $this->_Parent->Database->query("DROP TABLE `tbl_fields_default_value_textarea`");
		}
	}

?>
