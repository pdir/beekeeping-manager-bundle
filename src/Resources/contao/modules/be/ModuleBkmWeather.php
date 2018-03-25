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
	 * Isotope modules
	 * @var array
	 */
	protected $arrModules = array();


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
        $lang = 'de';

        // Units (can be 'metric' or 'imperial' [default]):
        $units = 'metric';
        $weather = null;
        // Create OpenWeatherMap object.
        // Don't use caching (take a look into Examples/Cache.php to see how it works).
        $owm = new OpenWeatherMap(OPENWEATHERMAP_API_KEY);
        $query = ['lat'=>'53.2506801','lon'=>'12.0466287'];
        try {
            $weather = $owm->getWeather($query, $units, $lang);
        } catch(OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch(\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }
//        $sunset = $weather->sun->rise;
//        $berlindate = $weather->sun->set->setTimezone(new \DateTimeZone("Europe/Berlin"));
//        $weatherUtil = new OpenWeatherMap\Util\Weather()
//        print $weather->getIconUrl();
//        print_r(date('d.m.Y H:i',$berlindate->getTimestamp())); exit();
//        echo $weather->humidity->getValue(); exit();

        $this->Template->temperature = $weather->temperature->getFormatted();
        $this->Template->humidity = $weather->humidity->getFormatted();
        $this->Template->pressure = $weather->pressure->getFormatted();
        $this->Template->wind_speed = number_format($weather->wind->speed->getValue() * 3.6, 2,',','.') . 'km/h';
        $this->Template->wind_direction = $weather->wind->direction->getUnit();
        $this->Template->clouds = $weather->clouds->getDescription();
        $this->Template->precipitation = $weather->precipitation->getFormatted();
        $this->Template->sunset = date('H:i',$weather->sun->set->setTimezone(new \DateTimeZone("Europe/Berlin"))->getTimestamp());
        $this->Template->sunrise = date('H:i',$weather->sun->rise->setTimezone(new \DateTimeZone("Europe/Berlin"))->getTimestamp());
        $this->Template->iconurl = $weather->weather->getIconUrl();
//        print_r($weather); exit();

	}


}

