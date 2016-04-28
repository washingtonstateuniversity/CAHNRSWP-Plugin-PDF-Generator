<?php

require_once 'classes/class-pdf-generator-pdf.php';

require_once 'classes/class-pdf-generator-options.php';

require_once  'lib/dompdf/dompdf_config.inc.php';

global $post;

$options = new PDF_Generator_Options();

$dompdf = new dompdf();

$pdf = new PDF_Generator_PDF( $options );

$pdf->the_pdf( $post , $options , $dompdf );

/*class CAHNRS_PDF_Page {

	public function __construct(){
		
		require_once 'classes/cahnrs-pdf.class.php';

		require_once 'classes/cahnrs-local-pdf.class.php';
		
		$this->do_pdf();
		
	} // end __construct
	
	private function do_pdf(){
		
		$pdf = new CAHNRS_PDF();

		global $post;

		$pdf->set_template( $post->ID );

		$pdf->the_pdf();
		
	} // end do_pdf
	

}

$cahnrs_pdf_page = new CAHNRS_PDF_Page();*/