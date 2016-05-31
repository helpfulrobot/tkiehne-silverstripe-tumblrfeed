<% if $Post %>
  <% with $Post %>
      <li class="$type">
        $text
        <div class="caption">$source</div>
      </li>
  <% end_with %>
<% end_if %>