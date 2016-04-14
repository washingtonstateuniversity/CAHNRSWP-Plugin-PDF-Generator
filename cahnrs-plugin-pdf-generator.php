<?php

/*
Plugin Name: CAHNRSWP PDF Generator
Plugin URI: http://cahnrs.wsu.edu/communications
Description: Auto Generates PDF's
Author: cahnrscommunications, Danial Bleile
Author URI: http://cahnrs.wsu.edu/communications
Version: 0.0.1
*/



class CAHNRS_PDF_Generator {
	
	private static $instance;
	
	public static function get_instance(){
		
		if ( null == self::$instance ) {
            self::$instance = new self;
			self::$instance->init();
        } // end if
 
        return self::$instance;
		
	} // end get_instance
	
	private function init(){
		
		if ( isset( $_GET['pdf'] ) ){
			
			require_once  'lib/dompdf/dompdf_config.inc.php';
			
			add_filter( 'template_include', array( $this , 'get_wp_template' ), 99 );
			
		} // end if
		
	} // end init
	
	public function get_wp_template( $template ){
		
		return dirname( __FILE__ ) . '/pdf.php';
		
	} // end get_pdf_template
	
}
$cahnrs_pdf_generator = CAHNRS_PDF_Generator::get_instance();
