<?php

/**
 * PHP version 5
 * @copyright  sr-tag.de 2013
 * @author     Sven Rhinow
 * @package    beekeeping
 * @license    LGPL
 * @filesource
 */

/**
*Table tl_bk_colonies
*/
$GLOBALS['TL_DCA']['tl_bk_colonies'] = array
(
	//Config
	'config' => array
	(
		'dataContainer' => 'Table',
		'ctable'                      => array('tl_bk_hivemap'),
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
			'mode'                    => 2,
			'fields'                  => array('date DESC', 'hive_number', 'main_site'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('date','hive_number', 'hive_notice', 'main_site','death'),
			'format'                  => '%s - <span style="font-weight: bold;">%s (%s)</span> - <span>%s</span>, %s',
// 			'label_callback'          => array('tl_bk_colonies', 'lookup_pid')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
					'href'                => 'act=select',
					'class'               => 'header_edit_all',
					'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'hivemap' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_colonies']['hivemap'],
				'href'                => 'table=tl_bk_hivemap',
				'icon'                => $GLOBALS['BKM_MODULE_PATH'].'/assets/icons/table_18.png',
				'button_callback'     => array('tl_bk_colonies', 'hivemapLink')
			),
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_colonies']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_colonies']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_colonies']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bk_colonies']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		// '__selector__'                => array(''),
		'default'                     => 'date,location;{hive_legend},hive_number,hive_notice;{breed_legend},breed,breed_notice,nativity_id,nativity;{additional_legend},notice,death'
	),
	// Subpalettes
	'subpalettes' => array
	(
		// ''                            => ''
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
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['date'],
			'inputType'               => 'text',
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array('mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'wizard w50', 'minlength' => 1, 'maxlength'=>10, 'rgxp' => 'date'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'hive_number' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['hive_number'],
			'foreignKey'              => 'tl_bk_bkm_bee_prey.nr',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>false, 'chosen'=>true, 'includeBlankOption'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'hive_notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['hive_notice'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'breed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['breed'],
			'foreignKey'              => 'tl_bk_bkm_bee_breed.name',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50', 'includeBlankOption'=>false,'submitOnChange'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'breed_notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['breed'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'location' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['location'],
			'foreignKey'              => 'tl_bk_bkm_location.name',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50', 'includeBlankOption'=>false,'submitOnChange'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'nativity_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['nativity_id'],
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_bk_colonies', 'getNativityOptions'),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'nativity' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['nativity'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['notice'],
			'exclude'                 => true,
			'search'				  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'                     => "text NULL"
		),
		'death' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bk_colonies']['death'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'checkbox',
			'flag'                    => 11,
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);

/**
 * Class tl_bk_colonies
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_bk_colonies extends Backend
{
	/**
	 * Return the edit Hieve button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function hivemapLink($row, $href, $label, $title, $icon, $attributes)
	{
	    return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * get custom view from library-item-options
	 * @param object
	 * @throws Exception
	 */
	public function getNativityOptions(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT * FROM `tl_bk_colonies` WHERE `id` !=? AND death != 1 ORDER BY `hive_number` ASC')
				  ->execute($dc->id);
		while($all->next())
		{
			$varValue[$all->id] = $all->hive_number.' ('.$all->hive_notice.')';
		}
		return $varValue;
	}

}
