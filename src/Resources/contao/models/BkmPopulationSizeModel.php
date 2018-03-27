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
 * @method static BkmPopulationSizeModel|null findById($id, $opt=array())
 * @method static BkmPopulationSizeModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmPopulationSizeModel|null findByPk($id, $opt=array())
 * @method static BkmPopulationSizeModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmPopulationSizeModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmPopulationSizeModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmPopulationSizeModel[]|BkmPopulationSizeModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmPopulationSizeModel[]|BkmPopulationSizeModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmPopulationSizeModel[]|BkmPopulationSizeModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmPopulationSizeModel[]|BkmPopulationSizeModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmPopulationSizeModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_population_size';

}
