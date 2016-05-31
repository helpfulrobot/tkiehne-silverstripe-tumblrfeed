<% if $Post %>
  <% with $Post %>
    <% loop $photos %>
      <% with $original_size %>
      <li class="$Top.type">
        <a href="$Top.url" title="$Top.title.NoHTML"><img src="$url" alt="$Up.caption.NoHTML" class="photo_img" width="$width" height="$height" /></a>
        <div class="title">$Top.title</div>
        <div class="caption">$Top.description</div>
      </li>
      <% end_with %>
    <% end_loop %>
  <% end_with %>
<% end_if %>