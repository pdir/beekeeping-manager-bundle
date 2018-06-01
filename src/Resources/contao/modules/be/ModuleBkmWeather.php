<?php
namespace Bkm\Modules\Be;
/**
 * @copyright  Sven Rhinow 2018
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    beekeeping-manager-bundle
 * @license    LGPL
 * @filesource
 */

use Contao\BackendModule;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Contao\Date;
use Contao\StringUtil;
use Haste\DateTime\DateTime;

/**
 * Class ModuleBkmWeather
 * Back end module "open weather map".
 */
class ModuleBkmWeather extends BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_bkm_weather';

	/**
	 * @var array
	 */
	protected $arrModules = array();

    /**
     * @var string
     */
    protected $timeZone = "Europe/Berlin";

    /**
     * Language of data (try your own language here!):
     * @var string
     */
    protected $lang = 'de';

	/**
	 * Generate the module
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
        // Language of data (try your own language here!):


        // Units (can be 'metric' or 'imperial' [default]):
        $units = 'metric';
        $weather = null;
        // Create OpenWeatherMap object.
        // Don't use caching (take a look into Examples/Cache.php to see how it works).
        $owm = new OpenWeatherMap(OPENWEATHERMAP_API_KEY);
        $query = ['lat'=>'53.2506801','lon'=>'12.0466287'];

        //get current Weather
        try {
            $weather = $owm->getWeather($query, $units, $this->lang);
        } catch(OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch(\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }

        //get Forecast weather
        try {
            $forecast = $owm->getWeatherForecast($query, $units, $this->lang, '', 3);
        } catch(OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch(\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }

//        $sunset = $weather->sun->rise;
//        $weatherUtil = new OpenWeatherMap\Util\Weather();

        $this->Template->temperature = $weather->temperature->getFormatted();
        $this->Template->humidity = $weather->humidity->getFormatted();
        $this->Template->pressure = $weather->pressure->getFormatted();
        $this->Template->wind_speed = number_format($weather->wind->speed->getValue() * 3.6, 2,',','.');
        $this->Template->wind_direction = $weather->wind->direction->getUnit();
        $this->Template->clouds = $weather->clouds->getDescription();
        $this->Template->precipitation = $weather->precipitation->getFormatted();
        $this->Template->sunset = date('H:i',$weather->sun->set->setTimezone(new \DateTimeZone($this->timeZone))->getTimestamp());
        $this->Template->sunrise = date('H:i',$weather->sun->rise->setTimezone(new \DateTimeZone($this->timeZone))->getTimestamp());
        $this->Template->iconurl = $weather->weather->getIconUrl();
        $this->Template->forecastArr = $this->getForecastWeatherAsArray($forecast, 5);
//        print_r($weather); exit();

	}

    /**
     * @param object $forecast
     * @param int $days
     * @return array
     */
    protected function getForecastWeatherAsArray($forecast,$days=3) {
        $returnArr = [];

        for($i=1; $i <= $days; $i++){

            $dayTime = new DateTime('+'.$i.' days');
            $dayTime->setTime('13','00');
            $dayTimestamp = $dayTime->getTimestamp();

            $nightTime = new DateTime('+'.$i.' days');
            $nightTime->setTime('00','01');
            $nightTimestamp = $nightTime->getTimestamp();

            foreach ($forecast as $weather) {
//                print_r($weather->wind->direction->getUnit());exit();

                $timestampDay = $weather->time->day->setTimeZone(new \DateTimeZone($this->timeZone))->getTimestamp();
                $timestampFrom = $weather->time->from->setTimeZone(new \DateTimeZone($this->timeZone))->getTimestamp();
                $timestampTo = $weather->time->to->setTimeZone(new \DateTimeZone($this->timeZone))->getTimestamp();
                $saveInArray = false;
                $dayType = 'day';
                $timeStamp = $timestampDay;

                if(($dayTimestamp >= $timestampFrom && $dayTimestamp <= $timestampTo)) { $saveInArray = true; $timeStamp =$dayTimestamp; $dayType = 'day';}
                if(($nightTimestamp >= $timestampFrom && $nightTimestamp <= $timestampTo)) { $saveInArray = true; $timeStamp =$nightTimestamp; $dayType = 'night';}
                if(!$saveInArray) continue;

                $returnArr[$timeStamp] = [
//                    'data' => $weather,
                    'dayType' => $dayType,
                    'date' => $weather->time->day->format('d.m.Y'),
                    'time_from' => $weather->time->from->format('H:i'),
                    'time_to' => $weather->time->to->format('H:i'),
                    'temparature_now' => $weather->temperature->now->getValue(),
                    'temparature_min' => $weather->temperature->min->getValue(),
                    'temparature_max' => $weather->temperature->max->getValue(),
                    'humidity' => $weather->humidity->getValue(),
                    'pressure' => $weather->pressure->getValue(),
                    'wind_speed' => number_format($weather->wind->speed->getValue() * 3.6, 0,',','.'),
                    'wind_direction' => $weather->wind->direction->getDescription(),
                    'wind_direction_short' => $weather->wind->direction->getUnit(),
                    'sun_rise' => $weather->sun->rise->format('H:i (e)'),
                    'sun_set' => $weather->sun->set->format('H:i (e)'),
                    'clouds' => $weather->clouds->getDescription(),
                    'icon' => $weather->weather->getIconUrl()
                ];
            }
        }
//        print_r($returnArr);exit();
        return $returnArr;
    }
}

