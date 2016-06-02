<?php
class TumblrSiteConfigExtension extends DataExtension
{
    private static $db = array(
      'TumblrBlogName' => 'Varchar(64)',
      'TumblrConsumerKey' => 'Varchar(100)',
      'TumblrConsumerSecret' => 'Varchar(100)'
    );
    public function updateCMSFields(FieldList $fields)
    {
      $fields->addFieldToTab("Root.Tumblr", new TextField('TumblrBlogName', _t('Tumblr.TumblrBlogName', 'Blog Name')));
      $fields->addFieldToTab("Root.Tumblr", new TextField('TumblrConsumerKey', _t('Tumblr.TumblrConsumerKey', 'OAuth Consumer Key')));
      $fields->addFieldToTab("Root.Tumblr", new TextField('TumblrConsumerSecret', _t('Tumblr.TumblrConsumerSecret', 'Consumer Secret')));
    }
}