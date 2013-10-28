Birder
======

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `thatzad/birder`.

    "require": {
        "laravel/framework": "4.0.*",
        "thatzad/birder": "dev-master"
    },

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Thatzad\Birder\BirderServiceProvider'

And add the alias.

    'Birder' => 'Thatzad\Birder\Facades\Birder'

Finally you'll need to publish the config file. To do that, in the project folder execute `php artisan config:publish thatzad/birder`.
This will output the configuration in `app/config/packages/thatzad/birder/config.php`, in this file you must to fill all twitter fields.

## Usage
# UNDER CONSTRUCTION
