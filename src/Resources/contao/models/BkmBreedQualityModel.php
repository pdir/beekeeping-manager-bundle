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
 * @method static BkmBreedQualityModel|null findById($id, $opt=array())
 * @method static BkmBreedQualityModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmBreedQualityModel|null findByPk($id, $opt=array())
 * @method static BkmBreedQualityModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmBreedQualityModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmBreedQualityModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmBreedQualityModel[]|BkmBreedQualityModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmBreedQualityModel[]|BkmBreedQualityModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmBreedQualityModel[]|BkmBreedQualityModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmBreedQualityModel[]|BkmBreedQualityModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmBreedQualityModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_breed_quality';

}
