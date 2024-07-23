<?php

namespace Derralf\Elements\SlickSlider\Model;

use Derralf\Elements\SlickSlider\Element\ElementSlickSliderHolder;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;


class ElementSlickSliderItem extends DataObject
{


    private static $table_name = 'ElementSlickSliderItem';

    private static $singular_name = 'Slide';
    private static $plural_name = 'Slides';
    private static $description = '';


    private static $extensions = [
        Versioned::class
    ];

    private static $db = [
        'ShowTitle' => 'Boolean',
        'Title'     => 'Varchar(255)',
        'Content'   => 'HTMLText',
        'Style' => 'Varchar(255)',
        'Sort' => 'Int'
    ];

    private static $has_one = [
        'TeaserHolder'  => ElementSlickSliderHolder::class,
        'Image' => Image::class,
        'ReadMoreLink' => Link::Class

    ];

    private static $has_many = [
        //'MyOtherDataObjects' => MyOtherDataObject::class
    ];

    private static $many_many = [];

    private static $belongs_many_many = [];

    private static $owns = [
        'Image',
    ];

    private static $defaults = [
        'ShowTitle' => true
    ];

    private static $use_content = false;

    private static $default_sort = 'Sort ASC';

    private static $field_labels = [
        'Title'                   => 'Titel',
        'Content.LimitCharacters' => 'Inhalt',
        'Content'                 => 'Inhalt',
        'Image'                   => 'Bild',
        'Image.CMSThumbnail'      => 'Bild',
        'ReadMoreLink'            => 'Link',
        'ReadMoreLink.LinkURL'    => 'Link',
        'Sort'                    => 'Sortierung'
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail',
        'Title',
        'Content.LimitCharacters',
        'ReadMoreLink.URL'
    ];

    private static $searchable_fields = [
        'Title'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            // Remove relationship fields
            $fields->removeByName('Sort');
            $fields->removeByName('TeaserHolderID');

            // ShowTitle
            $ShowTitle = $fields->dataFieldByName('ShowTitle');
            $ShowTitle->setDescription( 'Titel (und je nach Konfiguration/Layout auch INhalt) anzeigen?');;

            // Content
            $fields->dataFieldByName('Content')->setRows(5);
            if (!$this->useContent()) {
                $fields->removeByName('Content');
            }

            // ReadMoreLink: use Linkfield
            $ReadMoreLink = LinkField::create('ReadMoreLink', 'Link');
            $fields->replaceField('ReadMoreLinkID', $ReadMoreLink);

            // Styles (Color/CSS-Selector)
            $styles = $this->config()->get('styles');
            if ($styles && count($styles) > 0) {
                $styleDropdown = DropdownField::create('Style', _t(__CLASS__.'.STYLE', 'Style variation'), $styles);
                $fields->insertBefore('Content',$styleDropdown);
                $styleDropdown->setEmptyString(_t(__CLASS__.'.CUSTOM_STYLES', 'Select a style..'));
            } else {
                $fields->removeByName('Style');
            }

            // Image Upload konfigurieren
            // --------------------------------------------------------------------------------
            $Image = new UploadField('Image', 'Bild');
            $Image->setFolderName('element-slick-slider-image');
            $Image->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));
            $Image->getValidator()->setAllowedMaxFileSize((2 * 1024 * 1024));  // 2MB
            $Image->setDescription('Optional: Bild für Anzeige hinterlegen<br>Erlaubte Dateiformate: jpg, png, gif<br>Erlaubte Dateigröße: max. 2MB<br>Bildgröße/Format: für das Vorschaubild wird automatisch ein Ausschnitt erstellt/errechnet (Format/seitenverhältnis durch Template festgelegt)<br>Bei Bedarf kann der Focus für das Vorschau-Bild gesetzt werden: Bild > Bearbeiten > Focus Point setzen > speichern<br>Achtung! Bild speichern und Datensatz speichern sind verschiedene Buttons/Funktionen');
            $fields->replaceField('Image', $Image);


        });

        $fields = parent::getCMSFields();
        return $fields;
    }

    /**
     * @return bool
     */
    public function useContent()
    {
        if ($this->config()->get('use_content')) {
            return true;
        }
    }




    /**
     * @return string
     */
    public function ReadmoreLinkClass() {
        return $this->config()->get('readmore_link_class');
    }




    /**
     * @return null
     */
    public function getPage()
    {
        $page = null;

        if ($this->TeaserHolder()) {
            if ($this->TeaserHolder()->hasMethod('getPage')) {
                $page = $this->TeaserHolder()->getPage();
            }
        }
        return $page;

    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @return boolean
     */
    public function canView($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canView($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canEdit($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canEdit($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * Uses archive not delete so that current stage is respected i.e if a
     * element is not published, then it can be deleted by someone who doesn't
     * have publishing permissions.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canDelete($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canArchive($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @param array $context
     *
     * @return boolean
     */
    public function canCreate($member = null, $context = array())
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }




}
