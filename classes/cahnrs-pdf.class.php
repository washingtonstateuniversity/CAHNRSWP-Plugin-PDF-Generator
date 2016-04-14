<?php

class CAHNRS_PDF {
	
	private $template;
	
	
	public function get_template(){
	}
	
	public function set_template( $template ){
		
		$root = dirname( dirname(__FILE__) );
		
		require_once $root . '/templates/pdf-template.class.php';
		
		switch( $template ){
			
			case 'food-safety':
			default:
				require_once $root . '/templates/food-safety/food-safety-pdf.class.php';
				$this->template = new Food_Safety_PDF();
				break;
			
		} // end switch
		
	} // end 
	
	
	public function the_pdf( $is_remote = false ){
		
		$this->template->set_template();
		
		$dompdf = new DOMPDF();
		
		$this->template->render_pdf( $dompdf );
		
	} // end the_pdf
	
	//public function 
	
}