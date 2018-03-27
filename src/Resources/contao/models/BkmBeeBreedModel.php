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
 * @method static BkmBeeBreedModel|null findById($id, $opt=array())
 * @method static BkmBeeBreedModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmBeeBreedModel|null findByPk($id, $opt=array())
 * @method static BkmBeeBreedModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmBeeBreedModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmBeeBreedModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmBeeBreedModel[]|BkmBeeBreedModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmBeeBreedModel[]|BkmBeeBreedModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmBeeBreedModel[]|BkmBeeBreedModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmBeeBreedModel[]|BkmBeeBreedModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmBeeBreedModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_bee_breed';

}
