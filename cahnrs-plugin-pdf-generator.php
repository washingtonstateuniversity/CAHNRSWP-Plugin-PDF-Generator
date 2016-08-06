<?php

/*
Plugin Name: CAHNRSWP PDF Converter
Plugin URI: http://cahnrs.wsu.edu/communications
Description: Auto Generates PDF's
Author: cahnrscommunications, Danial Bleile
Author URI: http://cahnrs.wsu.edu/communications
Version: 2.0.0
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
	
		if ( ! empty( $_GET['pdf'] ) || ! empty( $_GET['pdf-id'] ) ){
			
			require_once 'classes/class-cahnrs-pdf.php';
			
			$pdf = new CAHNRS_PDF();
			
			add_filter( 'template_include', array( $pdf , 'get_template' ), 99 );
			
		} // end if
		
	} // end init
	
} // end CAHNRS_PDF_Generator

$cahnrs_pdf_generator = CAHNRS_PDF_Generator::get_instance();
