<?php
class Tumblr_Page_Extension extends Extension
{
    const DEFAULT_LIMIT = 12;

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

    private function CheckConfig($config) {
        return !empty($config->TumblrBlogName)
            && !empty($config->TumblrConsumerKey)
            && !empty($config->TumblrConsumerSecret);
    }

    /**
     * Recursively converts nested objects and arrays to Silverstripe ArrayList/ArrayData
     *
     * @param object    $obj    The object to iterate (stdClass)
     * @return ArrayList|ArrayData  Completed conversion
     */
    protected static function recursive_conversion_iterator($obj) {
        if(is_object($obj) || is_array($obj)) {   
            //Check for properties with non-object values
            $is_list = true;         
            foreach($obj as &$item) {
                if(is_object($item) || is_array($item))
                    $item = self::recursive_conversion_iterator($item);
                else
                    $is_list = false;
            }
        }
        //Format parent
        if($is_list || is_array($obj))
            $obj = ArrayList::create((array) $obj);
        else
            $obj = ArrayData::create((array) $obj);
        return $obj;
    }

    public function TumblrPostsList($limit = self::DEFAULT_LIMIT, $offset = 0, $type = "", $options = array())
    {        
        $config = SiteConfig::current_site_config();

        if (!$this->CheckConfig($config)) 
        {
            return new ArrayList();
        }
        else
        {
            //$cache = SS_Cache::factory('Tumblr_cache');
            //if (!($results = unserialize($cache->load(__FUNCTION__)))) {
                $results = new ArrayList();

                if(!empty($type) && defined('self::POST_TYPE_'.strtoupper($type)))
                {
                    $options[self::OPTION_TYPE] = $type;
                }
                if(is_numeric($limit) && $limit > 0)
                {
                    $options[self::OPTION_LIMIT] = $limit;
                }
                if(is_numeric($offset) && $offset > 0)
                {
                    $options[self::OPTION_OFFSET] = $offset;
                }

                $client = new Tumblr\API\Client($config->TumblrConsumerKey, $config->TumblrConsumerSecret);
                
                # *** error/exception handling?
                $response = $client->getBlogPosts($config->TumblrBlogName, $options);
                foreach($response->posts as $post)
                {               
                    $results->push(self::recursive_conversion_iterator($post));
                }            
                # ***cache by parameters
                //$cache->save(serialize($results), __FUNCTION__);
            //}
        }
        return $results;
    }

    public function TumblrTextPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_TEXT, $options);
    }

    public function TumblrQuotePostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_QUOTE, $options);
    }

    public function TumblrLinkPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_LINK, $options);
    }

    public function TumblrAnswerPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_ANSWER, $options);
    }

    public function TumblrVideoPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_VIDEO, $options);
    }

    public function TumblrAudioPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_AUDIO, $options);
    }

    public function TumblrPhotoPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_PHOTO, $options);
    }

    public function TumblrChatPostsList($limit = null, $offset = null, $tag = "", $text = false)
    {
        $options = array();
        if(!empty($tag))
        {
            // ***input validation
            $options[self::OPTION_TAG] = $tag;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList($limit, $offset, self::POST_TYPE_CHAT, $options);
    }

    public function TumblrPost($id, $text = false)
    {
        $options = array();
        if($id)
        {
            // ***input validation
            $options[self::OPTION_ID] = $id;
        }
        if($text)
        {
            $options[self::OPTION_FILTER] = self::OPTION_FILTER_TEXT;
        }
        return $this->TumblrPostsList(null, null, "", $options);
    }

}