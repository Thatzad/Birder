<?php namespace Thatzad\Birder;

use URL;
use Thujohn\Twitter\Twitter;
use Illuminate\Support\Collection;
use Thatzad\Birder\Exceptions\BirderException;

final class Birder
{
    /** Type to look for */
    private $type = 'user';

    /** Value to look for */
    private $value;

    /** Conditions to filter by */
    private $conditions = array(
        'condition' => 'and',
        'retweets'  => ['operator' => '>=', 'value' => 0],
        'favorites' => ['operator' => '>=', 'value' => 0]
    );

    /** Permissed filters and aliases */
    private $filterBy = array(
        'retweets'  => ['retweets', 'rts'],
        'favorites' => ['favorites', 'favourites', 'favs']
    );

    /** Permissed operators */
    private $operators = ['<', '<=', '=', '>=', '>', '!='];

    /** Found tweets */
    private $tweets;


    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /** Fill the user data */
    public function user($user)
    {
        // Remove the @
        if (strstr($user, '@')) {
            $user = substr($user, 1, strlen($user));
        }

        $this->type  = 'user';
        $this->value = $user;

        return $this;
    }

    /** Fill the hashtag data */
    public function hashtag($hashtag)
    {
        // Remove the #
        if (strstr($hashtag, '#')) {
            $hashtag = substr($hashtag, 1, strlen($hashtag));
        }

        $this->type  = 'hashtag';
        $this->value = $hashtag;

        return $this;
    }

    private function setTweets(array $tweets)
    {
        if (null === $tweets) {
            throw new BirderException("Connection error", 1);
        }

        $filteredTweets = array();

        foreach ($tweets as $tweet) {

            $rtTweet = doComparison(
                $tweet->retweet_count,
                $this->conditions['retweets']['operator'],
                $this->conditions['retweets']['value']
            );

            $favTweet = doComparison(
                $tweet->favorite_count,
                $this->conditions['favorites']['operator'],
                $this->conditions['favorites']['value']
            );

            $condition = ($this->conditions['condition'] == 'or')
                ? ($rtTweet or $favTweet)
                : ($rtTweet and $favTweet);

            if ($condition) {
                $filteredTweets[] = $tweet;
            }
        }

        $tweets = new Collection($filteredTweets);

        $this->tweets = $tweets->reverse();
    }

    /** Get the tweets by user */
    private function generateTweetsByUser()
    {
        $this->setTweets(
            $this->twitter->getUserTimeline(
                [
                    'screen_name'     => $this->value,
                    'include_rts'     => false,
                    'exclude_replies' => true,
                    'count'           => 200,
                    'trim_user'       => false
                ]
            )
        );
    }

    /** Get the tweets by hashtag */
    private function generateTweetsByHashtag()
    {
        $this->setTweets(
            $this->twitter->getSearch(
                [
                    'q' => '#' . $this->value,
                    'count' => 100,
                    'result_type' => 'recent'
                ]
            )->statuses
        );
    }

    /** Return the tweets collection */
    public function get()
    {
        $this->{'generateTweetsBy' . ucfirst($this->type)}();

        return $this->tweets;
    }

    /** Filter tweets */
    public function where($type, $operator = '=', $value = null)
    {
        // If it used by this way: ´->where('retweets', 12);´
        if (is_null($value)) {
            $value    = $operator;
            $operator = '=';
        }

        if (!$type = array_search_recursive($type, $this->filterBy, true)) {
            throw new BirderException("{$type} is not a valid type", 1);
        }

        if (!in_array($operator, $this->operators)) {
            throw new BirderException("{$operator} is not a valid operator", 1);
        }

        if (!is_numeric($value)) {
            throw new BirderException("The value must be numeric, {$operator} given", 1);
        }

        $this->conditions[$type] = array(
            'operator' => $operator,
            'value'    => $value
        );

        return $this;
    }

    /**
     * Magic to enable do:
     *     ->whereFavorites(3)
     *     ->orWhereRetweets(8)
     *
     * @return executed method
     */
    public function __call($method, $args)
    {
        if (starts_with($method, 'or')) {
            $this->conditions['condition'] = 'or';
            $method = ucfirst(substr($method, 2, strlen($method)));
        }

        $method = lcfirst($method);

        if (starts_with($method, 'where')) {
            $filterBy = lcfirst(substr($method, 5, strlen($method)));

            $args = ($filterBy === '') ? $args : array($filterBy, '=', $args[0]);

            return call_user_func_array(array($this, 'where'), $args);
        }

        throw new BirderException("Call to undefined method {$method}", 1);
    }
}
