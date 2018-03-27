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
 * @method static BkmGentlenessModel|null findById($id, $opt=array())
 * @method static BkmGentlenessModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmGentlenessModel|null findByPk($id, $opt=array())
 * @method static BkmGentlenessModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmGentlenessModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmGentlenessModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmGentlenessModel[]|BkmGentlenessModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmGentlenessModel[]|BkmGentlenessModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmGentlenessModel[]|BkmGentlenessModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmGentlenessModel[]|BkmGentlenessModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmGentlenessModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_gentleness';

}
