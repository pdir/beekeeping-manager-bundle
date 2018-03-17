<?php

/**
 * PHP version 5
 * @copyright  sr-tag.de 2013
 * @author     Sven Rhinow
 * @package    beekeeping
 * @license    LGPL
 */

/**
 * Class iao_invoice
 */
class beBeekeepingExport extends Backend
{
	/**
	 * Export bookings for statistics
	 */
	public function csvExport()
	{

		if ($this->Input->post('FORM_SUBMIT') == 'export_bookings')
		{
			$this->import('Database');

			$id =  $this->Input->post('pid');

			//Check the reference-id
			if($id < 1)
			{
				$_SESSION['TL_ERROR'][] = 'keine ID als Daten-Referenz angegeben';
				$this->reload();
			}

			//set handle from file
			$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>"\t",'linebreak'=>"\n");
			$fieldnames = array('date'=>'Datum','description'=>'Bemerkung');

			// get records
			$arrExport = array();
            if($this->Input->post('exportYear'))
            {
				$resObj = $this->Database->prepare('SELECT `h`.*,`c`.`hive_number` FROM `tl_bk_hivemap` `h` LEFT JOIN `tl_bk_colonies` `c` ON `h`.`pid` = `c`.`id`
				WHERE `c`.`id` = ? AND (FROM_UNIXTIME(`h`.`date`,"%Y") = ? || FROM_UNIXTIME(`h`.`date`,"%Y") = ?)
				ORDER BY `h`.`date` ASC')
				->execute($id, $this->Input->post('exportYear'), $this->Input->post('exportYear'));
            } else {
				$resObj = $this->Database->prepare('SELECT `h`.*,`c`.`hive_number` FROM `tl_bk_hivemap` `h` LEFT JOIN `tl_bk_colonies` `c` ON `h`.`pid` = `c`.`id`
				WHERE `c`.`id` = ?
				ORDER BY `h`.`date` ASC')
				->execute($id, $this->Input->post('exportYear'), $this->Input->post('exportYear'));
            }
			//Check the reference-id
			if($resObj->numRows < 1)
			{
				$_SESSION['TL_ERROR'][] = 'keine Daten zum exportieren vorhanden';
				$this->reload();
			}
			$arrExport = $resObj->fetchAllAssoc();

			// start output
			$exportFile =  'Stockkarte_Volk_'.$resObj->hive_number.'_' . $this->Input->post('exportYear');
			$output = '';
		    $output = '"' . implode('"'.$seperators[$this->Input->post('separator')].'"', array_values($fieldnames)).'"' . "\n";

		    foreach ($arrExport as $export)
		    {
				$row = array
				(
					'date' => date($GLOBALS['TL_CONFIG']['dateFormat'], $export['date']),
					'description' => html_entity_decode($export['description']),
				);

				$output .= '"' . implode('"'.$seperators[$this->Input->post('separator')].'"', str_replace("\"", "\"\"", $row)).'"' . "\n";
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

		// Return the form
		return '
		    <div id="tl_buttons">
		    <a href="'.ampersand(str_replace('&key=csvExport', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
		    </div>

		    <h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_bk_hivemap']['csvExport'][1].'</h2>'.$this->getMessages().'

		    <form action="'.ampersand($this->Environment->request, true).'" id="tl_bbk_csvexport" class="tl_form" method="post">
		    <div class="tl_formbody_edit">
			<input type="hidden" name="FORM_SUBMIT" value="export_bookings" />
			<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'" />
			<input type="hidden" name="pid" value="'.$this->Input->get('id').'" />
			<fieldset class="tl_tbox block">
			    <div class="w50">
			    <h3><label for="ctrl_bbk">'.$GLOBALS['TL_LANG']['tl_bk_hivemap']['exportYear'][0].'</label></h3>
			    <select name="exportYear" id="exportYear" class="tl_select" onfocus="Backend.getScrollOffset();">
			    <option value=""> -- Alle -- </option>
				<option value="'.date('Y').'">'.date('Y').'</option>
				<option value="'.date('Y',strtotime('-1 year')).'">'.date('Y',strtotime('-1 year')).'</option>
				<option value="'.date('Y',strtotime('-2 years')).'">'.date('Y',strtotime('-2 years')).'</option>
			    </select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_bk_hivemap']['exportYear'][1].'</p>' : '').'
			    </div>
			    <div class="w50">
			    <h3><label for="ctrl_bbk">CSV-Trenner</label></h3>
			    <select name="separator" id="separator" class="tl_select" onfocus="Backend.getScrollOffset();">
				<option value="semicolon">'.$GLOBALS['TL_LANG']['MSC']['semicolon'].' (;)</option>
				<option value="comma">'.$GLOBALS['TL_LANG']['MSC']['comma'].' (,)</option>
				<option value="tabulator">'.$GLOBALS['TL_LANG']['MSC']['tabulator'].'</option>
				<option value="linebreak">'.$GLOBALS['TL_LANG']['MSC']['linebreak'].'</option>
			    </select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['MSC']['separator'][1].'</p>' : '').'
			    </div>
			</fieldset>
		    </div>

		    <div class="tl_formbody_submit">

		    <div class="tl_submit_container">
		      <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_bk_hivemap']['exportCSV'][0]).'" />
		    </div>

		    </div>
		    </form>';
	}

	/**
	 * generate runlist
	 */
	public function pdfExport()
	{
		if ($this->Input->post('FORM_SUBMIT') == 'generate_runlist')
		{
		    $this->import('Database');

			$pid =  $this->Input->post('pid');

			//Check the reference-id
		    if($pid < 1)
		    {
				$_SESSION['TL_ERROR'][] = 'keine ID als Daten-Referenz angegeben';
				$this->reload();
		    }
            if($this->Input->post('exportYear'))
            {
				$resultObj = $this->Database->prepare('SELECT `h`.*
				FROM `tl_bk_hivemap` `h`
				WHERE `h`.`pid` = ?
				AND (FROM_UNIXTIME(`h`.`date`,"%Y") = ? || FROM_UNIXTIME(`h`.`date`,"%Y") = ?)
				ORDER BY `h`.`date` ASC')
						 ->execute($pid, $this->Input->post('exportYear'), $this->Input->post('exportYear'));
            } else {
				$resultObj = $this->Database->prepare('SELECT `h`.*
				FROM `tl_bk_hivemap` `h`
				WHERE `h`.`pid` = ?
				ORDER BY `h`.`date` ASC')
						 ->execute($pid);
            }
            // get all Colony-Data
			$colonyObj = $this->Database->prepare('SELECT `c1`.*
			, `c2`.`hive_number` as `nativity_hive_number`
			, `c2`.`hive_notice` as `nativity_hive_notice`
			, `c2`.`death` as `nativity_death`
			FROM `tl_bk_colonies` `c1` LEFT JOIN `tl_bk_colonies` `c2` ON `c1`.`nativity_id` = `c2`.`id`
			WHERE `c1`.`id` = ?')
                            ->limit(1)
							->execute($pid);


			//Check count of results
		    if($resultObj->numRows < 1)
		    {
				$_SESSION['TL_ERROR'][] = 'keine Daten zum exportieren vorhanden';
				$this->reload();
			}

			$arrExport = $resultObj->fetchAllAssoc();

			// start output
			$fileName		=  'Stockkarte_Volk'.$colonyObj->hive_number.'_' . ($this->Input->post('exportYear') ? $this->Input->post('exportYear') : 'alles').'_'.date('Y.m.d');
			$pdfTemplate	= 'pdf_hivemap';
			$pdfDataArr		= array();

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

			// parse html for pdf
			$objPartial = new FrontendTemplate($pdfTemplate);
			$objPartial->fieldData = $pdfDataArr;
			$objPartial->exportYear =  $this->Input->post('exportYear');
			$objPartial->colony = $colonyObj;
			$generatedHtml = $objPartial->parse();

		    $pdfFile = new File('system/modules/beekeeping/html/css/pdf.css');
		    $cssText = $pdfFile->getContent();
		    $cssText = '<style>'.$cssText.'</style>';

//             print $cssText.$generatedHtml;
//             exit();

		    ob_end_clean();
		    $this->createPdf($cssText.$generatedHtml,$fileName);


		}

    	$beginnDate = ($this->Input->post('beginnDate')) ? $this->Input->post('beginnDate') : date($GLOBALS['TL_CONFIG']['dateFormat'],strtotime('+14 days'));
    	$endDate = ($this->Input->post('endDate')) ? $this->Input->post('endDate') :date($GLOBALS['TL_CONFIG']['dateFormat'],strtotime('+21 days'));

    	// Return the form
		return '
		    <div id="tl_buttons">
		    <a href="'.ampersand(str_replace('&key=pdfExport', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
		    </div>

		    <h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_bk_hivemap']['pdfExport'][1].'</h2>'.$this->getMessages().'

		    <form action="'.ampersand($this->Environment->request, true).'" id="tl_bbk_csvexport" class="tl_form" method="post">
		    <div class="tl_formbody_edit">
			<input type="hidden" name="FORM_SUBMIT" value="generate_runlist" />
			<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'" />
			<input type="hidden" name="pid" value="'.$this->Input->get('id').'" />
			<fieldset class="tl_tbox block">
			    <div>
			    <div class="w50">
			    <h3><label for="ctrl_bbk">'.$GLOBALS['TL_LANG']['tl_bk_hivemap']['exportYear'][0].'</label></h3>
			    <select name="exportYear" id="exportYear" class="tl_select" onfocus="Backend.getScrollOffset();">
			    <option value=""> -- Alle -- </option>
				<option value="'.date('Y').'">'.date('Y').'</option>
				<option value="'.date('Y',strtotime('-1 year')).'">'.date('Y',strtotime('-1 year')).'</option>
				<option value="'.date('Y',strtotime('-2 years')).'">'.date('Y',strtotime('-2 years')).'</option>
			    </select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_bk_hivemap']['exportYear'][1].'</p>' : '').'
			    </div>
			</fieldset>
		    </div>

		    <div class="tl_formbody_submit">

		    <div class="tl_submit_container">
		      <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_bk_hivemap']['exportPDF'][0]).'" />
		    </div>

		    </div>
		    </form>';
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
		if(version_compare(VERSION.BUILD, '3.0.0','>='))
		{
			require_once TL_ROOT . '/system/config/tcpdf.php';
			require_once TL_ROOT . '/system/modules/core/vendor/tcpdf/tcpdf.php';
		}else{
			require_once(TL_ROOT . '/system/config/tcpdf.php');
			require_once(TL_ROOT . '/plugins/tcpdf/tcpdf.php');
		}
		// Create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

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
