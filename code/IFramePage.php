<?php

class IFramePage extends Page {
	static $db = array(
		'IFrameUrl' => 'Text',
		'DynamicHeight' => 'Boolean',
		'FixedHeight' => 'Int'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root.Content.Main', 'Content');
		$fields->addFieldToTab('Root.Content.Main', new TextField('IFrameUrl', 'IFrame URL'));
		//$fields->addFieldToTab('Root.Content.Main', new CheckboxField('DynamicHeight', 'Dynamically resize the IFrame height (this doesn\'t work if IFrame URL is on a different domain)'));
		$fields->addFieldToTab('Root.Content.Main', new NumericField('FixedHeight', 'Fixed Height (in pixels)'));
		$fields->addFieldToTab('Root.Content.Main', new HtmlEditorField('Content', 'Alternate Content'));
		
		return $fields;
	}	
}

class IFramePage_Controller extends Page_Controller {
	function Height() {
		/*if($this->DynamicHeight) {
			return 'class="iframeautosize"';
		} else {*/
			return 'style="height: ' . $this->FixedHeight . 'px;"';
		//}
	}
}


?>
