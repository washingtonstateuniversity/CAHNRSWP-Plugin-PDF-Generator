<?php

abstract class PDF_Template {
	
	protected $html;
	
	protected $title;
	
	protected $summary;
	
	protected $pdf_html;
	
	protected $settings = array();
	
	protected $fields = array();
	
	
	public function get_html(){ return $this->html;}
	
	
	public function get_pdf_html(){ return $this->html;}
	
	
	public function get_title(){ return $this->title;}
	
	
	public function get_fields(){ return $this->fields;}
	
	
	public function get_settings( $post_id = false , $reload = false ){
		
		if ( ! empty( $this->settings ) && ! $reload ){
			
			return $this->settings;
			
		} else {
			
			$this->set_settings( $post_id );
			
			return $this->settings;
			
		} // end if
		
	} // end get_settings
	
	
	public function get_document_title(){
		
		return '<title>' . $this->get_title() . '</title>';
		
	} // end get_document_title 
	
	
	public function get_style(){
		
		$style .= '<style>' . file_get_contents( dirname(__FILE__) . '/style.css') . '</style>';
		
		return $style;
		
	} // end get_style
	
	
	public function get_footer(){ return ''; }
	
	
	public function set_settings( $post_id ){
		
		foreach( $this->get_fields() as $key => $field ){
			
			$meta = get_post_meta( $post_id , $key , true );
			
			if ( $meta ) {
				
				$this->settings[ $key ] = $meta;
				
			} else {
				
				$this->settings[ $key ] = $field[0];
				
			} // end if
			
		} // end foreach
		
	} // end set_settings
	
	public function set_template_post( $post ){
		
		$this->set_post_html( $post );
		
		$this->set_post_title( $post );
		
	} // end set_template_post
	
	
	public function set_post_html( $post ){
		
		$this->html = apply_filters( 'the_content' , $post->post_content );
		
	} // end set_post_title
	
	
	public function set_post_title( $post ){
		
		$this->title = $post->post_title;
		
	} // end set_post_title
	
	
	public function get_pdf_document( $post , $options ){
		
		$this->set_template_post( $post );
		
		$settings = $this->get_settings( $post->ID );
		
		$html = '<!doctype html><html><head><meta charset="utf-8">';
		
		$html .= $this->get_document_title();
		
		$html .= $this->get_style();
		
		$html .= '</head><body>';
		
		$html .= $this->get_pdf_html( $settings );
		
		$html .= $this->get_footer();
		
		$html .= '</body></html>';
		
		return $html;
		
	} // end set_pdf_html
	
	
	public function render_pdf( $post , $options , $dompdf ){
		
		define( 'DOINGPDF' , true );
		
		$dompdf->load_html( $this->get_pdf_document( $post , $options ) );
	
		$dompdf->render();
	
		$dompdf->stream("publication.pdf", array("Attachment" => 0));
		
	} // end get_pdf_html
	
}