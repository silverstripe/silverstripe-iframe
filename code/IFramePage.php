<?php
/**
 * Iframe page type embeds an iframe of URL of choice into the page.
 * CMS editor can choose width, height, or set it to attempt automatic size configuration.
 */

class IFramePage extends Page {
	static $db = array(
		'IFrameURL' => 'Text',
		'AutoHeight' => 'Boolean(1)',
		'AutoWidth' => 'Boolean(1)',
		'FixedHeight' => 'Int(500)',
		'FixedWidth' => 'Int(0)',
		'AlternateContent' => 'HTMLText',
		'BottomContent' => 'HTMLText'
	);

	static $defaults = array(
		'AutoHeight' => '1',
		'AutoWidth' => '1',
		'FixedHeight' => '500',
		'FixedWidth' => '0'
	);

	static $description = 'Embeds an iframe into the body of the page.';
	
	function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main', 'Content');
		$fields->addFieldToTab('Root.Main', $url = new TextField('IFrameURL', 'Iframe URL'), 'Metadata');
		$url->setRightTitle('Can be absolute (<em>http://silverstripe.com</em>) or relative to this site (<em>about-us</em>).');
		$fields->addFieldToTab('Root.Main', new CheckboxField('AutoHeight', 'Auto height (only works with same domain URLs)'), 'Metadata');
		$fields->addFieldToTab('Root.Main', new CheckboxField('AutoWidth', 'Auto width (100% of the available space)'), 'Metadata');
		$fields->addFieldToTab('Root.Main', new NumericField('FixedHeight', 'Fixed height (in pixels)'), 'Metadata');
		$fields->addFieldToTab('Root.Main', new NumericField('FixedWidth', 'Fixed width (in pixels)'), 'Metadata');
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('Content', 'Content (appears above iframe)'), 'Metadata');
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('BottomContent', 'Content (appears below iframe)'), 'Metadata');
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('AlternateContent', 'Alternate Content (appears when user has iframes disabled)'), 'Metadata');

		return $fields;
	}

	/**
	 * Compute class from the size parameters.
	 */
	function getClass() {
		$class = '';
		if ($this->AutoHeight) {
			$class .= 'iframepage-height-auto';
		}

		return $class;
	}

	/**
	 * Compute style from the size parameters.
	 */
	function getStyle() {
		$style = '';

		// Always add fixed height as a fallback if autosetting or JS fails.
		$height = $this->FixedHeight;
		if (!$height) $height = 800;
		$style .= "height: {$height}px; ";

		if ($this->AutoWidth) {
			$style .= "width: 100%; ";
		}
		else if ($this->FixedWidth) {
			$style .= "width: {$this->FixedWidth}px; ";
		}

		return $style;
	}

	/**
	 * Ensure that the IFrameURL is a valid url and prevents XSS
	 * 
	 * @throws ValidationException
	 * @return ValidationResult
	 */
	public function validate() {
		$result = parent::validate();

		//whitelist allowed URL schemes
		$allowed_schemes = array('http', 'https');
		if($matches = parse_url($this->IFrameURL)) {
			if(isset($matches['scheme']) && !in_array($matches['scheme'], $allowed_schemes)) {
				$result->error(_t('IFramePage.VALIDATION.BANNEDURLSCHEME', "This URL scheme is not allowed."));
			}
		}

		return $result;
	}
}

class IFramePage_Controller extends Page_Controller {
	function init() {
		parent::init();

		if ($this->IFrameURL) {
			Requirements::javascript('iframe/javascript/iframe_page.js');
		}
	}
}
