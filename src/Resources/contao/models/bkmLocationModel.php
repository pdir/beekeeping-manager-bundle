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
 * @method static BkmLocationModel|null findById($id, $opt=array())
 * @method static BkmLocationModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmLocationModel|null findByPk($id, $opt=array())
 * @method static BkmLocationModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmLocationModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmLocationModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmLocationModel[]|BkmLocationModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmLocationModel[]|BkmLocationModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmLocationModel[]|BkmLocationModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmLocationModel[]|BkmLocationModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmLocationModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_location';

}
