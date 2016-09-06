TimeMe.setIdleDurationInSeconds(30);
TimeMe.setCurrentPageName("my-home-page");
TimeMe.initialize();        

window.onbeforeunload = function (event) {
  $.ajax({
    type: 'POST',
    url: '{{route('api.leave')}}',
    data: {_token: '{{csrf_token()}}', t: TimeMe.getTimeOnCurrentPageInSeconds(), h: {{session('hit_id')}}},
    dataType: "application/x-www-form-urlencoded",
    async:false
  });
};    
