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
 * Table tl_bkm_hivemaps
 */
use Contao\Backend;

$GLOBALS['TL_DCA']['tl_bkm_hivemap'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'             => 'Table',
		'ptable'                    => 'tl_bkm_colonies',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'custom_headline'			=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['cust_headline'],
		'headline_callback'         => array('Bkm\Dca\Hivemap', 'custHeadline'),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
		'oncreate_callback' => array
		(
		),
		'onsubmit_callback' => array
		(
		)

	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			// 'flag'					=> 7,
			'fields'                  => array('date DESC'),
			'headerFields'            => array('hive_number', 'hive_notice', 'main_site'),
			'panelLayout'             => 'filter;sort,limit;search',
			'panelLayout'             => 'filter;sort,limit;search',
			'child_record_class'      => 'no_padding'
		),
		'label' => array
		(
			'fields'                  => array('date', 'description'),
			'format'                  => '%s: %s',
// 			'label_callback'          => array('tl_bkm_hivemap', 'listEntries'),
		),
		'global_operations' => array
		(
		    // ToDo: PDF und CSV-Export lauffähig machen
			'pdfExport' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['pdfExport'],
				'href'                => 'key=pdfExport',
				'class'               => 'pdf_export',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'csvExport' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['csvExport'],
				'href'                => 'key=csvExport',
				'class'               => 'csv_export',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('type'),
		'default'                     => 'type,date,description;{rating_legend},rating_breed,rating_feed,rating_gentleness;{frame_legend},frames;{medication_legend:hide},medication;{feed_legend:hide},feed',
		'location'                     => 'type,date,location',
		'status'                     => 'type,date,status',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'modify' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'type' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['type'],
			'default'               => 'item',
			'exclude'               => true,
			'filter'                => true,
			'inputType'             => 'select',
			'options' 		  		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['type_options'],
			'eval'                  => array( 'submitOnChange'=>true,'tl_class'=>'w50'),
			'sql'					=> "varchar(32) NOT NULL default 'item'"
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['date'],
			'inputType'               => 'text',
			'default'				  => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'eval'                    => array('mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'wizard w50', 'minlength' => 1, 'maxlength'=>10, 'rgxp' => 'date'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['description'],
			'exclude'                 => true,
			'search'				  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false, 'helpwizard'=>true,'tl_class'=>'clr long'),
			'explanation'             => 'shortCuts',
			'sql'                     => "text NULL"
		),
		'location' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['location'],
			'foreignKey'              => 'tl_bkm_location.name',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50', 'includeBlankOption'=>false,'submitOnChange'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'status' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['status'],
			'default'               => 'item',
			'exclude'               => true,
			'filter'                => true,
			'inputType'             => 'select',
			'options' 		  		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['status_options'],
			'eval'                  => array('tl_class'=>'clr w50', 'submitOnChange'=>true),
			'sql'					=> "varchar(32) NOT NULL default 'item'"
		),
		'frames' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['frames'],
			'exclude'                 => true,
			'inputType'               => 'multiColumnWizard',
			'eval' => array(
				// 'style'                 => 'width:100%;',
				'doNotCopy'=>true,
				'columnFields' => array
				(
					'sign' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign_options'],
						'eval'              => array( 'tl_class'=>'wizard','style' => 'width:50px;'),
					),
					'count' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['count'],
						'inputType'         => 'text',
						'eval'              => array('style' => 'width:80px'),
						'default'			=> 0
					),
					'frame_types' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['frame_types'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['frametype_options'],
						'eval'              => array('style' => 'width:350px;'),
					)
				)
			),
			'sql'				=> "blob NULL"
		),
		'medication' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['medication'],
			'exclude'                 => true,
			'inputType'               => 'multiColumnWizard',
			'eval' => array(
				'doNotCopy'=>true,
				'columnFields' => array
				(
					'sign' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign_options'],
						'eval'              => array( 'tl_class'=>'wizard','style' => 'width:50px'),
					),
					'count' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['count'],
						'inputType'         => 'text',
						'eval'              => array('style' => 'width:80px'),
						'default'			=> 0
					),
					'volume' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['volume'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['volumes_options'],
						'eval'              => array( 'tl_class'=>'wizard','style' => 'width:100px'),
					),
					'medi_types' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['medi_types'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['meditype_options'],
						'eval'              => array('style' => 'width:350px;'),
					)
				)
			),
			'sql'				=> "blob NULL"
		),
		'feed' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed'],
			'exclude'                 => true,
			'inputType'               => 'multiColumnWizard',
			'eval' => array(
				'doNotCopy'=>true,
				'columnFields' => array
				(
					'sign' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign_options'],
						'eval'              => array( 'tl_class'=>'wizard','style' => 'width:50px'),
					),
					'count' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['count'],
						'inputType'         => 'text',
						'eval'              => array('style' => 'width:80px'),
						'default'			=> 0
					),
					'volume' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['volume'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['volumes_options'],
						'eval'              => array( 'tl_class'=>'wizard','style' => 'width:100px'),
					),
					'feed_types' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed_types'],
						'inputType'         => 'select',
						'options'   		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed_options'],
						'eval'              => array('style' => 'width:350px;'),
					)
				)
			),
			'sql'				=> "blob NULL"
		),
        'rating_breed' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_breed'],
            'default'               => 'item',
            'exclude'               => true,
            'inputType'             => 'select',
            'options' 		  		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_breed_options'],
            'eval'                  => array('tl_class'=>'w50', 'includeBlankOption'=>true),
            'sql'					=> "varchar(32) NOT NULL default 'item'"
        ),
        'rating_feed' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_feed'],
            'default'               => 'item',
            'exclude'               => true,
            'inputType'             => 'select',
            'options' 		  		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_feed_options'],
            'eval'                  => array('tl_class'=>'w50', 'includeBlankOption'=>true),
            'sql'					=> "varchar(32) NOT NULL default 'item'"
        ),
        'rating_gentleness' => array
        (
            'label'                 => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_gentleness'],
            'default'               => 'item',
            'exclude'               => true,
            'inputType'             => 'select',
            'options' 		  		=> &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_gentleness_options'],
            'eval'                  => array('tl_class'=>'w50', 'includeBlankOption'=>true),
            'sql'					=> "varchar(32) NOT NULL default 'item'"
        ),

	)
);

/**
 * Class Bkm\Dca\Hivemap
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class Hivemap extends Backend
{
    /**
     * get custom view from colonies-options
     * @param $headline
     * @return string
     */
	public function custHeadline($headline)
	{

		if($headline != '' && $this->Input->get('id'))
        {
			$resObj = $this->Database->prepare('SELECT * FROM `tl_bkm_colonies` WHERE `id` =?')
					  ->execute($this->Input->get('id'));

			if($resObj->numRows > 0)  $headline = sprintf($headline, $resObj->hive_number, $resObj->hive_notice);

		}
		return $headline;
	}


}
