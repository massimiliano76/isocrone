<?php
$lng=$_GET["lng"];
$lat=$_GET["lat"];
$url="http://isocrone.labmod.org/foot/?lng=".$lng."&lat=".$lat."&intervals[]=10&intervals[]=20&intervals[]=30";

$request=file_get_contents($url);
echo $request;

 ?>
