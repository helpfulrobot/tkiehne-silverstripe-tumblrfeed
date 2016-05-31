<% if $Post %>
  <% with $Post %>
      <li class="$type">
        <div class="title">$title</div>
        $body
      </li>
  <% end_with %>
<% end_if %>