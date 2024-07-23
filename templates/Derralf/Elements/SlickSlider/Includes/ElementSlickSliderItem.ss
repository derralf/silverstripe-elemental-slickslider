<%-- Ratio 3:2 1680 x 1120 / Ratio 16:9 1680 x 945 o. 1920 x 1080 --%>
<div class="element-slick-slider--item {$Style}">
    <% if $ReadMoreLink.URL %><a href="$ReadMoreLink.URL"><% end_if %>
        <img loading="lazy" width="1680" height="945" class="img-fluid forced" src="$Image.FocusFill(1680,945).Link" alt="$Image.AltText.ATT">
        <% if $ShowTitle && $Title %>
            <div class="slide-contentbox">
                <h2 class="slide-title">$Title</h2>
                <% if $useContent && $Content %>
                    <div class="slide-content">
                        $Content
                    </div>
                <% end_if %>
            </div>
        <% end_if %>
    <% if $ReadMoreLink.URL %></a><% end_if %>
</div>
