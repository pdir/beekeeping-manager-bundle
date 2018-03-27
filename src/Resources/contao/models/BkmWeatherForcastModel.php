<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Srhinow;

use Contao\Model;

/**
 * Reads and writes Credit Items
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static BkmWeatherForcastModel|null findById($id, $opt=array())
 * @method static BkmWeatherForcastModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmWeatherForcastModel|null findByPk($id, $opt=array())
 * @method static BkmWeatherForcastModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmWeatherForcastModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmWeatherForcastModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmWeatherForcastModel[]|BkmWeatherForcastModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmWeatherForcastModel[]|BkmWeatherForcastModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmWeatherForcastModel[]|BkmWeatherForcastModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmWeatherForcastModel[]|BkmWeatherForcastModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmWeatherForcastModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_weather_forcast';

}
