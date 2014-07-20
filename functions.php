<?php

include('settings.php');

function get_forecast() {

  // This function returns an array with a temp and sku element and the color each light should display.

  global $api_key;
  global $latitude; 
  global $longitude;
  
  include('forecast.io-php-api/lib/forecast.io.php');

  $forecast = new ForecastIO($api_key);

  // With their API the only way to get max temp is to get the weekly forecast.
  $conditions_week = $forecast->getForecastWeek($latitude, $longitude);

  // Grab the first result from the array which will be for today.
  $high_temp = round($conditions_week[0]->getMaxTemperature());

  // Assign a color to each temperature range
      if($high_temp <  29) {$temp_color = "white";}
  elseif($high_temp >= 30 && $high_temp <= 39) {$temp_color = 'violet';  }
  elseif($high_temp >= 40 && $high_temp <= 49) {$temp_color = 'lt_blue'; }
  elseif($high_temp >= 50 && $high_temp <= 59) {$temp_color = 'blue';    }
  elseif($high_temp >= 60 && $high_temp <= 69) {$temp_color = 'green';   }
  elseif($high_temp >= 70 && $high_temp <= 79) {$temp_color = 'lt_green';}
  elseif($high_temp >= 80 && $high_temp <= 89) {$temp_color = 'yellow';  }
  elseif($high_temp >= 90 && $high_temp <= 99) {$temp_color = 'orange';  }
  elseif($high_temp >= 100)                    {$temp_color = 'red';     }

  // This seems to be the easiest way to get a summary of sky conditions.
  // Options: clear-day, clear-night, rain, snow, sleet, wind, fog, 
  // cloudy, partly-cloudy-day, or partly-cloudy-night
  $atmo = $conditions_week[1]->getIcon();

  // Assign a color to each atmospheric condition 
      if($atmo == 'clear')               {$atmo_color = "yellow"; }
  elseif($atmo == 'clear-day')           {$atmo_color = "yellow"; }
  elseif($atmo == 'clear-night')         {$atmo_color = "yellow"; }
  elseif($atmo == 'wind')                {$atmo_color = "white";  }
  elseif($atmo == 'fog')                 {$atmo_color = "white";  }
  elseif($atmo == 'cloudy')              {$atmo_color = "white";  }
  elseif($atmo == 'partly-cloudy')       {$atmo_color = "white";  }
  elseif($atmo == 'partly-cloudy-day')   {$atmo_color = "white";  }
  elseif($atmo == 'partly-cloudy-night') {$atmo_color = "white";  }
  elseif($atmo == 'rain')                {$atmo_color = "blue";   }
  elseif($atmo == 'snow')                {$atmo_color = "blue";   }
  elseif($atmo == 'sleet')               {$atmo_color = "blue";   }

  $results = array('temp_color' => $temp_color, 'atmo_color' => $atmo_color);
  return $results;

}

// Accepts color and returns 
function color_to_code($color) {
  
  if    ($color == 'white')     {$light_color = array('hue' => 34119, 'on' => true,   'bri' => 255, 'sat' => 255); }
  elseif($color == 'violet')    {$light_color = array('hue' => 53657, 'on' => true,   'bri' => 112, 'sat' => 225); }
  elseif($color == 'lt_blue')   {$light_color = array('hue' => 48000, 'on' => true,   'bri' => 255, 'sat' => 230); }
  elseif($color == 'blue')      {$light_color = array('hue' => 46920, 'on' => true,   'bri' => 255, 'sat' => 255); }
  elseif($color == 'green')     {$light_color = array('hue' => 25718, 'on' => true,   'bri' => 150, 'sat' => 255); }
  elseif($color == 'lt_green')  {$light_color = array('hue' => 27000, 'on' => true,   'bri' => 255, 'sat' => 255); }
  elseif($color == 'yellow')    {$light_color = array('hue' => 12697, 'on' => true,   'bri' => 255, 'sat' => 255); }
  elseif($color == 'orange')    {$light_color = array('hue' => 6421,  'on' => true,   'bri' => 252, 'sat' => 252); }
  elseif($color == 'red')       {$light_color = array('hue' => 65527, 'on' => true,   'bri' => 150, 'sat' => 255); }
  elseif($color == 'off')       {$light_color = array('hue' => 0,     'on' => false,  'bri' => 0,   'sat' => 0);   }

  return $light_color;

}

// Assigns colors to the lights using CURL
function set_color($light, $state) {

  global $bridge;

  $url = $bridge.'/api/newdeveloper/lights/'.$light.'/state';

  $json_string = json_encode($state);

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_exec($ch);

  $response = curl_exec($ch);
  echo $response."</br>"; 
  
  // DEBUG
  echo "<hr>";
  echo var_dump($json_string);

}

function lights_on() {

  global $temp_light;
  global $atmo_light;

  // Get the forecast info
  $results = get_forecast();

  // Get the temperature info
  $temp_code = color_to_code($results["temp_color"]);

  // Set the temperature light
  set_color($temp_light, $temp_code);

  // Get the atmospheric info
  $atmo_code = color_to_code($results["atmo_color"]);

  // Set the atmospheric light
  set_color($atmo_light, $atmo_code);

}

function lights_off() {

  global $temp_light;
  global $atmo_light;

  // Get the temperature info
  $off_code = color_to_code('off');

  // Turn off the temperature light
  set_color($temp_light, $off_code);

  // Turn off the atmospheric light
  set_color($atmo_light, $off_code);

}

?>