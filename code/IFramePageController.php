<?php

namespace SilverStripe\IFrame;

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;

class IFramePageController extends ContentController
{
    protected function init()
    {
        parent::init();

        if ($this->ForceProtocol) {
            if ($this->ForceProtocol == 'http://' && Director::protocol() != 'http://') {
                return $this->redirect(preg_replace('#https://#', 'http://', $this->AbsoluteLink()));
            } elseif ($this->ForceProtocol == 'https://' && Director::protocol() != 'https://') {
                return $this->redirect(preg_replace('#http://#', 'https://', $this->AbsoluteLink()));
            }
        }

        if ($this->IFrameURL) {
            Requirements::javascript('iframe/javascript/iframe_page.js');
        }
    }
}
