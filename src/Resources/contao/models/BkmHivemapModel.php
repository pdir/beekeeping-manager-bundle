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
 * @method static BkmHivemapModel|null findById($id, $opt=array())
 * @method static BkmHivemapModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmHivemapModel|null findByPk($id, $opt=array())
 * @method static BkmHivemapModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmHivemapModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmHivemapModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmHivemapModel[]|BkmHivemapModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmHivemapModel[]|BkmHivemapModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmHivemapModel[]|BkmHivemapModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmHivemapModel[]|BkmHivemapModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmHivemapModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_hivemap';

}
