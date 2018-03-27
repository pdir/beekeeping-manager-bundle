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
 * @method static BkmColoniesModel|null findById($id, $opt=array())
 * @method static BkmColoniesModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmColoniesModel|null findByPk($id, $opt=array())
 * @method static BkmColoniesModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmColoniesModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmColoniesModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmColoniesModel[]|BkmColoniesModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmColoniesModel[]|BkmColoniesModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmColoniesModel[]|BkmColoniesModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmColoniesModel[]|BkmColoniesModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmColoniesModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_colonies';

}
