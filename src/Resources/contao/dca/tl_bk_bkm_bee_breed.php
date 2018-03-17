<?php

/**
 *
 * PHP version 5
 * @copyright  sr-tag.de 2017
 * @author     Sven Rhinow
 * @package    beekeeping
 * @license    LGPL
 * @filesource
 */

/**
*Table tl_bk_bkm_bee_breed
*/
$GLOBALS['TL_DCA']['tl_bk_bkm_bee_breed'] = array
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
			'fields'                  => array('name'),
			// 'disableGrouping'		  => true,
			'flag'                    => 11,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('name','short'),
			'format'                  => '%s, (%s)',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'default' => 'name,short,notiz,sorting'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['name'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'short' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['short'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false,'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'notiz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['notiz'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'sorting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_bkm_bee_breed']['sorting'],
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),

	)
);

/**
 * Class tl_bk_bkm_bee_breed
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_bk_bkm_bee_breed extends Backend
{
	/**
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}

	/**
	 * get all invoice before template
	 * @param object
	 * @throws Exception
	 */
	public function getFrameDimensionsOptions(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`name` FROM `tl_bk_bkm_frame_dimensions`')
				->execute();

		while($all->next())
		{
			$varValue[$all->id] = $all->name;
		}

	    return $varValue;
	}
}
