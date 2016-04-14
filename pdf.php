<?php

class CAHNRS_PDF_Page {

	public function __construct(){
		
		require_once 'classes/cahnrs-pdf.class.php';

		require_once 'classes/cahnrs-local-pdf.class.php';
		
		$this->do_pdf();
		
	} // end __construct
	
	private function do_pdf(){
		
		$pdf = new CAHNRS_PDF();

		global $post;

		$pdf->set_template( get_post_meta( $post->ID , '_pdf_template' , true ) );

		$pdf->the_pdf();
		
	} // end do_pdf
	

}

$cahnrs_pdf_page = new CAHNRS_PDF_Page();