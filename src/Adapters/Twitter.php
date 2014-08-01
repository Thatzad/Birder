<?php namespace Thatzad\Birder\Adapters;

use TwitterPhp\RestApi as TwitterClient;

class Twitter extends BirderAdapter
{
    /**
     * Twitter Client
     */
    protected $client;

    /**
     * Permissed filters and aliases
     */
    protected $filterBy = array(
        'retweets'  => array('retweets', 'rts'),
        'favorites' => array('favorites', 'favourites', 'favs')
    );

    /**
     * Conditions to filter by
     */
    protected $conditions = array(
        'condition' => 'and',
        'retweets'  => array('operator' => '>=', 'value' => 0),
        'favorites' => array('operator' => '>=', 'value' => 0)
    );


    /**
     * Initializate
     */
    public function __construct($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret)
    {
        $client = new TwitterClient($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

        $this->client = $client->connectAsApplication();
    }

    /**
     * Fill the user data
     */
    public function user($user)
    {
        // Remove the @
        str_replace('@', '', $user);

        $this->type  = 'user';
        $this->value = $user;

        return $this;
    }

    /**
     * Fill the hashtag data
     */
    public function hashtag($hashtag)
    {
        // Remove the #
        str_replace('#', '', $hashtag);

        $this->type  = 'hashtag';
        $this->value = $hashtag;

        return $this;
    }


    public function generateByUser($retweets = false, $replies = true)
    {
        $this->setResults($this->client->get('/statuses/user_timeline', array(
            'screen_name'     => $this->value,
            'include_rts'     => $retweets,
            'exclude_replies' => ! $replies,
            'count'           => 200,
            'trim_user'       => false
        )));

    }


}
