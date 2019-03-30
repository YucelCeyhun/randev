<?php
function getDistanceHaversine($originLat, $originLong, $destinationLat, $destinationLong) 
{

$offset = 1.37;
$Radius = 6371;
$dLat = deg2rad($destinationLat-$originLat);
$dLong = deg2rad($destinationLong-$originLong);

$a =sin($dLat/2) * sin($dLat/2) + cos(deg2rad($originLat)) * cos(deg2rad($destinationLat)) * sin($dLong/2) * sin($dLong/2);

$c = 2 *atan2(sqrt($a),sqrt(1-$a));
$result = $Radius * $c;
return $result * $offset;

}



