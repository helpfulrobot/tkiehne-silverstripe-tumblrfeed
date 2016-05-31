# Tumblr Feed Module

Silverstripe module to load Tumblr feeds via Tumblr API V2


## Maintainer Contact

*  Tom Kiehne (tkiehne@gmx.us)


## Requirements

* Silverstripe 3.x


## Installation

```
    $ composer require tkiehne/silverstripe-tumblrfeed
```


## Usage

*  Add to your `mysite/_config/config.yml` to extend the object of your choice:

```
    Page:
        extensions:
            - Tumblr_Page_Extension
```

  or set the following call in `mysite/_config.php`:
   
```
    Page::add_extension('Tumblr_Page_Extension');
```

*  Build and flush using `/dev/build/?flush=1`
*  Add Tumblr API keys and blog name via Admin > Settings > Tumblr tab
*  Place Include call in your template (see below for options), e.g.:

```
    <% include TumblrPosts Posts=$TumblrPostsList %>
```

## Call Methods and Options

### All Posts

```
    TumblrPostsList($limit, $offset, $type, $options)
```

### Proxy Methods for Specific Post Types

```
    TumblrTextPostsList($limit, $offset, $tag, $text)
    
    TumblrQuotePostsList($limit, $offset, $tag, $text)
    
    TumblrLinkPostsList($limit, $offset, $tag, $text)
    
    TumblrAnswerPostsList($limit, $offset, $tag, $text)
    
    TumblrVideoPostsList($limit, $offset, $tag, $text)
    
    TumblrAudioPostsList($limit, $offset, $tag, $text)
    
    TumblrPhotoPostsList($limit, $offset, $tag, $text)
    
    TumblrChatPostsList($limit, $offset, $tag, $text)
```

### Single Post by ID

```
    TumblrPost($id, $text)
```


### Options

*  limit = number of posts to show, from 1 to 20 (API max limit)
*  offset = number of posts to skip
*  type = name of post type to retrieve (see below)
*  options = array of API options
*  tag = name of a tag to filter by (single tag only)
*  text = boolean flag; return plain text (true) or html markup (false, default) in text fields
*  id = numeric Tumblr post ID


## Templates

By default, the `TumblrPosts.ss` include will call subsequent includes depending on post type.  To customize the list container, override or create a copy of `TumblrPosts`.  To customize the way that posts are displayed within the container, override the respective `Tumblr[TYPE]Post.ss` or, if you've customized the container, create your own include.

Include variables follow the syntax and structure of the [Tumblr API](https://www.tumblr.com/docs/en/api/v2#posts), based on the "posts" collection of the response.  See the module's default includes for examples and be aware of template context.
