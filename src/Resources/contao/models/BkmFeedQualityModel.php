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
 * @method static BkmFeedQualityModel|null findById($id, $opt=array())
 * @method static BkmFeedQualityModel|null findByIdOrAlias($val, $opt=array())
 * @method static BkmFeedQualityModel|null findByPk($id, $opt=array())
 * @method static BkmFeedQualityModel|null findOneBy($col, $val, $opt=array())
 * @method static BkmFeedQualityModel|null findOneByTstamp($val, $opt=array())
 * @method static BkmFeedQualityModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|BkmFeedQualityModel[]|BkmFeedQualityModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|BkmFeedQualityModel[]|BkmFeedQualityModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|BkmFeedQualityModel[]|BkmFeedQualityModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|BkmFeedQualityModel[]|BkmFeedQualityModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class BkmFeedQualityModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_bkm_feed_quality';

}
