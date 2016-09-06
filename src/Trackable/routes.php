<?php
use \BenAllfree\Trackable\Models\Action;


Route::group(['middleware'=>'web', 'as'=>'trackable.', 'prefix'=>'trackable'], function() {
  Route::get('trackable.js', ['as'=>'js', function() {
    $js_files = [
      'ifvisible.js/src/ifvisible.min.js',
      'timeme.js/timeme.js',
    ];
    $js = [];
    foreach($js_files as $js_file)
    {
      $js[] = file_get_contents(__DIR__.'/../../bower_components/'.$js_file);
    }
    return response()->view('trackable::js', ['inlines'=>$js])->header('Content-Type', 'application/javascript');
  }]);
  
  Route::post('leave', ['as'=>'leave', function() {
    $h = Action::find(request()->input('h'));
    if(!$h)
    {
      return response()
              ->json(['status' => 'error']);
    }
    $h->duration = request()->input('t');
    $h->ended_at = \Carbon::now();
    $h->save();
    return response()
            ->json(['status' => 'ok']);
  }]);
});
