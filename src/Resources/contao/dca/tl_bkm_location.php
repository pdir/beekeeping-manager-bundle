<?php
namespace Bkm\Dca;

/**
 * @copyright  Sven Rhinow 2018
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    beekeeping-manager-bundle
 * @license    LGPL
 * @filesource
 */

/**
*Table tl_bkm_location
*/
use Contao\Backend;
use Contao\Database;
use Contao\Image;
use linuskohl\orgLocationIQ;

$GLOBALS['TL_DCA']['tl_bkm_location'] = array
(
	//Config
	'config' => array
	(
		'dataContainer' => 'Table',
		'ctable' => 'tl_bkm_colonies',
		'enableVersioning' => true,
        'onsubmit_callback' => array
        (
            array('Bkm\Dca\Location', 'setGeoLocation')
        ),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('name'),
			'flag'					  => 1,
		),
		'label' => array
		(
			'fields'                  => array('name'),
			'format'                  => '%s',
		),
		'global_operations' => array
		(
			'back' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
				'href'                => 'mod=&table=',
				'class'               => 'header_back',
				'attributes'          => 'onclick="Backend.getScrollOffset();"',
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"',
			)
		),
		'operations' => array
		(
            'colonies' => array
            (
                'label'  => &$GLOBALS['TL_LANG']['tl_bkm_location']['colonies'],
                'href'   => 'table=tl_bkm_colonies&onlylocation=1',
                'icon'   => BKM_PUBLIC_FOLDER.'/icons/hive.png',
            ),
		    'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_location']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_location']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_location']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_location']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'default' => 'name,address,geo_lat,geo_lon;{extend_legend},notice,sorting'
	),
	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'modify' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_location']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'address' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_location']['address'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'geo_lat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_location']['geo_lat'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'geo_lon' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_location']['geo_lon'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_location']['notice'],
			'exclude'                 => true,
			'search'				  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false,'tl_class="clr full"'),
			'sql'                     => "text NULL"
		),
		'sorting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_location']['sorting'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>3, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),

	)
);

/**
 * Class tl_bkm_location
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class Location extends Backend
{
	/**
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
	public function pagePicker(\DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}

    /**
     * @param \DataContainer $dc
     */
    public function setGeoLocation(\DataContainer $dc)
    {
        if(strlen(($dc->activeRecord->geo_lat) < 1 || strlen($dc->activeRecord->geo_lat) < 1) && strlen($dc->activeRecord->address) > 0){
            $geoApi = new orgLocationIQ\Client(LOCATION_API_KEY);
            $geoApi->setLanguage('de');
            $result = $geoApi->geocode($dc->activeRecord->address);

            if(strlen($result[0]->lat) > 0 && strlen($result[0]->lon) > 0) {
                $set = [
                  'geo_lat' =>  $result[0]->lat,
                  'geo_lon' =>  $result[0]->lon
                ];
                Database::getInstance()->prepare('UPDATE tl_bkm_location %s WHERE id=?')->set($set)->execute($dc->id);

                $this->reload();
            }

        }
    }
}
