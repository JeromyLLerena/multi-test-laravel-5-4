<?php

namespace App\Http\Controllers\Football;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class FootballController extends Controller
{
	public function __construct(){
	
	}

	public function index(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.football-data.org/v1/competitions");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'X-Auth-Token: 5c08dec50b81459f86d72a6c2f42ca0b',
		    ));
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch); 

        return view('competitions')->with(['competitions' => json_decode($output)]);
	}

	public function show($id)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.football-data.org/v1/competitions" . "/" . $id);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'X-Auth-Token: 5c08dec50b81459f86d72a6c2f42ca0b',
		    ));
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch); 

        dd(json_decode($output));

        //return view('competitions')->with(['competitions' => json_decode($output)]);
	}

	public function fixtures($id, Request $request)
	{
		$timezone = $request->input('timezone', 'UTC');
		$ch_teams = curl_init();
		curl_setopt($ch_teams, CURLOPT_URL, "http://api.football-data.org/v1/competitions" . "/" . $id . "/teams");
		curl_setopt($ch_teams, CURLOPT_HTTPHEADER, array(
		    'X-Auth-Token: 5c08dec50b81459f86d72a6c2f42ca0b',
		    ));
        curl_setopt($ch_teams, CURLOPT_RETURNTRANSFER, 1); 
        $output_teams = curl_exec($ch_teams); 
        curl_close($ch_teams);
        $team_icons = collect(json_decode($output_teams)->teams)->pluck('crestUrl', 'name');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.football-data.org/v1/competitions" . "/" . $id . '/fixtures?matchday=' . $request->get('matchday'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'X-Auth-Token: 5c08dec50b81459f86d72a6c2f42ca0b',
		    ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);

        $collection_fixtures = collect(json_decode($output)->fixtures)->transform(function($item) use ($team_icons, $timezone){
        	$item->homeTeamIcon = $team_icons->get($item->homeTeamName);
        	$item->awayTeamIcon = $team_icons->get($item->awayTeamName);
        	$temp_date = Carbon::parse($item->date);
        	if ($timezone) {
        		$temp_date->tz = $timezone;
        	}
        	$item->date = $temp_date->toDayDateTimeString();
        	return $item;
        });

        //dd($collection_fixtures);

        return view('current_fixtures')->with(['fixtures' => $collection_fixtures, 'timezone' => $timezone]);
	}
}
