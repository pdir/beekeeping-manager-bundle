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
*Table tl_bkm_colonies
*/
use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_bkm_colonies'] = array
(
	//Config
	'config' => array
	(
		'dataContainer' => 'Table',
        'ptable'                      => 'tl_bkm_location',
		'ctable'                      => array('tl_bkm_hivemap'),
		'enableVersioning'            => true,
        'onsubmit_callback' => array
        (
            array('Bkm\Dca\Colonies', 'setBeehiveStatus')
        ),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
                'pid' => 'index'
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('date DESC', 'hive_number'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('hive_number', 'queen_color','death'),
			'format'                  => '<span style="font-weight: bold;">%s (%s)</span>, aufgelöst: %s',
 			'label_callback'          => array('Bkm\Dca\Colonies', 'listEntries')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['hivemap'],
				'href'                => 'table=tl_bkm_hivemap',
				'icon'                => BKM_PUBLIC_FOLDER.'/icons/table_18.png',
				'button_callback'     => array('Bkm\Dca\Colonies', 'hivemapLink')
			),
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		// '__selector__'                => array(''),
		'default'                     => 'date,pid;{hive_legend},hive_number,hive_notice;{breed_legend},breed,breed_notice,queen_color,nativity_id,nativity;{additional_legend},notice,death'
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
        'pid' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['pid'],
            'foreignKey'              => 'tl_bkm_location.name',
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 11,
            'inputType'               => 'select',
            'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'main_site' => array
        (
            'sql'                     => "varchar(32) NOT NULL default ''"
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['date'],
			'inputType'               => 'text',
			'default'                 => time(),
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array('mandatory'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'wizard w50', 'minlength' => 1, 'maxlength'=>10, 'rgxp' => 'date'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'hive_number' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['hive_number'],
//			'foreignKey'              => 'tl_bk_bkm_bee_prey.nr',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
            'options_callback'        => array('Bkm\Dca\Colonies', 'getHiveOptions'),
			'eval'                    => array('mandatory'=>false, 'chosen'=>true, 'includeBlankOption'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
		),
		'hive_notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['hive_notice'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'breed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['breed'],
			'foreignKey'              => 'tl_bkm_bee_breed.name',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50', 'includeBlankOption'=>false,'submitOnChange'=>true),
			'sql'                     => "varchar(32) NOT NULL default ''",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'breed_notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['breed'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'nativity_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['nativity_id'],
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('Bkm\Dca\Colonies', 'getNativityOptions'),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'nativity' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['nativity'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'clr long'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
        'queen_color' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['queen_color'],
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 11,
            'inputType'               => 'select',
            'options'                 => $GLOBALS['TL_LANG']['tl_bkm_colonies']['queen_color_options'],
            'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(25) NOT NULL default ''"
        ),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['notice'],
			'exclude'                 => true,
			'search'				  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'                     => "text NULL"
		),
		'death' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_bkm_colonies']['death'],
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
 * Class Bkm\Dca\Colonies
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class Colonies extends Backend
{
    /**
     * List a particular record
     * @param array
     * @return string
     */
    public function listEntries($arrRow)
    {
        $objHive = Database::getInstance()->prepare("SELECT * FROM `tl_bkm_beehive` WHERE id=?")
            ->limit(1)
            ->execute($arrRow['hive_number']);

        $arrHive = $objHive->fetchAssoc();

        $besetzt = ($arrRow['death'])?'ja':'nein';

        return $arrHive['nr'].' ('.$GLOBALS['TL_LANG']['tl_bkm_colonies']['queen_color_options'][$arrRow['queen_color']].'), aufgelöst: '.$besetzt;
    }
    /**
     * Return the edit Hive button
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     * @return string
     */
	public function hivemapLink($row, $href, $label, $title, $icon, $attributes)
	{
	    return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

    /**
     * get all unused beehives
     * @param $dc
     * @return array
     */
    public function getHiveOptions(\DataContainer $dc)
    {
        $varValue= array();

            $objHive = Database::getInstance()->prepare('SELECT * FROM `tl_bkm_beehive` WHERE status = ? OR used_from= ? ORDER BY `sorting` ASC')
                ->execute(0 , $dc->id);


        while($objHive->next())
        {
            $varValue[$objHive->id] = $objHive->nr.' ('.$objHive->notiz.')';
        }

        return $varValue;
    }

    /**
     * holt sich alle Beinenstöcke ohne sich selbst und die die aufgelösst wurden als Abstammung-Optionen
     * @param \DataContainer $dc
     * @return array
     */
	public function getNativityOptions(DataContainer $dc)
	{
		$varValue= array();

		$all = Database::getInstance()->prepare('SELECT * FROM `tl_bkm_colonies` WHERE `id` !=? AND death != 1 ORDER BY `hive_number` ASC')
				  ->execute($dc->id);

		while($all->next())
		{
			$varValue[$all->id] = $all->hive_number.' ('.$all->hive_notice.')';
		}
		return $varValue;
	}

    /**
     * @param \DataContainer $dc
     */
	public function setBeehiveStatus(DataContainer $dc)
    {

        //alle alten Einträge in Bienenstock zurücksetzen
        Database::getInstance()->prepare('UPDATE tl_bkm_beehive SET used_from = ? WHERE used_from = ?')->execute(0,$dc->id);

        if($dc->activeRecord->death > 0) {
            $set['used_from'] = 0;
            $set['status'] = '';
        } else {
            $set['used_from'] = $dc->id;
            $set['status'] = 1;
        }
        // neuen Eintrag in Bienenstock setzen
        Database::getInstance()->prepare('UPDATE tl_bkm_beehive %s WHERE id = ?')->set($set)->execute($dc->activeRecord->hive_number);

        // falls tot die Bienenstock-Zuweisung löschen
        if($dc->activeRecord->death > 0) Database::getInstance()->prepare('UPDATE tl_bkm_colonies SET hive_number = ? WHERE id = ?')->execute(0,$dc->id);
    }
}
