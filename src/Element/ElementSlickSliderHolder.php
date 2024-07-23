<?php

namespace Derralf\Elements\SlickSlider\Element;

use Derralf\Elements\SlickSlider\Model\ElementSlickSliderItem;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\Tab;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ElementSlickSliderHolder extends BaseElement
{


    public function getType()
    {
        return self::$singular_name;
    }

    private static $icon = 'font-icon-block-content';

    private static $table_name = 'ElementSlickSliderHolder';

    private static $singular_name = 'Slick-Slider, einfach';
    private static $plural_name = 'Slick-Sliders, einfach';
    private static $description = '';

    private static $db = [
        'HTML'                => 'HTMLText',
        'SlickCarouselConfig' => 'Text'
    ];


    private static $has_one = [
    ];

    private static $has_many = [
        'Slides' => ElementSlickSliderItem::class
    ];

    private static $many_many = [
    ];

    // this adds the SortOrder field to the relation table.
    private static $many_many_extraFields = [
    ];

    private static $belongs_many_many = [];

    private static $owns = [
        //'Teasers'
    ];

    private static $defaults = [
    ];

    private static $colors = [];


    private static $field_labels = [
        'Title' => 'Titel',
        'Sort' 	=>	'Sortierung'
    ];

    public function updateFieldLabels(&$labels)
    {
        parent::updateFieldLabels($labels);
        $labels['HTML'] = _t(__CLASS__ . '.ContentLabel', 'Content');
        $labels['Slides'] = _t(__CLASS__ . '.SlidesLabel', 'Slides');
    }

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {


            // Style: Description for default style (describes Layout thats used, when no special style is selected)
            $Style = $fields->dataFieldByName('Style');
            $StyleDefaultDescription = $this->owner->config()->get('styles_default_description', Config::UNINHERITED);
            if ($Style && $StyleDefaultDescription) {
                $Style->setDescription($StyleDefaultDescription);
            }

            if ($this->ID) {
                $SlidesGridfield = $fields->dataFieldByName('Slides');
                $SlidesGridfieldConfig = $SlidesGridfield->getConfig();
                $SlidesGridfieldConfig->removeComponentsByType('GridFieldDeleteAction');
                $SlidesGridfieldConfig->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                $SlidesGridfieldConfig->addComponent(new GridFieldAddExistingSearchButton());
                $SlidesGridfieldConfig->addComponent(new GridFieldOrderableRows('Sort'));
            }

            $SlickCarouselConfigField = $fields->dataFieldByName('SlickCarouselConfig');
            if ($SlickCarouselConfigField) {
                // Media Tab (before Settings Tab)
                $fields->insertAfter('Slides', new Tab('CarouselConfig', 'Carousel Konfiguration'));
                $fields -> removeByName ('SlickCarouselConfig');
                $fields -> addFieldToTab('Root.CarouselConfig', $SlickCarouselConfigField);
                $SlickCarouselConfigField->setDescription('Standard:<br><code>' . Config::inst()->get(__CLASS__, 'slick_carousel_default_config') . '</code><br>kann hier überschrieben werden');
            }



        });
        $fields = parent::getCMSFields();

        return $fields;
    }


    public function ReadmoreLinkClass() {
        return $this->config()->get('readmore_link_class');
    }

    public function SlickCarouselConfigDataAtt() {
        $default = Config::inst()->get(__CLASS__, 'slick_carousel_default_config');
        $string = ($this->SlickCarouselConfig) ? $this->SlickCarouselConfig : $default;
        //$stwring = str_replace(' ', '', $string);
        // //$arr = explode(',', $string);
        // //$string = '"' . implode('","',$arr) . '"';
        return $string;
    }




}
