<!DOCTYPE html>
<html>
<head>
	<title></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<table class="table table-striped">
  <tr>
    <th>Date and Time
    <span style="left: 9px; position: relative;"><input id="check-tz" type="checkbox" aria-label="dasdasdas"{{$timezone == 'UTC' ?  '' : 'checked'}}> Set Locale Timezone</span>
    </th>
    <th>Status</th> 
    <th>Result</th>
  </tr>
  @foreach($fixtures as $fixture)
  <tr>
    <td>{{$fixture->date . ' (' . $timezone . ')'}}</td> 
    <td>{{$fixture->status}}</td>
    <td>
      <img class="img-thumbnail" src="{{$fixture->homeTeamIcon}}" height="30px" width="30px">
      {{$fixture->homeTeamName . ' '}} 
      <strong>{{$fixture->result->goalsHomeTeam}} - {{$fixture->result->goalsAwayTeam . ' '}}</strong>
      {{$fixture->awayTeamName}}
      <img class="img-thumbnail" src="{{$fixture->awayTeamIcon}}" height="30px" width="30px">
    </td>
  </tr>
  @endforeach
</table>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js">
</script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
</script>
<script type="text/javascript">
  $(document).ready(function(){
    var tz = jstz.determine(); // Determines the time zone of the browser client
    var timezone = tz.name(); //'Asia/Kolhata' for Indian Time.
    var window_url = location.href;
    $('#check-tz').click(function(){
      var tz_parameter = '';
      if ($(this).is(':checked')) {
        tz_parameter = "&timezone=" + timezone;
      } else {
        window_url = window_url.replace("&timezone=" + timezone, "");
      }
      location.href = window_url + tz_parameter;
    });
  });
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>