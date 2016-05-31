<% if $Post %>
  <% with $Post %>
      <li class="$type">
        $player
        <div class="caption">$caption</div>
      </li>
  <% end_with %>
<% end_if %>