# Weatherizer
## User Based:
    - User can input their location
    - User has additional favourite locations
    - User can input their temperature preference
## Weather Based:
    - Weather API (OpenWeatherMap)
    - Current Weather data
    - Weather forecast
    - Detailed Rain forecast

## Requirements
For this application to work, you'll need to get an API key from [openweathermap.org](https://openweathermap.org/) and subscribe to the **One Call API 3.0**. Make sure to limit your max number of requests to 1.000 to avoid billing.

## Installation

1. Run composer install
`php composer.phar install`

2. Import weatherizer.sql to your database.

3. Create .env file with the following values:
    ```
    OPENWEATHERMAP_API_KEY = ""
    DB_HOST = ""
    DB_DATABASE = ""
    DB_USERNAME = ""
    DB_PASSWORD = ""
    ```