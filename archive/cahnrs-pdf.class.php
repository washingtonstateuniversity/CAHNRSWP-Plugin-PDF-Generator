<?php

class CAHNRS_PDF {
	
	private $template;
	
	protected $settings = array();
	
	
	public function __construct( $settings = array() ){
		
		$this->settings = $settings;
		
	} // end __construct
	
	
	public function set_template( $post_id ){
		
		$root = dirname( dirname(__FILE__) );
		
		require_once $root . '/templates/pdf-template.class.php';
		
		$template = get_post_meta( $post_id , '_pdf_template' , true );
		
		if ( ! $template ){
			
			$template = get_option( '_pdf_default_template' , '' );
			
		} // end if
		
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
		
	} // end 
	
	
	public function the_pdf( $is_remote = false ){
		
		$this->template->set_template();
		
		$dompdf = new DOMPDF();
		
		$this->template->render_pdf( $dompdf );
		
	} // end the_pdf
	
	
	public function the_editor( $post ){
		
		if ( in_array( $post->post_type , $this->settings['_pdf_post_types'] ) ){
			
			$this->set_template( $post->ID );
			
			$this->template->the_editor( $post );
		
		} // end if
		
	} // end the _editor
	
	//public function 
	
}