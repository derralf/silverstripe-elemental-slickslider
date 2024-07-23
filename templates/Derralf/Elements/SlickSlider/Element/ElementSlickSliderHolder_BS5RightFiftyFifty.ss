
<% if $Slides %>
<div class="row">
    <div class="col-12 col-lg-6 order-lg-1 image-wrap image-wrap-right">
        <div class="element-slick-slider--wrapper">
            <div class="element-slick-slider" data-slick='{$SlickCarouselConfigDataAtt.ATT}'>
                <% loop $Slides %>
                    <% include Derralf\\Elements\\SlickSlider\\Includes\\ElementSlickSliderItem %>
                <% end_loop %>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 text-wrap text-wrap-left">
        <% if $ShowTitle %>
           <% include Derralf\\Elements\\SlickSlider\\Title %>
        <% end_if %>

        <% if $HTML %>
            <div class="element__content">$HTML</div>
        <% end_if %>
    </div>
<% else %>
    <% if $ShowTitle %>
        <% include Derralf\\Elements\\SlickSlider\\Title %>
    <% end_if %>

    <% if $HTML %>
            <div class="element__content">$HTML</div>
    <% end_if %>
<% end_if %>
