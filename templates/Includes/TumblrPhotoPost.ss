<% if $Post %>
  <% with $Post %>
    <% loop $photos %>
      <% with $alt_sizes.offsetGet(1) %>
      <li class="$Top.type">
        <a href="$Top.post_url"><img src="$url" alt="$Top.caption.NoHTML" class="photo_img" width="$width" height="$height" /></a>
        <div class="caption">$Top.caption</div>
      </li>
      <% end_with %>
    <% end_loop %>
  <% end_with %>
<% end_if %>