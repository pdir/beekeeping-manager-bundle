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
use Contao\Database;
use Contao\DataContainer;
use Contao\Date;
use Contao\Input;
use Srhinow\BkmBeehiveModel;
use Srhinow\BkmColoniesModel;
use Srhinow\BkmGentlenessModel;
use Srhinow\BkmHivemapModel;
use Srhinow\BkmLocationModel;

$GLOBALS['TL_DCA']['tl_bkm_hivemap'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'             => 'Table',
		'ptable'                    => 'tl_bkm_colonies',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
                'id' => 'primary',
                'pid' => 'index'
			)
		),
		'oncreate_callback' => array
		(
		),
		'onsubmit_callback' => array
		(
            array('Bkm\Dca\Hivemap', 'checkLocation'),
            array('Bkm\Dca\Hivemap', 'updateTablesStatus'),
		    array('Bkm\Dca\Hivemap','setCopyEntriesInOtherColonies'),
		)

	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
            'flag'                    => 1,
			'fields'                  => array('date DESC'),
			'headerFields'            => array('hive_number', 'hive_notice', 'main_site'),
			'panelLayout'             => '',
            'child_record_callback'   => array('Bkm\Dca\Hivemap', 'listItems')
		),
		'label' => array
		(
			'fields'                  => array('date', 'description'),
			'format'                  => '%s: %s',
		),
		'global_operations' => array
		(
		    // ToDo: PDF und CSV-Export lauffähig machen
			'pdfExport' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['pdfExport'],
				'href'                => 'key=pdfExport',
				'class'               => 'pdf_export',
//				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'csvExport' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['csvExport'],
				'href'                => 'key=csvExport',
				'class'               => 'csv_export',
//				'attributes'          => 'onclick="Backend.getScrollOffset();"'
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
		'__selector__'                => array('type','multi_entry'),
		'default'                     => 'type;{multi_entry_legend},multi_entry;{basic_legend},date,description;{rating_legend},rating_breed,rating_feed,rating_gentleness;{frame_legend},frames;{medication_legend:hide},medication;{feed_legend:hide},feed',
		'location'                     => 'type,location;{multi_entry_legend},multi_entry;{basic_legend},date,description',
		'status'                     => 'type,date,status',
	),
    // Subpalettes
    'subpalettes' => array
    (
        'multi_entry' => ('other_colonies')
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
		'copy_from' => array
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
		'multi_entry' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['multi_entry'],
            'filter'                  => true,
            'flag'                    => 1,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true),
            'sql'					  => "char(1) NOT NULL default ''"
        ),
        'other_colonies' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_hivemap']['other_colonies'],
            'flag'                    => 1,
            'inputType'               => 'checkboxWizard',
//            'foreignKey'              => 'tl_bkm_colonies.hive_number',
            'options_callback'        => array('Bkm\Dca\Hivemap', 'getOtherColoniesOptions'),
            'eval'                    => array('multiple'=>true),
            'sql'                     => "blob NULL",
//            'relation'                => array('type'=>'belongsToMany', 'load'=>'lazy')
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
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50', 'includeBlankOption'=>false,'submitOnChange'=>false),
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
			'eval'                  => array('tl_class'=>'clr w50', 'submitOnChange'=>false),
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
            'options_callback'        => array('Bkm\Dca\Hivemap', 'getGentlenessOptions'),
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
    public function listItems($arrRow){

//        if($arrRow['type'] == 'location' && $arrRow['location'] > 0)
//        {
//            $objLocation = BkmLocationModel::findByIdOrAlias($arrRow['location']);
//            $arrRow['description'] = $objLocation->name;
//        }
        return '<div class="tl_content_left"><div style="float:left;color:#b3b3b3;padding-right:10px">[' . Date::parse($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['date']) . ']</div> <div style="float:left;">' . nl2br($arrRow['description']) . '</div><div style="clear:both;"><br></div></div>';

    }

    public function checkLocation(DataContainer $dc) {

        $location = Input::post('location');
//        print_r($location); exit();
        if($dc->activeRecord->type == 'location' && (int) $location > 0)
        {

            //wenn Beschreibung noch leer dann neuen Werte setzen
            if( strlen($dc->activeRecord->description) < 1) {

                $objLocation = BkmLocationModel::findById($location);
                $dc->activeRecord->description = sprintf($GLOBALS['TL_LANG']['tl_bkm_hivemap']['change_location_description'], $objLocation->name);

                $set = [
                    'description' => $dc->activeRecord->description
                ];

                Database::getInstance()->prepare('UPDATE tl_bkm_hivemap %s WHERE id=?')
                    ->set($set)
                    ->execute($dc->id);
            }

            // dem zugehoerigen Bienenstock den neuen Standort zuweisen
            $this->changeLocation($dc->activeRecord->pid, $location);

            // wenn mehrere Bienenstoecke übernommen werden sollen
            $other_colonies = Input::post('other_colonies');

            if (Input::post('multi_entry') == 1 && count($other_colonies) > 0) {

                foreach ($other_colonies as $colony_id) {
                    $this->changeLocation($colony_id, $location);
                }
            }
        }
    }

    public function changeLocation($colony_id, $newLocation) {

        if((int)$colony_id > 0 && $newLocation > 0) {

            $set = ['pid'=>$newLocation];
            Database::getInstance()->prepare('UPDATE tl_bkm_colonies %s WHERE id=?')
                ->set($set)
                ->execute($colony_id);
        }

    }

    /**
     * get custom view from colonies-options
     * @param $headline
     * @return string
     */
	public function custHeadline($headline)
	{

		if($headline != '' && $this->Input->get('id'))
        {
            $resObj = BkmColoniesModel::findByIdOrAlias(Input::get('id'));

			if($resObj->numRows > 0)  $headline = sprintf($headline, $resObj->hive_number, $resObj->hive_notice);

		}
		return $headline;
	}


    /**
     * get options for item units
     * @param object
     * @return array
     */
    public function getOtherColoniesOptions(DataContainer $dc)
    {
        $varValue= array();

        //aktuelle Colonie zu Standortbestimmung
        $objCurrentColony = BkmColoniesModel::findByPk($dc->activeRecord->pid);

        //hole alle übrigen Völker zu diesem Standort
        $all = Database::getInstance()->prepare('SELECT * FROM tl_bkm_colonies WHERE id !=? AND pid=?')
            ->execute($dc->activeRecord->pid,$objCurrentColony->pid);

        while($all->next())
        {
            $objBeeHive = BkmBeehiveModel::findById($all->hive_number);
            $varValue[$all->id] = $objBeeHive->nr.' ('.$objBeeHive->notiz.')';
        }
        return $varValue;
    }

    /**
     * get options for item units
     * @param object
     * @return array
     */
    public function getGentlenessOptions(DataContainer $dc)
    {
        $varValue= array();

        $all = BkmGentlenessModel::findAll(['order'=>'sorting ASC']);

        while($all->next())
        {
            $varValue[$all->id] = $all->kurz.' ('.$all->text.')';
        }
        return $varValue;
    }

    /**
     * @param DataContainer $dc
     */
    public function setCopyEntriesInOtherColonies(DataContainer $dc)
    {
        // wenn mehrere übernommen werden sollen
        $other_colonies = Input::post('other_colonies');

        if ($dc->activeRecord && Input::post('multi_entry') == 1 && count($other_colonies) > 0) {

            foreach($other_colonies as $colony_id) {

                $set = [
                    'pid' => $colony_id,
                    'tstamp' => time(),
                    'copy_from' => $dc->id,
                    'modify' => time(),
                    'type' => $dc->activeRecord->type,
                    'date' => $dc->activeRecord->date,
                    'description' => $dc->activeRecord->description,
                    'location' => $dc->activeRecord->location,
                    'status' => $dc->activeRecord->status,
                    'frames' => $dc->activeRecord->frames,
                    'medication' => $dc->activeRecord->medication,
                    'feed' => $dc->activeRecord->feed,
                    'rating_breed' => $dc->activeRecord->rating_breed,
                    'rating_feed' => $dc->activeRecord->rating_feed,
                    'rating_gentleness' => $dc->activeRecord->rating_gentleness,
                ];

                $objIsExist = BkmHivemapModel::findOneBy(['tl_bkm_hivemap.copy_from='.$dc->id, 'tl_bkm_hivemap.pid='.$colony_id],null);

                if(is_null($objIsExist)) {
                    Database::getInstance()->prepare('INSERT INTO tl_bkm_hivemap %s')->set($set)->execute();
                } else {
                    Database::getInstance()->prepare('UPDATE tl_bkm_hivemap %s WHERE pid=? AND copy_from=?')->set($set)->execute($colony_id,$dc->id);
                }

            }
        }
    }

    public function updateTablesStatus(DataContainer $dc) {

        $objColony =BkmColoniesModel::findByPk($dc->activeRecord->pid);
        if(!is_object($objColony)) return false;

        switch($dc->activeRecord->status) {
            case 1: //erstellt
                break;
            case 2: //aufgelöst
            case 3: //tot
                //Statusmeldung als Beschreibungstext setzen
                $description = $GLOBALS['TL_LANG']['tl_bkm_hivemap']['description_status_'.$dc->activeRecord->status];
                if(strlen($dc->activeRecord->description) < 1) {
                    $hivemapSet = ['description'=>$description];
                    Database::getInstance()->prepare('UPDATE `tl_bkm_hivemap` %s WHERE id=?')
                        ->set($hivemapSet)
                        ->execute($dc->id);
                }

                //Bienenvolk auf aufgelöst/tot setzen
                $colonySet = [
                    'death' => 1
                ];
                Database::getInstance()
                ->prepare('UPDATE tl_bkm_colonies %s WHERE id = ?')
                ->set($colonySet)
                ->execute($dc->activeRecord->pid);

                //Bienenbeute auf unbenutzt setzen
                $beehiveSet = [
                    'used_from' => 0,
                    'status' => ''
                ];
                Database::getInstance()
                    ->prepare('UPDATE tl_bkm_beehive %s WHERE id = ?')
                    ->set($beehiveSet)
                    ->execute($objColony->hive_number);

                break;
        }
    }
}
