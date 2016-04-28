<?php

class PDF_Generator_PDF {
	
	protected $options;
	
	protected $template;
	
	
	public function __construct( $options ){
		
		$this->options = $options; 
		
	} // end __construct
	
	
	public function set_template( $post_id = false ){
		
		$root = dirname( dirname(__FILE__) );
		
		require_once $root . '/templates/class-pdf-template.php';
		
		$template = $this->get_template_type( $post_id );
		
		switch( $template ){
			
			case 'animal-ag':
				require_once $root . '/templates/animal-ag/class-animal-ag-pdf.php'; 
				$this->template = new Animal_Ag_PDF();
				break;
				
			case 'food-safety':
			default:
				require_once $root . '/templates/food-safety/food-safety-pdf.class.php';
				$this->template = new Food_Safety_PDF();
				break;
			
		} // end switch
		
		
	} // end set_template
	
	
	public function the_pdf( $post , $options , $dompdf ){
		
		if ( ! isset( $this->template ) ){
			
			$this->set_template();
			
		} // end if
		
		$this->template->render_pdf( $post , $options , $dompdf );
		
	} // end render_pdf
	
	
	public function get_template_type( $post_id = false ){
		
		if ( $post_id ){
		} else {
			
			$template = $this->options->get_option('_pdf_default_template');
			
			return $template;
			
		} // end if
		
	} // end get_template
	
}