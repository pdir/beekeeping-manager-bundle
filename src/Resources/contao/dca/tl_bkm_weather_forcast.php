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
*Table tl_bkm_weather_forcast
*/


$GLOBALS['TL_DCA']['tl_bkm_weather_forcast'] = array
(
	//Config
	'config' => array
	(
		'dataContainer' => 'Table',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
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
        'city_name' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'city_country' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'city_lat' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),
        'city_lon' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),

		'sunrise' => array
		(
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'sunset' => array
		(
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'lastupdate' => array
		(
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'temperature' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),
        'humidity' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),
       'pressure' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),
        'wind_speed' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),
        'wind_direction' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(5) NOT NULL default ''"
        ),
        'cloud_value' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "int(3) unsigned NOT NULL default '0'"
        ),
        'cloud_description' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(25) NOT NULL default ''"
        ),
       'precipitation_value' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "float NOT NULL"
        ),
        'precipitation_description' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(25) NOT NULL default ''"
        ),
        'weather_id' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "int(3) unsigned NOT NULL default '0'"
        ),
        'weather_description' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(55) NOT NULL default ''"
        ),
       'weather_icon' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(25) NOT NULL default ''"
        )
	)
);