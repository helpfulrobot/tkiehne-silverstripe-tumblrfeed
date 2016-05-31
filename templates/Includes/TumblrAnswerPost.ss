<% if $Post %>
  <% with $Post %>
      <li class="$type">
        <div class="title"><a href="$asking_url">$question</a></div>
        $answer
      </li>
  <% end_with %>
<% end_if %>