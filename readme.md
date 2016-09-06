# Trackable

Trackable uses Drip-style contact tracking and hit logging. Trackable uses cookies to track time on page and unique user activity so you can ask complicated questions like "which of my users has read my article?" or "how long have my registered users spent on page B after reading page A?"

## Installation

In your main view, include:

    <script src="{{route('trackable.js')}}"></script>

In `app/config.php`:


    'providers' => [
      BenAllfree\Trackable\TrackableServiceProvider::class
    ]

And optionally alias the models:

    'aliases' => [
      'Contact'=> \BenAllfree\Trackable\Models\Contact::class,
      'ContactMeta'=> \BenAllfree\Trackable\Models\ContactMeta::class,
      'Action'=> \BenAllfree\Trackable\Models\Action::class,
      'ActionMeta'=> \BenAllfree\Trackable\Models\ActionMeta::class,
      'Site'=> \BenAllfree\Trackable\Models\Site::class,
      'SiteHelper'=> \BenAllfree\Trackable\Helpers\Site::class,
      'Visitor'=> \BenAllfree\Trackable\Models\ActionMeta::class,
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
    
## Registering actions and goals

If you want to record a goal for a contact:

    Visitor::get()->goal('some-goal-name', ['meta'=>'data']);
