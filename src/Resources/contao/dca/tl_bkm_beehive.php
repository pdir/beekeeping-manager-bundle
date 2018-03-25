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
*Table tl_bkm_beehive
*/
use Contao\Backend;
use Contao\Database;
use Contao\Image;
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_bkm_beehive'] = array
(
	//Config
	'config' => array
	(
		'dataContainer' => 'Table',
		'enableVersioning'            => true,
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
			'fields'                  => array('nr'),
			// 'disableGrouping'		  => true,
			'flag'                    => 11,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('nr','notiz'),
			'format'                  => '%s, Notiz: %s',
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
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'default' => 'nr,frame_dimension,notiz,sorting;{status_legend},status,used_from'
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
		'nr' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['nr'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit','tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'notiz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['notiz'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'frame_dimension' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['frame_dimension'],
			'foreignKey'              => 'tl_bkm_frame_dimensions.name',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'sorting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['sorting'],
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'status' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['status'],
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'inputType'               => 'checkbox',
            'flag'                    => 11,
            'eval'                    => array('doNotCopy'=>true,'tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'used_from' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_beehive']['used_from'],
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
        ),
	)
);

/**
 * Class Bkm\Dca\Beehive
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class Beehive extends Backend
{
    /**
     * Return the link picker wizard
     * @param DataContainer $dc
     * @return string
     */
	public function pagePicker(DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}

    /**
     * get all invoice before template
     * @param DataContainer $dc
     * @return array
     */
	public function getFrameDimensionsOptions(DataContainer $dc)
	{
		$varValue= array();

		$all = Database::getInstance()->prepare('SELECT `id`,`name` FROM `tl_bk_bkm_frame_dimensions`')
				->execute();

		while($all->next())
		{
			$varValue[$all->id] = $all->name;
		}

	    return $varValue;
	}
}
