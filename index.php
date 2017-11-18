<form action="" method="post">
	<p>
		//I had to create a new flightaware account since I ran out of queries, right now, it gets all the arriving aircrafts. I am planning to add all the scheduled and all the departing as well. Printing them into a csv will be my final goal, I want everything else to be ready and the code to be clean and proper functioning (right now the code is just enough to get it to work).</p>
    
    ICAO to pull data from: <input type="text" name="ICAO">
</form>

<?php

if(isset($_POST['ICAO'])) {
    $ICAO = trim($_POST['ICAO']);
    
    $apiUserId = "yourFlightAwareID";
    $apiKey = "yourFlightAwareApiKey";
    $apiUrl = "https://flightxml.flightaware.com/json/FlightXML3/";
    
    $queryArray = array(
        'airport_code' => $ICAO,
        'filter' => 'airline:SAS'
    );
    
    $queryUrl = $apiUrl . 'AirportBoards?' . http_build_query($queryArray);
    
    $ch = curl_init($queryUrl);
    curl_setopt($ch, CURLOPT_USERPWD,  $apiUserId . ':' . $apiKey);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $queryResult = curl_exec($ch);

    curl_close($ch);
    
    $queryResultJsonDecode = json_decode($queryResult, true);
        
$flightsArray = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights'];
$flightnumber = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']['0']['ident']; 
$sasCallsign = array();
$totalArray = array('code','flightnum','depicao','arricao','route','aircraft','distance','deptime','arrtime','flighttime','notes','price','flighttype','daysofweek','enabled');

$fp = fopen('total.csv', 'a');

fputcsv($fp, $totalArray);

fclose($fp);
    
foreach($flightsArray as $flight) {
    $sasCallsign[] = $flight['ident'];
    }
    
    $i = 0;
    
    foreach($sasCallsign as $callsigns) {
        ${"callsign$i"} = $callsigns;
        $i++;
    }   
    
    $x = count($sasCallsign);
    $x--;
?>

<center>
    <p style="font-size:120%;"><b>Arrivals</b></p><hr>
</center>

<?
    
    for($x; $x >= 0; $x--) {
        
        $dep = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['origin']['code'];
        $arr = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['destination']['code'];
        $depTime = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['filed_departure_time']['time'];
        $depDate = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['filed_departure_time']['date'];
        $arrTime = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['filed_arrival_time']['time'];
        $arrDate = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['filed_arrival_time']['date'];
        $distance = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['distance_filed'];
        $aircraft = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['full_aircrafttype'];
        $tailnumber = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['tailnumber'];
        $airline = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['airline'];
        $fnumber = $queryResultJsonDecode['AirportBoardsResult']['arrivals']['flights']["$x"]['flightnumber'];
        
        if(empty($arrTime)) $arrTime = "";
        if(empty($arrDate)) $arrDate = "";
        if(empty($aircraft)) $aircraft = "";
        
        $totalArray = array($airline, $fnumber, $dep, $arr, "N/A", $tailnumber, $distance, $depTime, $arrTime, "N/A", "", "160", "P", "123456", "1");
        
        $fp = fopen('total.csv', 'a');
        
        fputcsv($fp, $totalArray);
        
        fclose($fp);
        
        error_reporting( error_reporting() & ~E_NOTICE );
        
?>
<center>
<table border="1" style="margin-top:1%;">
    <tr>
        <th>Airline</th>
        <th>Flightnumber</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Route</th>
        <th>Tailnumber</th>
        <th>Distance</th>
        <th>Departure Time</th>
        <th>Arrival Time</th>
        <th>Flight Time</th>
        <th>Notes</th>
        <th>Price</th>
        <th>Flight Type</th>
        <th>Daysofweek</th>
        <th>Enabled</th>
    </tr>
    <tr>
        <td><? print_r("$airline"); ?></td>
        <td><? print_r("$fnumber"); ?></td>
        <td><? print_r("$dep"); ?></td>
        <td><? print_r("$arr"); ?></td>
        <td>N/A</td>
        <td><? print_r("$tailnumber"); ?></td>
        <td><? print_r("$distance"); ?></td>
        <td><? print_r("$depTime"); ?></td>
        <td><? print_r("$arrTime"); ?></td>
        <td>N/A</td>
        <td></td>
        <td>160</td>
        <td>P</td>
        <td>123456</td>
        <td>1</td>
    </tr>
</table>
</center>
<?php
        
    }
    

    $x = count($sasCallsign);
    $x--;
?>

<center>
    <p style="font-size:120%;"><b>Departures</b></p><hr>
</center>

<?
    
    for($x; $x >= 0; $x--) {
        
        $dep = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['origin']['code'];
        $arr = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['destination']['code'];
        $depTime = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['filed_departure_time']['time'];
        $depDate = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['filed_departure_time']['date'];
        $arrTime = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['filed_arrival_time']['time'];
        $arrDate = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['filed_arrival_time']['date'];
        $distance = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['distance_filed'];
        $aircraft = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['full_aircrafttype'];
        $tailnumber = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['tailnumber'];
        $fnumber = $queryResultJsonDecode['AirportBoardsResult']['departures']['flights']["$x"]['flightnumber'];

        
        if(empty($arrTime)) $arrTime = "NA";
        if(empty($arrDate)) $arrDate = "NA";
        if(empty($aircraft)) $aircraft = "NA";
        
        $totalArray = array($airline, $fnumber, $dep, $arr, "N/A", $tailnumber, $distance, $depTime, $arrTime, "N/A", "", "160", "P", "123456", "1");
        
        $fp = fopen('total.csv', 'a');
        
        fputcsv($fp, $totalArray);
        
        fclose($fp);
        
        error_reporting( error_reporting() & ~E_NOTICE );
?>
<center>
<table border="1" style="margin-top:1%;">
    <tr>
        <th>Airline</th>
        <th>Flightnumber</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Route</th>
        <th>Tailnumber</th>
        <th>Distance</th>
        <th>Departure Time</th>
        <th>Arrival Time</th>
        <th>Flight Time</th>
        <th>Notes</th>
        <th>Price</th>
        <th>Flight Type</th>
        <th>Daysofweek</th>
        <th>Enabled</th>
    </tr>
    <tr>
        <td><? print_r("$airline"); ?></td>
        <td><? print_r("$fnumber"); ?></td>
        <td><? print_r("$dep"); ?></td>
        <td><? print_r("$arr"); ?></td>
        <td>N/A</td>
        <td><? print_r("$tailnumber"); ?></td>
        <td><? print_r("$distance"); ?></td>
        <td><? print_r("$depTime"); ?></td>
        <td><? print_r("$arrTime"); ?></td>
        <td>N/A</td>
        <td></td>
        <td>160</td>
        <td>P</td>
        <td>123456</td>
        <td>1</td>
    </tr>
</table>
</center>
<?php   
    }
}
?>
