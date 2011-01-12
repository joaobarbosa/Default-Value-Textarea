<?php

	if(!defined('__IN_SYMPHONY__')) die('<h2>Symphony Error</h2><p>You cannot directly access this file</p>');

	include_once( TOOLKIT . '/fields/field.textarea.php');
	
	Class fielddefault_value_textarea extends fieldTextarea{
	
		function __construct(&$parent){

			parent::__construct($parent);
			$this->_name = __('Default Value Textarea');		
			$this->_required = true;

			$this->set('show_column', 'no');
			$this->set('required', 'yes');
		}

		public function displaySettingsPanel(&$wrapper, $errors = null) {

			parent::displaySettingsPanel($wrapper, $errors);

			$group = new XMLElement('div', NULL, array('class' => 'group'));

			$div = new XMLElement('div');

			# Default Value Field
			$label = Widget::Label();
			$label->setValue(__('Textarea default value:'));

			$textarea = Widget::Textarea('fields['.$this->get('sortorder').'][default-value]', 5, 50, $this->get('default-value'));

			$div->appendChild($label);
			$div->appendChild($textarea);

			$group->appendChild($div);
			$wrapper->appendChild($group);
		}
		
		function findDefaults(&$fields){
			if(!isset($fields['size'])) $fields['size'] = 15;				
			if(!isset($fields['default-value'])) $fields['default-value'] = 'Type your text here.';				
		}
		
		function commit(){

			if(!parent::commit()) return false;

			$id = $this->get('id');

			if($id === false) return false;

			$fields = array();

			$fields['field_id'] = $id;
			if($this->get('formatter') != 'none') $fields['formatter'] = $this->get('formatter');
			$fields['size'] = $this->get('size');
			$fields['default-value'] = $this->get('default-value');

			$this->_engine->Database->query("DELETE FROM `tbl_fields_".$this->handle()."` WHERE `field_id` = '$id' LIMIT 1");		
			return $this->_engine->Database->insert($fields, 'tbl_fields_' . $this->handle());
		}

		function displayPublishPanel(&$wrapper, $data=NULL, $flagWithError=NULL, $fieldnamePrefix=NULL, $fieldnamePostfix=NULL){
			$label = Widget::Label($this->get('label'));
			if($this->get('required') != 'yes') $label->appendChild(new XMLElement('i', __('Optional')));

			$textarea = Widget::Textarea('fields'.$fieldnamePrefix.'['.$this->get('element_name').']'.$fieldnamePostfix, $this->get('size'), '50', (strlen($data['value']) != 0 ? General::sanitize($data['value']) : $this->_fields['default-value']));

			if($this->get('formatter') != 'none') $textarea->setAttribute('class', $this->get('formatter'));

			$this->_engine->ExtensionManager->notifyMembers('ModifyTextareaFieldPublishWidget', '/backend/', array('field' => &$this, 'label' => &$label, 'textarea' => &$textarea));

			$label->appendChild($textarea);

			if($flagWithError != NULL) $wrapper->appendChild(Widget::wrapFormElementWithError($label, $flagWithError));
			else $wrapper->appendChild($label);
		}
	}