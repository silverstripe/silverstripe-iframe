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
        $currentProtocol = Director::protocol();
        $desiredProtocol = $this->ForceProtocol;
        if ($desiredProtocol && $currentProtocol !== $desiredProtocol) {
            $enforcedLocation = preg_replace(
                "#^${currentProtocol}#",
                $desiredProtocol,
                $this->AbsoluteLink()
            );
            return $this->redirect($enforcedLocation);
        }

        if ($this->IFrameURL) {
            Requirements::javascript('silverstripe/iframe: javascript/iframe_page.js');
        }
    }
}
