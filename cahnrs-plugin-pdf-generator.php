<?php

/*
Plugin Name: CAHNRSWP PDF Generator
Plugin URI: http://cahnrs.wsu.edu/communications
Description: Auto Generates PDF's
Author: cahnrscommunications, Danial Bleile
Author URI: http://cahnrs.wsu.edu/communications
Version: 1.0.0
*/
class CAHNRS_PDF_Generator {
	
	private static $instance;
	
	protected $options;
	
	//public $settings = array();
	
	//public $pdf;
	
	
	public static function get_instance(){
		
		if ( null == self::$instance ) {
            self::$instance = new self;
			self::$instance->init();
        } // end if
 
        return self::$instance;
		
	} // end get_instance
	
	private function init(){
		
		if ( isset( $_GET['pdf'] ) ){
		
			add_filter( 'single_template', array( $this , 'the_pdf_template' ), 99 );
			
		} // end if
		
		require_once 'classes/class-pdf-generator-options.php';
		
		$this->options = new PDF_Generator_Options();
		
		$this->options->init();
		
		//require_once 'classes/class-pdf-generator-pdf.php';
		
		//$pdf = new PDF_Generator_PDF( $options );
		
		//$pdf->init();
		
		
		
		//require_once 'classes/class-pdf-generator-sanitize.php';
		
		//$sanitize = new PDF_Generator_Sanitize();
			
		//require_once 'classes/class-pdf-generator-admin.php';
			
		//$admin = new PDF_Generator_Admin( $sanitize );
		
		//$this->settings = $admin->get_settings();
		
		//require_once 'classes/cahnrs-pdf.class.php';
		
		//$this->pdf = new CAHNRS_Pdf( $this->settings );
			
		//if ( is_admin() ){
			
			//$admin->the_options();
			
		//} // end if
		
		//if ( isset( $_GET['pdf'] ) ){
			
			//require_once  'lib/dompdf/dompdf_config.inc.php';
			
			//add_filter( 'single_template', array( $this , 'get_wp_template' ), 99 );
			
		//} // end if
		
	} // end init
	
	
	public function the_pdf_template( $template ){
		
		global $post;
		
		$options = $this->options->get_options();
		
		if ( isset( $options['_pdf_post_types'] ) && is_array( $options['_pdf_post_types'] ) && in_array( $post->post_type , $options['_pdf_post_types']  ) ){
		
			return dirname( __FILE__ ) . '/pdf.php';
			
		} // end if
		
		return $template;
		
	}
	
	
	//public function get_wp_template( $template ){
		
		//global $post;
		
		//if ( in_array( $post->post_type , $this->settings['_pdf_post_types'] ) ){
		
			//return dirname( __FILE__ ) . '/pdf.php';
			
		//} // end if
		
		//return $template;
		
	//} // end get_pdf_template
	
} // end CAHNRS_PDF_Generator

$cahnrs_pdf_generator = CAHNRS_PDF_Generator::get_instance();
