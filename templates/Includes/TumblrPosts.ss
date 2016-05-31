<% if $Posts %>
  <div class="tumblr">
    <div class="title">
      <h1>Tumblr Posts</h1>
    </div>
    <ul class="posts">
      <% loop $Posts %>
        <% if $type == "text" %>
          <% include TumblrTextPost Post=$Me %>
        <% else_if $type == "quote" %>
          <% include TumblrQuotePost Post=$Me %>
        <% else_if $type == "link" %>
          <% include TumblrLinkPost Post=$Me %>
        <% else_if $type == "answer" %>
          <% include TumblrAnswerPost Post=$Me %>
        <% else_if $type == "video" %>
          <% include TumblrVideoPost Post=$Me %>
        <% else_if $type == "audio" %>
          <% include TumblrAudioPost Post=$Me %>
        <% else_if $type == "photo" %>
          <% include TumblrPhotoPost Post=$Me %>
        <% else_if $type == "chat" %>
          <% include TumblrChatPost Post=$Me %>
        <% end_if %>
      <% end_loop %>
    </ul>
  </div>
<% end_if %>