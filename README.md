# hue_forecast
A basic weather display system built with [Phillips Hue lights][hue] and the [Forecast.io API][API].

## Description
hue_forecast uses two Hue lights to display today's high temperature and atmospheric condition. The first light uses a rough approximation of the NOAA color scale to represent the high temperature. The second uses a three color system for sun (yellow), rain (blue), or clouds (white).

hue_forecast uses Tobias Redmann's excellent forecast.io-php-api library to grab weather data from Forecast.io.

## Requirements
- Two Hue lights and a Hue bridge
- A Forecast.io developer key
- Latitude and longitude for your location
- A computer running PHP

[hue]:      http://meethue.com
[api]:      https://developer.forecast.io/docs/v2
[php-api]:  https://github.com/tobias-redmann/forecast.io-php-api
