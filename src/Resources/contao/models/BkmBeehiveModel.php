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
 * @method static BkmBeehiveModel|null findById($id, $opt=array())
 * @method static BkmBeehiveModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmBeehiveModel|null findByPk($id, $opt=array())
 * @method static BkmBeehiveModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmBeehiveModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmBeehiveModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmBeehiveModel[]|BkmBeehiveModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmBeehiveModel[]|BkmBeehiveModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmBeehiveModel[]|BkmBeehiveModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmBeehiveModel[]|BkmBeehiveModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmBeehiveModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_beehive';

}
