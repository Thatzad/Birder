<?php namespace Thatzad\Birder\Adapters;

use TwitterPhp\RestApi as TwitterClient;

class Twitter implements BirderAdapter
{
    protected $client;

    public function __construct($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret)
    {
        $this->client = new TwitterClient($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    }


}
