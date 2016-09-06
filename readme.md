# Trackable

# Installation

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

In `app/Http/Kernel.php`:


    protected $middlewareGroups = [
      'trackable' => [
        \BenAllfree\Trackable\Middleware\InitializeContact::class,
        \BenAllfree\Trackable\Middleware\LogHit::class,
      ],
    ];

Then in `app/routes/web.php` (or wherever):

    Route::group(['middleware'=>'trackable'], function() {
      ...any routes you want tracked...
    });