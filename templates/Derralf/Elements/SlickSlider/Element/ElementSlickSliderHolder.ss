<% if $ShowTitle %>
    <% include Derralf\\Elements\\SlickSlider\\Title %>
<% end_if %>

<% if $HTML %>
    <div class="element__content">$HTML</div>
<% end_if %>

<% if $Slides %>
    <div class="element-slick-slider--wrapper">
        <div class="element-slick-slider" data-slick='{$SlickCarouselConfigDataAtt.ATT}'>
            <% loop $Slides %>
                <% include Derralf\\Elements\\SlickSlider\\Includes\\ElementSlickSliderItem %>
            <% end_loop %>
        </div>
    </div>
<% end_if %>
