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
}
