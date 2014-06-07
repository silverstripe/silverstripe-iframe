<?php

class IFramePageTest extends SapphireTest {
	function testGetClass() {
		$iframe = new IFramePage();
		$iframe->AutoHeight = 1;
		$iframe->getClass();

		$this->assertContains('iframepage-height-auto', $iframe->getClass());

		$iframe->AutoHeight = 0;
		$iframe->getClass();

		$this->assertNotContains('iframepage-height-auto', $iframe->getClass());
	}

	function testGetStyle() {
		$iframe = new IFramePage();

		$iframe->FixedHeight = 0;
		$iframe->getStyle();
		$this->assertContains('height: 800px', $iframe->getStyle(), 'Height defaults to 800 if not set.');

		$iframe->FixedHeight = 100;
		$iframe->getStyle();
		$this->assertContains('height: 100px', $iframe->getStyle(), 'Fixed height is settable');

		$iframe->AutoWidth = 1;
		$iframe->FixedWidth = '200';
		$this->assertContains('width: 100%', $iframe->getStyle(), 'Auto width overrides fixed width');

		$iframe->AutoWidth = 0;
		$iframe->FixedWidth = '200';
		$this->assertContains('width: 200px', $iframe->getStyle(), 'Fixed width is settable');
	}

	public function testForceProtocol() {
		$origServer = $_SERVER;

		$page = new IFramePage();
		$page->URLSegment = 'iframe';
		$page->IFrameURL = 'http://target.com';

		Config::inst()->update('Director', 'alternate_protocol', 'http');
		Config::inst()->update('Director', 'alternate_base_url', 'http://host.com');
		$page->ForceProtocol = '';
		$controller = new IFramePage_Controller($page);
		$response = $controller->init();
		$this->assertNull($response);

		Config::inst()->update('Director', 'alternate_protocol', 'https');
		Config::inst()->update('Director', 'alternate_base_url', 'https://host.com');
		$page->ForceProtocol = '';
		$controller = new IFramePage_Controller($page);
		$response = $controller->init();
		$this->assertNull($response);

		Config::inst()->update('Director', 'alternate_protocol', 'http');
		Config::inst()->update('Director', 'alternate_base_url', 'http://host.com');
		$page->ForceProtocol = 'http://';
		$controller = new IFramePage_Controller($page);
		$response = $controller->init();
		$this->assertNull($response);

		Config::inst()->update('Director', 'alternate_protocol', 'http');
		Config::inst()->update('Director', 'alternate_base_url', 'http://host.com');
		$page->ForceProtocol = 'https://';
		$controller = new IFramePage_Controller($page);
		$response = $controller->init();
		$this->assertEquals($response->getHeader('Location'), 'https://host.com/iframe/');

		Config::inst()->update('Director', 'alternate_protocol', 'https');
		Config::inst()->update('Director', 'alternate_base_url', 'https://host.com');
		$page->ForceProtocol = 'http://';
		$controller = new IFramePage_Controller($page);
		$response = $controller->init();
		$this->assertEquals($response->getHeader('Location'), 'http://host.com/iframe/');

		$_SERVER = $origServer;
	}
}
