# Trackable

Trackable uses Drip/Segment-style contact tracking and hit logging. Trackable uses cookies to track time on page and unique user activity so you can ask complicated questions like "which of my users has read my article?" or "how long have my registered users spent on page B after reading page A?"

## Installation

In your main view, include:

    -echo(\Trackable::scripts());

In `app/config.php`:

Find

    'providers' => [
      BenAllfree\Trackable\TrackableServiceProvider::class, // Insert before RouteServiceProvider
      App\Providers\RouteServiceProvider::class,
    ]

Alias the models:

    'aliases' => [
      'Contact'=> \BenAllfree\Trackable\Models\Contact::class,
      'ContactMeta'=> \BenAllfree\Trackable\Models\ContactMeta::class,
      'Action'=> \BenAllfree\Trackable\Models\Action::class,
      'ActionMeta'=> \BenAllfree\Trackable\Models\ActionMeta::class,
      'Site'=> \BenAllfree\Trackable\Models\Site::class,
      'SiteHelper'=> \BenAllfree\Trackable\Helpers\Site::class,
      'Visitor'=> \BenAllfree\Trackable\Helpers\Visitor::class,
      'Trackable'=> \BenAllfree\Trackable\Helpers\Trackable::class,
    ]

In `app/Http/Kernel.php`, add a middleware group:


    protected $middlewareGroups = [
      'trackable' => [
        \BenAllfree\Trackable\Middleware\InitializeContact::class,
        \BenAllfree\Trackable\Middleware\LogHit::class,
      ],
    ];

Then use the middleware, such as in `app/routes/web.php`:

    Route::group(['middleware'=>'trackable'], function() {
      ...any routes you want tracked...
    });

Then publish:

    ./artisan vendor:publish

## Accessing and retrieving user attributes

    $u = \Visitor::get();   // Get the current user (based on cookie)
    $u->meta('foo', 'bar'); // Set foo=bar on the Contact model
    $u->meta('foo');        // Retrieve the value of foo
    $u->toArray();          // Retrieve a key/value array of all Contact attributes

## Extending the Models

On occasion, you may need to extend the models, particularly the `Site` and `Contact` models with convenience calls or additional fields. 

## Registering actions and goals

If you want to record a goal for a contact:

    Visitor::get()->goal('some-goal-name', ['meta'=>'data']);

