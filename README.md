# hue_forecast
A basic weather display system built with [Phillips Hue lights][hue] and the [Forecast.io API][API].

## Description
hue_forecast uses two Hue lights to display today's high temperature and atmospheric condition. The first light uses a rough approximation of the NOAA color scale to represent the high temperature. The second uses a three color system for sun (yellow), rain (blue), or clouds (white).

hue_forecast uses Tobias Redmann's excellent [forecast.io-php-api][php-api] library to grab weather data from Forecast.io.

## Requirements
- Two Hue lights and a Hue bridge
- [A Forecast.io developer key][dev_key]
- [Latitude and longitude for your location][lat&long]
- A computer running PHP

## Instructions

### Get the code
Ideally your computer has git installed. 

If so checkout the code with:
`git clone git@github.com:mikeswimm/hue_forecast.git` 

Then run:
  `git submodule init`

and:
  `git submodule update`

to load the Forecast.io library as a submodule. 

If you don't have git installed [click to download the zipped directory][zip_link]. 

[hue]:      http://meethue.com
[api]:      https://developer.forecast.io/docs/v2
[php-api]:  https://github.com/tobias-redmann/forecast.io-php-api
[lat&long]: https://www.google.com/#q=find+latitude+and+longitude+google
[dev_key]:  https://developer.forecast.io/register
[zip_link]: https://github.com/mikeswimm/hue_forecast/archive/master.zip