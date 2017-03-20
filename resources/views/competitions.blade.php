<!DOCTYPE html>
<html>
<head>
	<title></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<table class="table table-striped">
  <tr>
    <th>Name</th>
    <th>Year</th> 
    <th>Current Match Day</th>
    <th>Teams</th>
    <th>Secions</th>
  </tr>
  @foreach($competitions as $competition)
  <tr>
    <td><a href="{{route('competitions.show', $competition->id)}}">{{$competition->caption}}</a></td>
    <td>{{$competition->year}}</td> 
    <td>{{$competition->currentMatchday}}</td>
    <td>{{$competition->numberOfTeams}}</td>
    <td><a href="{{route('competitions.fixtures', $competition->id) . '?matchday=' . $competition->currentMatchday}}">Fixtures</a></td>
  </tr>
  @endforeach
</table>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>