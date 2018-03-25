<?php

/**
 * PHP version 5
 * @copyright  sr-tag.de 2013
 * @author     Sven Rhinow
 * @package    beekeeping
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_LANG']['tl_bkm_hivemap']['cust_headline'] = ' :: Stockkarte vom Volk %s (%s)';
/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['date'] = array('Datum', 'Datum des Eintrags.');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['description'] = array('Bemerkung', 'Bemerkung eingeben');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_breed'] = array('Brut', 'Bewertung abgeben');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_feed'] = array('Futter', 'Bewertung abgeben');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_gentleness'] = array('Sanftmut', 'Bewertung abgeben');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['frames'] = array('Waben', 'Wabenveränderungen angeben');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['medication'] = array('Mittel/Medikamente', 'Mittel/Medikamente angeben');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed'] = array('Futter-Angaben', 'Futter-Angaben angeben');

$GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign'] = array('+/-','');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['count'] = array('Anzahl','');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['frame_types'] = array('Rähmchen-Typ','');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['volume'] = array('Einheit','');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['medi_types'] = array('Mittel','');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed_types'] = array('Futter-Art','');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['status_options'] = array(1 => 'erstellt', 2 => 'aufgelöst',3 => 'tot');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['type_options'] = array
(
	'item' => 'Bemerkung', 
	'location' => 'Standort angeben',
	'status' => 'Status'
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['sign_options'] = array
(
	'+','-'
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['frametype_options'] = array
(
	'MW' => 'Mittelwand',
	'BR' => 'Baurahmen',
	'BW' => 'Brutwaabe',
	'HW' => 'Honigwaabe',
	'LW' => 'Leerwaabe',
	'WBW' => 'Wildbauwaabe'
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['meditype_options'] = array
(
	'as' => 'Ameisensäure',
	'os' => 'Oxalsäure',
	'ms' => 'Milchsäure',

);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['volumes_options'] = array
(
	'ml' => 'ml',
	'l' => 'l',
	'g' => 'g',
	'kg' => 'kg',
	'stueck' => 'Stück'
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed_options'] = array
(
	'zw' => 'Zuckerwasser',
	'ff' => 'Flüssigfutter',
	'ft' => 'Futterteig',
	'fw' => 'Futterwaaben',
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_breed_options'] = array
(
    '1' => '1',
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5'
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_feed_options'] = array
(
    '1' => '1',
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5'
);
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_gentleness_options'] = array
(
    '1' => '1',
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '5' => '5'
);

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['new']    = array('Neuer Eintrag', 'Ein neuen Eintrag anlegen.');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['edit']   = array('Editieren', 'Den Eintrag editieren');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['copy']   = array('Eintrag kopieren', 'Diesen Eintrag zum kopieren in die Zwischenablage kopieren.');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['delete'] = array('Eintrag löschen', 'Den Eintrag aus der Liste entfernen');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['show']   = array('Details', 'Die Detailansicht vom Eintrag anzeigen.');

/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['frame_legend'] = 'Waben-Angaben';
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['medication_legend'] = 'Mittel-Angaben';
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['feed_legend'] = 'Futter-Angaben';
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['rating_legend'] = 'Bewertungen';
/**
* Export as CSV
*/
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['csvExport'] = array('CSV-Export', 'Stockkarte als CSV exportieren.');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['exportCSV'] = array('starte Export', '');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['exportYear'] = array('exportiere folgendes Jahr','alle Bemerkungen innerhalb dieses Jahres werden in eine CSV exportiert.');

/**
* Export as PDF
*/
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['pdfExport'] = array('PDF-Datei', 'Einträge zu diesem Volk als PDF exportieren');
$GLOBALS['TL_LANG']['tl_bkm_hivemap']['exportPDF'] = array('generiere PDF-Datei', '');
