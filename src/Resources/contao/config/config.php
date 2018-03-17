<?php
/**
 * @copyright  Sven Rhinow 2018
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    beekeeping-manager-bundle
 * @license    LGPL
 * @filesource
 */

/**
 * beekeeping-manager-bundle Version
 */
@define('IAO_VERSION', '1.0');
@define('IAO_BUILD', '0');
@define('BKM_PATH','vendor/srhinow/beekeeping-manager-bundle');
@define('BKM_PUBLIC_FOLDER','bundles/srhinowprojectmanager');
/**
 * Add back end modules
 */

if(!$GLOBALS['BE_MOD']['beekeeping']) array_insert($GLOBALS['BE_MOD'], 1, array( 'beekeeping' => array() ) );

array_insert($GLOBALS['BE_MOD']['beekeeping'], 0, array(
	'bk_bkm' => array
		(
			'callback'	=> 'ModuleBkmSetup',
			'tables' => array(),
			'icon'   => BKM_PUBLIC_FOLDER.'/assets/icons/beekeeping.png',
			'stylesheet' => BKM_PUBLIC_FOLDER.'/assets/css/be.css',
		)
	)
);

/**
 * beekeeper management Modules
 */
$GLOBALS['BK_BKM_MOD'] = array
(
	'bkm_entries' => array
	(
		'bk_bkm_bee_prey' => array
		(
			'tables'					=> array('tl_bk_bkm_bee_prey','tl_bk_colonies','tl_bk_hivemap'),
			'icon'   => BKM_PUBLIC_FOLDER.'/assets/icons/caution_board.png',
		),
		'bk_bkm_colonies' => array
		(
			'tables' => array('tl_bk_colonies','tl_bk_hivemap'),
			'icon'   => BKM_PUBLIC_FOLDER.'/assets/icons/hive.png',
			'stylesheet' => BKM_PUBLIC_FOLDER.'/assets/css/be.css',
			'csvExport' => array('beBeekeepingExport', 'csvExport'),
			'pdfExport' => array('beBeekeepingExport', 'pdfExport'),
		)
	),
	'bkm_properties' => array
	(
		'bk_bkm_bee_breed' => array
		(
			'tables'					=> array('tl_bk_bkm_bee_breed'),
			'icon'   => BKM_PUBLIC_FOLDER.'/assets/icons/crown_gold.png',
		),
		'bk_bkm_location' => array
		(
			'tables'					=> array('tl_bk_bkm_location'),
			'icon'						=> BKM_PUBLIC_FOLDER.'/assets/icons/map.png',
		),
		'bk_bkm_population_size' => array
		(
			'tables'					=> array('tl_bk_bkm_population_size'),
			'icon'						=> BKM_PUBLIC_FOLDER.'/assets/icons/layer_grid.png',
		),
		'bk_bkm_gentleness' => array
		(
			'tables'					=> array('tl_bk_bkm_gentleness'),
			'icon'						=> BKM_PUBLIC_FOLDER.'/assets/icons/heart_half.png',
		),
		'bk_bkm_frame_dimensions' => array
		(
			'tables'					=> array('tl_bk_bkm_frame_dimensions'),
			'icon'   => BKM_PUBLIC_FOLDER.'/assets/icons/picture_frame.png',
		),
	)
);


// Enable tables in iao_setup
if ($_GET['do'] == 'bk_bkm')
{
	foreach ($GLOBALS['BK_BKM_MOD'] as $strGroup=>$arrModules)
	{
		foreach ($arrModules as $strModule => $arrConfig)
		{
			if (is_array($arrConfig['tables']))
			{
				$GLOBALS['BE_MOD']['beekeeping']['bk_bkm']['tables'] = array_merge($GLOBALS['BE_MOD']['beekeeping']['bk_bkm']['tables'], $arrConfig['tables']);
			}
		}
	}
}

/**
 * Frontend modules
 */
// $GLOBALS['FE_MOD']['beekeeping_colonies'] = array('bk_colonies' => 'ModuleColonyTable');

/**
 * HOOKS
 */
// $GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('mpMembers', 'changeIAOTags');
