<?php
/**
 * A wrapper class for the Tumblr API
 */
class TumblrPageExtension extends Extension
{
    const DEFAULT_LIMIT = 20; // current max per API

    const POST_TYPE_TEXT = "text";
    const POST_TYPE_QUOTE = "quote";
    const POST_TYPE_LINK = "link";
    const POST_TYPE_ANSWER = "answer";
    const POST_TYPE_VIDEO = "video";
    const POST_TYPE_AUDIO = "audio";
    const POST_TYPE_PHOTO = "photo";
    const POST_TYPE_CHAT = "chat";

    const OPTION_TYPE = "type";
    const OPTION_LIMIT = "limit";
    const OPTION_OFFSET = "offset";
    const OPTION_ID = "id";
    const OPTION_TAG = "tag";
    const OPTION_FILTER = "filter";
    const OPTION_FILTER_TEXT = "text";

    /**
     * Check for required config values
     *
     * @param  SiteConfig    $config    the current SS SiteConfig
     * @return boolean required config strings are present (true) or not (false)
     */
    private function checkConfig($config) 
    {
        return !empty($config->TumblrBlogName)
            && !empty($config->TumblrConsumerKey)
            && !empty($config->TumblrConsumerSecret);
    }

    /**
     * Recursively converts nested objects and arrays to Silverstripe ArrayList/ArrayData
     *
     * @param  object    $obj    The object to iterate (stdClass)
     * @return ArrayList|ArrayData  Completed conversion
     */
    protected static function recursive_conversion_iterator($obj) 
    {
        if (is_object($obj) || is_array($obj)) {   
            //Check for properties with non-object values
            $is_list = true;         
            foreach ($obj as &$item) {
                if(is_object($item) || is_array($item))
                    $item = self::recursive_conversion_iterator($item);
                else
                    $is_list = false;
            }
        }
        //Format parent
        if ($is_list || is_array($obj))
            $obj = ArrayList::create((array) $obj);
        else
            $obj = ArrayData::create((array) $obj);
        return $obj;
    }

    /**
     * Get posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $type    the type of post to retrieve, or blank for all
     * @param array   $options associative array of API options
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrPostsList($limit = self::DEFAULT_LIMIT, $offset = 0, $type = "", $options = array())
    {        
        $config = SiteConfig::current_site_config();

        if (!$this->checkConfig($config)) {
            return new ArrayList();
        }
        else {
            $cache_key = __FUNCTION__.'_'.md5($limit.$offset.$type.implode($options));

            $cache = SS_Cache::factory('tumblr_api_cache');
            if (!($results = unserialize($cache->load($cache_key)))) {
                $results = new ArrayList();

                if (!empty($type) && defined('self::POST_TYPE_'.strtoupper($type))) {
                    $options[self::OPTION_TYPE] = $type;
                }
                if (is_numeric($limit) && $limit > 0 && $limit <= self::DEFAULT_LIMIT) {
                    $options[self::OPTION_LIMIT] = $limit;
                }
                if (is_numeric($offset) && $offset > 0) {
                    $options[self::OPTION_OFFSET] = $offset;
                }

                $client = new Tumblr\API\Client($config->TumblrConsumerKey, $config->TumblrConsumerSecret);
                
                try {
                    $response = $client->getBlogPosts($config->TumblrBlogName, $options);
                    foreach ($response->posts as $post) {               
                        $results->push(self::recursive_conversion_iterator($post));
                    }            
                }
                catch (RequestException $e) {
                    // *** maybe we should do something?
                }
                $cache->save(serialize($results), $cache_key);
            }
        }
        return $results;
    }

    /**
     * Get text posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrTextPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_TEXT, $options);
    }

    /**
     * Get quote posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrQuotePostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_QUOTE, $options);
    }

    /**
     * Get link posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrLinkPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_LINK, $options);
    }

    /**
     * Get answer posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrAnswerPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_ANSWER, $options);
    }

    /**
     * Get video posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrVideoPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_VIDEO, $options);
    }

    /**
     * Get audio posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrAudioPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_AUDIO, $options);
    }

    /**
     * Get photo posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrPhotoPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_PHOTO, $options);
    }

    /**
     * Get chat posts for a given blog
     *
     * @param integer $limit   number of results to return, max DEFAULT_LIMIT
     * @param integer $offset  number of beginning position for retrieval 
     * @param string  $tag     single tag to filter by
     * @param boolean $text    return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API results
     */
    public function TumblrChatPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if (!empty($tag)) {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_CHAT, $options);
    }

    /**
     * Get a single post for a given blog
     *
     * @param integer $id   Tumblr ID of post
     * @param boolean $text return html-formatted user strings (false) or plain text (true)
     *
     * @return StdClass containing json decoded API result
     */
    public function TumblrPost($id, $text = false)
    {
        $options = array();
        if ($id) {
            // ***input validation
            $options[self::OPTION_ID] = $id;
        }
        if ($text) {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList(null, null, "", $options);
    }

}
