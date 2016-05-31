<% if $Post %>
  <% with $Post %>
      <% with $player.offsetGet(1) %>
      <li class="$Top.type">
        $embed_code
        <div class="caption">$Top.caption</div>
      </li>
      <% end_with %>
  <% end_with %>
<% end_if %>