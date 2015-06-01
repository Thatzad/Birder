Birder
======

## Installation

Begin by installing this package through Composer. Go to your project folder from the terminal and execute: `composer require thatzad/birder`

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Thatzad\Birder\BirderServiceProvider'

And add the alias.

    'Birder' => 'Thatzad\Birder\Facades\BirderFacade'

Finally you'll need to publish the config file. To do that, in the project folder execute:

    php artisan vendor:publish

This will output the configuration in your config folder. You must to fill all twitter fields.

## Usage

If you're familiar in the Laravel world, you'll find that very easy to use. E.g., imagine you need to find all @dotZecker tweets that have more than 2 retweets and only 1 fav. Do this is as easy as:

    $tweets = Birder::user('@dotZecker')
        ->where('retweets', '>', 2)
        ->where('favorites', '=', 1) // The same as: ->whereFavorites(1)
        ->get();

Now, you want to get all tweets by the #Zelda hashtag that have more than 5 retweets or more than 6 favs.

    $tweets = Birder::hashtag('#Zelda')
        ->where('retweets', '>', 5)
        ->orWhere('favorites', '>', 6)
        ->get();

This will return you a [Illuminate\Support\Collection](http://laravel.com/api/5.0/Illuminate/Support/Collection.html), by this way you'll be able to use all these methods.

## Are you British or lazy?

Don't worry!, Birder uses internal synonyms (alias) for the favorites and retweets.

You can use:

`->where('favorites' ...)`, `->where('favourites' ...)`, `->where('favs' ...)`, `->whereFavourites(...)`, ...

`->where('retweets' ...)`, `->where('rts' ...)`, `->whereRts(...)`, ...
