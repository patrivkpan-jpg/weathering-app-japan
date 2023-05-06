# weathering-app-japan

## A simple app to check the weather in 6 different cities in Japan.
1. Tokyo
2. Yokohama
3. Kyoto
4. Osaka
5. Sapporo
6. Nagoya
### Developed with Laravel 10 and Vuejs 3


## Supported APIs
| APIs | Data retrieved |
| --- | --- |
| [Foursquare Place Search API](https://location.foursquare.com/developer/reference/place-search) | Used to retrieve the latitude and longitude of the city. |
| [Open Weather Map Daily API](https://openweathermap.org/forecast5) | Used to retrieve temperature, feels like temperature, weather, and wind speed for 5 days. |


## Local Setup
### We will use Homestead to setup the project on our local environment.
### Required 
1. [Oracle VirtualBox](https://www.virtualbox.org/wiki/Downloads)
2. [Vagrant](https://www.vagrantup.com/downloads)

### Setup Homestead
1. Run `git clone https://github.com/laravel/homestead.git ~/Homestead` to clone Homestead
2. Redirect to the Homestead directory by running `cd ~/Homestead`
3. Checkout to the release branch `git checkout release`
4. Run the following command to create the **Homestead.yaml** file
```
# macOS / Linux...
bash init.sh
 
# Windows...
init.bat
```
5. Add the following to the Homestead.yaml file
```
folders:

    - map: /path/to/the/app/weathering-app-japan
      to: /home/vagrant/weathering-app-japan

    - map: ~/code
      to: /home/vagrant/code

sites:

    - map: weathering-app-japan.com
      to: /home/vagrant/weathering-app-japan/public

    - map: homestead.test
      to: /home/vagrant/code/public
```
6. Next, run a text editor as administrator and update the **hosts** file
```
192.168.56.56  weathering-app-japan.com
```
7. Run `vagrant up` to initiate Homestead. This will take a while because it will download the Homestead box for your virtual machine.
8. After Homestead is initiated, run `vagrant ssh` to SSH into the newly created VM.
9. Redirect to the project by typing `cd /home/vagrant/weathering-app-japan`
10. Run `composer install` to install the composer packages needed.
11. Generate an **APP_KEY** by executing the command `php artisan key:generate`.
12. An **.env** file should be created for you, inside it, add the following key-value pair.
```
FOURSQUARE_API_KEY=fsq3F6cFzv9rUyhZxJpc/gcqCvz7a7pLl90osR6+dWXc3Hs=
OPEN_WEATHER_API_KEY=dcca5aa68b3b6d3347b4cbbaa2e87fc6
```
13. Run `npm run build` to install node packages.

And done! You should now be able to access the app at http://weathering-app-japan.com/ on your browser.

## Implementation explanation
### Frontend
Since the app is a single-page application, I developed the frontend with Vuejs. This made data updates and DOM manipulation much easier.

### UI/UX
Since the app will be mainly used by tourists who have more access to their phones than to a desktop or laptop, I focused the CSS design with mobile-first in mind. And since the number of cities is limited, I chose style the city selection as a navbar to minimize user action (a single tap/click will change which the selected city).

### Backend
For the backend, I chose Laravel. I created two different controllers; one for place search API and another for the open weather API. I did this to so each controller only does it's intended function instead of bundling everything together in a single function. This also allows the code open for future improvements. Let's say that our client wants our app to have a function to search tourist spots. We can re-use **PlaceController's getPlace** function alone without manipulating **WeatherController's getWeather** function.

Additionally, I also created a **GuzzleHelper** class with a static **request** method of all our guzzle needs. We can use this function without initializing a **GuzzleHelper** class for future API calls.