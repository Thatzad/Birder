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

Finally, you have to add the alias in the aliases array.

    'Birder' => 'Thatzad\Birder\Facades\Birder'


## Usage
# UNDER CONSTRUCTION
