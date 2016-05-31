<% if $Post %>
  <% with $Post %>
    <li class="$type">
      <div class="title">$title</div>
      <% loop $dialogue %>
        <div class="chat"><strong>[{$name}]</strong>: $phrase</div>
      <% end_loop %>
    </li>
  <% end_with %>
<% end_if %>