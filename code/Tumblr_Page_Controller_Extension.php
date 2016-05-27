<?php
class Tumblr_Page_Controller_Extension extends Extension
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

    public function TumblrPostsList($type = "", $limit = self::DEFAULT_LIMIT, $offset = 0, $options = array())
    {
        $results = new ArrayList();
        $config = SiteConfig::current_site_config();

        if (CheckConfig($config) {
            $cache = SS_Cache::factory('Tumblr_cache');
            if (!($results = unserialize($cache->load(__FUNCTION__)))) {

                if(!empty($type) && defined('POST_TYPE_'.strtoupper($type)))
                {
                    $options[OPTION_TYPE] = $type;
                }
                if(is_numeric($limit) && $limit > 0)
                {
                    $options[OPTION_LIMIT] = $limit;
                }
                if(is_numeric($offset) && $offset > 0)
                {
                    $options[OPTION_OFFSET] = $offset;
                }

                $client = new Tumblr\API\Client($config->TumblrConsumerKey, $config->TumblrConsumerSecret);
                
                # *** error/exception handling?
                $response = $client->getBlogPosts($config->TumblrBlogName, $options);

                foreach($response->posts as $post)
                {
                    $results->push(new ArrayData($post));
                }

                $cache->save(serialize($results), __FUNCTION__);
            }
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_QUOTE, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList(self::POST_TYPE_TEXT, $limit, $offset, $options)
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
        return $this->TumblrPostsList("", null, null, $options)
    }


    #####


    public function LatestTweets()
    {
        return $this->owner->renderWith('LatestTweets');
    }
}