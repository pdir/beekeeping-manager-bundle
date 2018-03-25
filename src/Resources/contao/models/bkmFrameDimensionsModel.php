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
 * @method static BkmFrameDimensionsModel|null findById($id, $opt=array())
 * @method static BkmFrameDimensionsModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmFrameDimensionsModel|null findByPk($id, $opt=array())
 * @method static BkmFrameDimensionsModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmFrameDimensionsModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmFrameDimensionsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmFrameDimensionsModel[]|BkmFrameDimensionsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmFrameDimensionsModel[]|BkmFrameDimensionsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmFrameDimensionsModel[]|BkmFrameDimensionsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmFrameDimensionsModel[]|BkmFrameDimensionsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmFrameDimensionsModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_frame_dimensions';

}
