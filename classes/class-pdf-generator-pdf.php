<?php

class PDF_Generator_PDF {
	
	protected $options;
	
	protected $template;
	
	
	public function __construct( $options ){
		
		$this->options = $options; 
		
	} // end __construct
	
	
	public function set_template( $post_id = false ){
		
		$root = dirname( dirname(__FILE__) );
		
		//require_once $root . '/templates/class-pdf-template.php';
		
		$template_type = $this->get_template_type( $post_id );
		
		$template = apply_filters( 'pdf_generator_template_path' , false , $template_type , $post_id );
		
		$this->template = $template;		
		
	} // end set_template
	
	
	public function the_pdf( $post , $options , $dompdf ){
		
		if ( ! isset( $this->template ) ){
			
			$this->set_template();
			
		} // end if
		
		$this->template->set_web_template( 'post' , $post );
		
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