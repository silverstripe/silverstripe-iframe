<?php

class IFramePage extends Page {
	static $db = array(
		'IFrameUrl' => 'Text',
		'DynamicHeight' => 'Boolean',
		'FixedHeight' => 'Int',
		'AlternateContent' => 'HTMLText',
		'BottomContent' => 'HTMLText'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main', 'Content');
		$fields->addFieldToTab('Root.Main', new TextField('IFrameUrl', 'IFrame URL'));
		$fields->addFieldToTab('Root.Main', new CheckboxField('DynamicHeight', 'Dynamically resize the IFrame height (this doesn\'t work if IFrame URL is on a different domain)'));
		$fields->addFieldToTab('Root.Main', new NumericField('FixedHeight', 'Fixed Height (in pixels)'));
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('Content', 'Content (appears above IFrame)'));
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('BottomContent', 'Content (appears below IFrame)'));
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('AlternateContent', 'Alternate Content (appears when user has IFrames disabled)'));

		return $fields;
	}
}

class IFramePage_Controller extends Page_Controller {
	function init() {
		parent::init();

		if ($this->DynamicHeight) {
			Requirements::customScript(<<<SCRIPT

				if (typeof jQuery!=='undefined') {
					jQuery(function($) {
						var iframe = $('iframe.iframeautosize');
						iframe.load(function() {
							var iframeSize = $(iframe[0].contentWindow.document.body).height();
							iframeSize = (parseInt(iframeSize)+100)+'px';
							iframe.attr('height', iframeSize);
						});
					});
				}

SCRIPT
			);
		}
	}
}
