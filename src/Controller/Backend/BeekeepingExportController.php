<?php

namespace Srhinow\BeekeepingManagerBundle\Controller\Backend;

/**
 * PHP version 5
 * @copyright  sr-tag.de 2013
 * @author     Sven Rhinow
 * @package    beekeeping
 * @license    LGPL
 */

use Contao\Backend;
use Contao\BackendTemplate;
use Contao\CoreBundle\Controller\BackendController;
use Contao\Database;
use Contao\DataContainer;
use Contao\File;
use Contao\FileTree;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\Message;
use Contao\System;
use Srhinow\BkmBeeBreedModel;
use Srhinow\BkmColoniesModel;
use Srhinow\BkmLocationModel;

/**
 * Class iao_invoice
 */
class BeekeepingExportController extends Backend
{
   protected $csv_separators = array('comma'=>',','semicolon'=>';','tabulator'=>"\t",'linebreak'=>"\n");

   protected $csv_fields = array('date'=>'Datum','description'=>'Bemerkung');

    /**
     * Load the database object
     */
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Export bookings for statistics
	 */
	public function csvExport()
	{
        System::loadLanguageFile('tl_bkm_hivemap');
        $formId = 'bkm_export_csv';

		if (Input::post('FORM_SUBMIT') == $formId)
		{
			$db = Database::getInstance();
			$id =  Input::get('id');

			//Check the reference-id
			if($id < 1)
			{
                Message::addError('keine ID als Daten-Referenz angegeben');
				$this->reload();
			}

			//set handle from file
			$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>"\t",'linebreak'=>"\n");
			$fieldnames = array('date'=>'Datum','description'=>'Bemerkung');

			// get records
			$arrExport = array();
            if(Input::post('exportYear'))
            {
				$resObj = $db->prepare('SELECT `h`.*,`c`.`hive_number` FROM `tl_bkm_hivemap` `h` LEFT JOIN `tl_bkm_colonies` `c` ON `h`.`pid` = `c`.`id`
				WHERE `c`.`id` = ? AND (FROM_UNIXTIME(`h`.`date`,"%Y") = ? || FROM_UNIXTIME(`h`.`date`,"%Y") = ?)
				ORDER BY `h`.`date` ASC')
				->execute($id, Input::post('exportYear'), Input::post('exportYear'));
            } else {
				$resObj = $this->Database->prepare('SELECT `h`.*,`c`.`hive_number` FROM `tl_bkm_hivemap` `h` LEFT JOIN `tl_bkm_colonies` `c` ON `h`.`pid` = `c`.`id`
				WHERE `c`.`id` = ?
				ORDER BY `h`.`date` ASC')
				->execute($id, Input::post('exportYear'), Input::post('exportYear'));
            }

			//Check the reference-id
			if($resObj->numRows < 1)
			{
                Message::addError('keine Daten zum exportieren vorhanden');
				$this->reload();
			}
			$arrExport = $resObj->fetchAllAssoc();

			// start output
			$exportFile =  'Stockkarte_Volk_'.$resObj->hive_number.'_' . Input::post('exportYear');
			$output = '';
		    $output = '"' . implode('"'.$this->csv_separators[Input::post('separator')].'"', array_values($this->csv_fields)).'"' . "\n";

		    foreach ($arrExport as $export)
		    {
				$row = array
				(
					'date' => date($GLOBALS['TL_CONFIG']['dateFormat'], $export['date']),
					'description' => html_entity_decode($export['description']),
				);

				$output .= '"' . implode('"'.$this->csv_separators[Input::post('separator')].'"', str_replace("\"", "\"\"", $row)).'"' . "\n";
			}

			ob_end_clean();
			header('Content-Type: application/csv');
			header('Content-Transfer-Encoding: binary');
			header('Content-Disposition: attachment; filename="' . $exportFile .'.csv"');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Expires: 0');
			echo $output;
			exit();

		}

        $Template = new BackendTemplate('be_bkm_export_csv');
        $Template->headline = $GLOBALS['TL_LANG']['tl_bkm_hivemap']['csvExport'][1];
        $Template->backlink = ampersand(str_replace('&key=csvExport', '', $this->Environment->request));
        $Template->message = Message::generate();
        $Template->lang_array = $GLOBALS['TL_LANG']['tl_bkm_hivemap'];
        $Template->csv_seperators = $this->getCSVSeparators();
        $Template->export_years = $this->getExportYear(5);
        $Template->formId = $formId;

        // Return the form
        return $Template->parse();
	}

	public function getCSVSeparators(){
	    $arrSeperatorOptions = [];

	    foreach($this->csv_separators as $k => $v){
            $arrSeperatorOptions[$k] = $GLOBALS['TL_LANG']['MSC'][$k];
        }

        return $arrSeperatorOptions;
    }

    public function getExportYear($past = 0,$future = 0) {
        $arrYears[''] = '-- Alle --';
	    if($past > 0) {

	        for($i=1; $i <= $past; $i++){
                $year = date('Y',strtotime('-'.$i.' year'));
                $arrYears[$year] = $year;
            }
        }
        $arrYears[date('Y')] = date('Y');

        if($future > 0) {
            for($i=1; $i <= $future; $i++){
                $year = date('Y',strtotime($i.' year'));
                $arrYears[$year] = $year;
            }
        }
        asort($arrYears,SORT_REGULAR);

        return $arrYears;
    }

	/**
	 * generate Hivemap-PDF
	 */
	public function pdfExport()
	{
        System::loadLanguageFile('tl_bkm_hivemap');
        $formId = 'bkm_generate_pdf';

		if (Input::post('FORM_SUBMIT') == $formId)
		{
		    $db = Database::getInstance();
			$id =  Input::get('id');
            $pdfTemplate	= 'pdf_hivemap';
            $pdfDataArr		= array();

			//Check the reference-id
		    if($id < 1)
		    {
                Message::addError('keine ID als Daten-Referenz angegeben');
				$this->reload();
		    }

            if(Input::post('exportYear'))
            {
				$resultObj = $db->prepare('SELECT `h`.*
				FROM `tl_bkm_hivemap` `h`
				WHERE `h`.`pid` = ?
				AND (FROM_UNIXTIME(`h`.`date`,"%Y") = ? || FROM_UNIXTIME(`h`.`date`,"%Y") = ?)
				ORDER BY `h`.`date` ASC')
						 ->execute($id, Input::post('exportYear'), Input::post('exportYear'));
            } else {
				$resultObj = $db->prepare('SELECT `h`.*
				FROM `tl_bkm_hivemap` `h`
				WHERE `h`.`pid` = ?
				ORDER BY `h`.`date` ASC')
						 ->execute($id);
            }

            //Check count of results
            if($resultObj->numRows < 1)
            {
                Message::addError('keine Daten zum exportieren vorhanden');
                $this->reload();
            }
            $arrExport = $resultObj->fetchAllAssoc();

            // parse html for pdf
            $objPartial = new FrontendTemplate($pdfTemplate);
            $objPartial->exportYear =  Input::post('exportYear');

            // get all Colony-Data
            $objColony =  BkmColoniesModel::findByPk($id);

            if(null === $objColony)
            {
                Message::addError('Es konnte keinn Volk zugeordnet werden.');
                $this->reload();
            }
            $objPartial->colony = $objColony;

            //Bienenrasse als String holen
            $objBreed = BkmBeeBreedModel::findByPk($objColony->breed);

            if(null === $objBreed)
            {
                Message::addError('Es konnte keiner Binenerasse zugeordnet werden.');
                $this->reload();
            }
            $objPartial->breed = $objBreed;

            //Abstammung
            if($objColony->nativity_id > 0) {
                // get all Colony-Data
                $objNativityColony =  BkmColoniesModel::findByPk($objColony->nativity_id);

                if(null === $objNativityColony)
                {
                    Message::addError('Es konnte trotz zuweisung kein Eltern-Volk ermittelt werden.');
                    $this->reload();
                }
                $objPartial->nativ_colony = $objNativityColony;
            }

            //Standort als String holen
            $objLocation = BkmLocationModel::findByPk($objColony->pid);

            if(null === $objLocation)
            {
                Message::addError('Es konnte keinem Standort zugeordnet werden.');
                $this->reload();
            }
            $objPartial->location = $objLocation;



			// start output
			$fileName		=  'Stockkarte_Volk'.$objColony->hive_number.'_' . (Input::post('exportYear') ? Input::post('exportYear') : 'alles').'_'.date('Y.m.d');


			foreach ($arrExport as $export)
			{
				$monthStr	= $GLOBALS['TL_LANG']['MONTHS'][ date('n', $export['date'])-1 ];
				$yearStr	= date('Y',$export['date']);
				$headlineStr= $monthStr.' '.$yearStr;

				$pdfDataArr[$headlineStr][] = array
				(
					'date' => date($GLOBALS['TL_CONFIG']['dateFormat'], $export['date']),
					'description' => $export['description']
				);
			}

            //generate HTML from template for PDF
            $objPartial->fieldData = $pdfDataArr;
			$generatedHtml = $objPartial->parse();


            $pdfFile = new File(BKM_PATH.'/src/Resources/public/css/pdf.css');
            $cssText = $pdfFile->getContent();
            $cssText = '<style>' . $cssText . '</style>';

		    ob_end_clean();
		    $this->createPdf($cssText.$generatedHtml,$fileName);


		}

    	$beginnDate = (Input::post('beginnDate')) ? Input::post('beginnDate') : date($GLOBALS['TL_CONFIG']['dateFormat'],strtotime('+14 days'));
    	$endDate = (Input::post('endDate')) ? Input::post('endDate') :date($GLOBALS['TL_CONFIG']['dateFormat'],strtotime('+21 days'));


        $Template = new BackendTemplate('be_bkm_export_pdf');
        $Template->headline = $GLOBALS['TL_LANG']['tl_bkm_hivemap']['pdfExport'][1];
        $Template->backlink = ampersand(str_replace('&key=pdfExport', '', $this->Environment->request));
        $Template->message = Message::generate();
        $Template->lang_array = $GLOBALS['TL_LANG']['tl_bkm_hivemap'];
        $Template->export_years = $this->getExportYear(5);
        $Template->formId = $formId;

        // Return the form
        return $Template->parse();
	}

	/**
	 * Print an article as PDF and stream it to the browser
	 * @param Database_Result
	 */
	protected function createPdf($strContent = '',$fileName='')
	{
		// TCPDF configuration
		$l['a_meta_dir'] = 'ltr';
		$l['a_meta_charset'] = $GLOBALS['TL_CONFIG']['characterSet'];
		$l['a_meta_language'] = $GLOBALS['TL_LANGUAGE'];
		$l['w_page'] = 'page';

		// Include library
		require_once TL_ROOT . '/system/config/tcpdf.php';

		// Create new PDF document
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

		if(!$fileName) $fileName = date('Ymdhis').'-Stockkarte';

		// Set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(PDF_AUTHOR);
		$pdf->SetTitle($fileName);
		$pdf->SetSubject($fileName);
		$pdf->SetKeywords($fileName);

		// Prevent font subsetting (huge speed improvement)
		$pdf->setFontSubsetting(false);

		// Remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// Set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

		// Set auto page breaks
		$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

		// Set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// Set some language-dependent strings
		$pdf->setLanguageArray($l);

		// Initialize document and add a page
		$pdf->AddPage();

		// Set font
		$pdf->SetFont(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN);

		// Write the HTML content
		$pdf->writeHTML($strContent, true, 0, true, 0);

		// Close and output PDF document
		$pdf->lastPage();
		$pdf->Output(standardize(ampersand($fileName, false)) . '.pdf', 'D');

		// Stop script execution
		exit;
	}
}
