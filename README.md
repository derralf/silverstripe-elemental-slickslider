# SilverStripe Elemental Slick-Sliders Block

A block that displays basic Slick Carousel  
(private project, no help/support provided)

## Requirements

* SilverStripe CMS ^5
* dnadesign/silverstripe-elemental ^4 || ^5
* silverstripe/linkfield ^4
* jonom/focuspoint ^5
* symbiote/silverstripe-gridfieldextensions ^4

Important:  
You have to add the Slick CSS/JS files and jQuery to your project yourself.  
You also have to initialize the carousel yourself (e.g.`$('.element-slick-slider').slick({rows: 0});`).  
Some sample templates for Bootstrap 5 are included, you may adjust them to your needs.


## Suggestions
* derralf/elemental-styling

Modify `/templates/Derralf/Elements/Slickslider/Includes/Title.ss` to your needs when using StyledTitle from derralf/elemental-styling.


## Installation

- Install the module via Composer
  ```
  composer require derralf/elemental-slickslider
  ```


## Configuration

A basic/default config. Add this to your **mysite/\_config/elements.yml** and comment/uncomment/add/remove/modify the needed lines 

Note the options for `styles` and `image_view_modes`, in which the templates contained in the extension are listed.

Optionally you may set `defaults:Style`to any of the available `styles`.

```

---
Name: elementalslickslider
---
Derralf\Elements\SlickSlider\Element\ElementSlickSliderHolder:
  slick_carousel_default_config: '{"speed":200,"dots":false,"infinite":true,"slidesToShow":5,"centerMode":false,"variableWidth":false,"adaptiveHeight":true,"responsive":[{"breakpoint":1200,"settings":{"slidesToShow": 1}},{"breakpoint":992,"settings":{},{"breakpoint":768,"settings":{}},{"breakpoint":600,"settings":{}}]}'
  # add StyledTitle
  extensions:
    - Derralf\ElementalStyling\StyledTitle
  # disable StyledTitle
  title_tag_variants: null
  title_alignment_variants: null
  # styles
  style_default_description: 'Standard: 100% Content-Breite'
  styles:
    BS5RightFiftyFifty: "BS5 Slider rechts, 50%"
    BS5LeftFiftyFifty: "BS5 Slider links, 50%"

Derralf\Elements\SlickSlider\Model\ElementSlickSliderItem:
  use_content: true
  readmore_link_class: 'btn btn-sm btn-primary btn-readmore'
  styles:
    default: 'default'
    bottom-left: 'links unten'
    center-center: 'zentriert'
    grey: 'grau'
    primary: 'petrol'
    primary-dark: 'petrol dunkel'
    secondary: 'grün'
  
```

Additionally you may apply the default styles:

```
# add default styles
DNADesign\Elemental\Controllers\ElementController:
  default_styles:
    - derralf/elemental-slickslider:client/dist/styles/frontend-default.css
```

See Elemental Docs for [how to disable the default styles](https://github.com/dnadesign/silverstripe-elemental#disabling-the-default-stylesheets).

### Adding your own templates

Some sample templates for Bootstrap 5 are included.  
You may add your own templates/styles like this:

```
Derralf\Elements\SlickSlider\Element\ElementSlickSliderHolder:
  styles:
    MyCustomTemplate: "new customized special Layout"
```

...and put a template named `ElementSlickSliderHolder_MyCustomTemplate.ss`in `themes/{your_theme}/templates/Derralf/Elements/SlickSlider/Element/`  
**and/or**
add styles for `.derralf__elements__slickslider__element__elementslicksliderholder.mycustomtemplate` to your style sheet

## Template Notes

Included templates are based on Bootstrap 5 but may require extra/additional styling (see included stylesheet).

- Optionaly, you can require basic CSS stylings provided with this module to your controller class like:
  **mysite/code/PageController.php**
  ```
      Requirements::css('derralf/elemental-slickslider:client/dist/styles/frontend-default.css');
  ```
  or copy over and modify `client/src/styles/frontend-default.scss` in your theme scss


## Screen Shots

(not available)


