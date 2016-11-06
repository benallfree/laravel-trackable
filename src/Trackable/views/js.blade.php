@foreach($inlines as $js)
  {!! $js !!};
@endforeach
TimeMe.setIdleDurationInSeconds(30);
//TimeMe.setCurrentPageName('my-page-name');
TimeMe.initialize();        

window.onbeforeunload = function (event) {
  $.ajax({
    type: 'POST',
    url: '{{route('trackable.leave')}}',
    data: {_token: '{{csrf_token()}}', t: TimeMe.getTimeOnCurrentPageInSeconds(), h: Trackable.hit_id},
    dataType: "application/x-www-form-urlencoded",
    async:false
  });
};    
