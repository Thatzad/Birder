<?php namespace Thatzad\Birder\Adapters;

use Solution10\Collection\Collection;
use Thatzad\Birder\Exceptions\BirderException;

abstract class BirderAdapter
{
    /**
     * Type to look for
     */
    protected $type = 'user';

    /**
     * Value to look for
     */
    protected $value;


    /**
     * Permissed operators
     */
    protected $operators = array('<', '<=', '=', '>=', '>', '!=');

    /**
     * Found results
     */
    protected $results;


    // abstract public function words($words);

    abstract public function user($username);

    abstract public function hashtag($hashtag);


    /**
     * Set the results
     * @param array $results
     */
    protected function setResults($results)
    {
        if (is_null($results)) {
            throw new BirderException("Connection error", 1);
        }

        $filteredResults = array();

        foreach ($results as $result) {
/*
            foreach ($this->filterBy as $filter => $value) {
                $rtTweet = compare($tweet->retweet_count, $this->conditions['reresults']['operator'], $this->conditions['reresults']['value']);
            }

            $favTweet = compare($tweet->favorite_count, $this->conditions['favorites']['operator'], $this->conditions['favorites']['value']);

            $condition = ($this->conditions['condition'] == 'or')
                ? ($rtTweet or $favTweet)
                : ($rtTweet and $favTweet);

            if ($condition) $filteredresults[] = $tweet;
*/
            $filteredResults[] = $result;
        }

        $results = new Collection($filteredResults);
        $this->results = $results->sort();
    }

    /**
     * Filter tweets
     * @param  string $type
     * @param  string $operator
     * @param  int    $value
     * @return Birder
     */
    public function where($type, $operator = '=', $value = null)
    {
        // If it used by this way: ´->where('retweets', 12);´
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

        if ( ! $type = array_search_recursive($type, $this->filterBy, true)) {
            throw new BirderException("{$type} is not a valid type" , 1);
        }

        if ( ! in_array($operator, $this->operators)) {
            throw new BirderException("{$operator} is not a valid operator" , 1);
        }

        if ( ! is_numeric($value)) {
            throw new BirderException("The value must be numeric, {$operator} given" , 1);
        }

        $this->conditions[$type] = array(
            'operator' => $operator,
            'value'    => $value
        );

        return $this;
    }

    /**
     * Return the results collection
     * @return Collection
     */
    public function get()
    {
        $this->{'generateBy'.ucfirst($this->type)}();

        return $this->results;
    }

    /**
     * Magic to enable do:
     *     ->whereFavorites(3)
     *     ->orWhereRetweets(8)
     * @param  $method
     * @param  $args
     * @return call method
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

            $args = ($filterBy == '') ? $args : array($filterBy, '=', $args[0]);


            return call_user_func_array(array($this, 'where'), $args);
        }

        throw new BirderException("Call to undefined method {$method}", 1);

    }
}
