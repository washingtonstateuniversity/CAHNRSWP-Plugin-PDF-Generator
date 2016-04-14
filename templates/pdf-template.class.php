<?php

abstract class PDF_Template {
	
	protected $html;
	
	protected $title;
	
	protected $summary;
	
	protected $pdf_html;
	
	public function get_html(){ return $this->html;}
	public function get_pdf_html(){ return $this->html;}
	public function get_title(){ return $this->title;}
	
	
	public function set_template( $source = false ){
		
		switch( $source ){
			
			default:
				$this->set_template_post();
				break;
		} // end switch
		
	} // end set_template
	
	public function set_template_post( $post = false){
		
		if ( ! $post ) global $post;
		
		$html = apply_filters( 'the_content' , $post->post_content );
		
		$this->set_post_html( $post );
		
		$this->set_post_title( $post );
		
	} // end set_template_post
	
	
	public function set_post_title( $post ){
		
		$this->title = $post->post_title;
		
	} // end set_post_title
	
	public function set_post_html( $post ){
		
		$this->html = apply_filters( 'the_content' , $post->post_content );
		
	} // end set_post_title
	
	public function get_document_title(){
		
		return '<title>' . $this->get_title() . '</title>';
		
	} // end get_document_title 
	
	public function get_style(){
		
		$style .= '<style>' . file_get_contents( dirname(__FILE__) . '/style.css') . '</style>';
		
		return $style;
		
	}
	
	public function get_pdf_document(){
		
		$html = '<!doctype html><html><head><meta charset="utf-8">';
		
		$html .= $this->get_document_title();
		
		$html .= $this->get_style();
		
		$html .= '</head><body>';
		
		$html .= $this->get_pdf_html();
		
		$html .= $this->get_footer();
		
		$html .= '</body></html>';
		
		return $html;
		
	} // end set_pdf_html
	
	public function get_footer(){
		
		return '';
		
	}
	
	public function render_pdf( $dompdf ){
		
		$dompdf->load_html( $this->get_pdf_document() );
	
		$dompdf->render();
	
		$dompdf->stream("publication.pdf", array("Attachment" => 0));
		
	} // end get_pdf_html
	
}