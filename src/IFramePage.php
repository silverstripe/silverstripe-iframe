<?php

namespace SilverStripe\IFrame;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\ValidationResult;

/**
 * Iframe page type embeds an iframe of URL of choice into the page.
 * CMS editor can choose width, height, or set it to attempt automatic size configuration.
 */

class IFramePage extends Page
{
    private static $db = array(
        'ForceProtocol' => 'Varchar',
        'IFrameURL' => 'Text',
        'IFrameTitle' => 'Varchar',
        'AutoHeight' => 'Boolean(1)',
        'AutoWidth' => 'Boolean(1)',
        'FixedHeight' => 'Int(500)',
        'FixedWidth' => 'Int(0)',
        'BottomContent' => 'HTMLText',
        'AlternateContent' => 'HTMLText',
    );

    private static $defaults = array(
        'AutoHeight' => '1',
        'AutoWidth' => '1',
        'FixedHeight' => '500',
        'FixedWidth' => '0'
    );

    private static $table_name = 'IFramePage';

    private static $description = 'Embeds an iframe into the body of the page.';

    private static $singular_name = 'IFrame Page';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->replaceField(
                'IFrameURL',
                TextField::create('IFrameURL', $this->fieldLabel('IFrameURL'))
                ->setRightTitle(
                    DBField::create_field(
                        'HTMLText',
                        'Can be absolute (<em>http://silverstripe.com</em>) '
                        . 'or relative to this site (<em>about-us</em>).'
                    )
                )
            );
            $fields->dataFieldByName('IFrameTitle')
                ->setDescription(_t(__CLASS__ . '.TITLE_DESCRIPTION', 'Used by screen readers'));
            $fields->replaceField(
                'ForceProtocol',
                DropdownField::create('ForceProtocol', $this->fieldLabel('ForceProtocol'))
                    ->setSource(array('http://' => 'http://', 'https://' => 'https://'))
                    ->setEmptyString('')
                    ->setDescription(
                        'Avoids mixed content warnings when iframe content is just available under a specific protocol'
                    )
            );

            $contentField = $fields->dataFieldByName('Content');
            if ($contentField) {
                $fields->removeByName('Content');
                $contentField->setTitle(_t(__CLASS__ . '.db_Content', 'Content (appears above iframe)'));
                $fields->addFieldToTab('Root.Main', $contentField, 'BottomContent');
            }
            $fields->dataFieldByName('BottomContent')?->addExtraClass('stacked');
            $fields->dataFieldByName('AlternateContent')?->addExtraClass('stacked');
        });
        return parent::getCMSFields();
    }

    /**
     * Compute class from the size parameters.
     */
    public function getClass()
    {
        $class = '';
        if ($this->AutoHeight) {
            $class .= 'iframepage-height-auto';
        }

        return $class;
    }

    /**
     * Compute style from the size parameters.
     */
    public function getStyle()
    {
        $style = '';

        // Always add fixed height as a fallback if autosetting or JS fails.
        $height = $this->FixedHeight;
        if (!$height) {
            $height = 800;
        }
        $style .= "height: {$height}px; ";

        if ($this->AutoWidth) {
            $style .= "width: 100%; ";
        } elseif ($this->FixedWidth) {
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
    public function validate()
    {
        $result = parent::validate();

        //whitelist allowed URL schemes
        $allowed_schemes = array('http', 'https');
        if ($matches = parse_url($this->IFrameURL ?? '')) {
            if (isset($matches['scheme']) && !in_array($matches['scheme'], $allowed_schemes ?? [])) {
                $result->addError(_t(__CLASS__ . '.VALIDATION_BANNEDURLSCHEME', "This URL scheme is not allowed."));
            }
        }

        return $result;
    }
}
