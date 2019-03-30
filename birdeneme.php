<?php
  $key = "AIzaSyB9Iu3jWUujPMl3IcNcE1b4sts6JJHkr0s";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=39.8904939,32.83577508&destinations=39.9466660,32.7796499&key=AIzaSyB9Iu3jWUujPMl3IcNcE1b4sts6JJHkr0s";
        $jsonVal=file_get_contents($url);
        $val = json_decode($jsonVal);
        $dist = $val->rows[0]->elements[0]->distance->text;
        echo $dist;