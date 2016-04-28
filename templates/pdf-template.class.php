<?php

abstract class PDF_Template {
	
	protected $html;
	
	protected $title;
	
	protected $summary;
	
	protected $pdf_html;
	
	protected $settings = array();
	
	protected $fields = array(
		'_number' => array( '' , 'text' ),
	);
	
	public function get_html(){ return $this->html;}
	public function get_pdf_html(){ return $this->html;}
	public function get_title(){ return $this->title;}
	public function get_fields(){ return $this->fields;}
	
	public function get_settings( $post_id = false ){
		
		if ( empty( $this->settings ) && $post_id ){
			
			$this->set_settings( $post_id );
			
			return $this->settings;
			
		} else {
			
			return $this->settings;
			
		} // end if
		
	} // end get_settings
	
	
	public function set_settings( $post_id ){
		
		foreach( $this->get_fields() as $key => $field ){
			
			$meta = get_post_meta( $post_id , $key , true );
			
			if ( $meta !== '' ) {
				
				$this->settings[ $key ] = $meta;
				
			} else {
				
				$this->settings[ $key ] = $field[0];
				
			} // end if
			
		} // end foreach
		
		var_dump( $this->settings );
		
	} // end set_settings
	
	
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
		
		$this->set_settings( $post->ID );
		
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
	
	public function get_pdf_document( $post , $options ){
		
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
	
	public function get_footer(){
		
		return '';
		
	}
	
	public function render_pdf( $post , $options , $dompdf ){
		
		
		$dompdf->load_html( $this->get_pdf_document( $post , $options ) );
	
		$dompdf->render();
	
		$dompdf->stream("publication.pdf", array("Attachment" => 0));
		
	} // end get_pdf_html
	
	
	public function the_editor( $post ){
			
	} // end the_editor
	
	
	public function get_the_number( $settings ){
		
		$html .= '<div class="cahnrs-pdf-field">';
		
			$html .= '<label>Fact Sheet Number</laber>';
		
			$html .= '<input type="text" name="_number" value="' . $settings['_number'] . '" />';
		
		$html .= '</div>';
		
		return $html;
		
	} // end the_number
	
	public function get_the_author( $settings ){
		
		$index = 0;
		
		if ( is_array( $settings['_authors'] ) ){
		
			foreach( $settings['_authors'] as $i => $author ){
				
				$html .= $this->get_author_html( $i , $author );
				
				$index++;
				
			} // end foreach
		
		} // end if
		
		$html .= $this->get_author_html( $index , array() );
		
		return $html;
		
	} // end the_number
	
	
	public function get_author_html( $i , $author ){
		
		$html .= '<fieldset class="cahnrs-pdf-author">';
			
		$html .= '<div class="cahnrs-pdf-field">';
		
			$name = ( ! empty( $author['name'] ) ) ? $author['name'] : '';
	
			$html .= '<label>Name</label>';
	
			$html .= '<input type="text" name="_author[' . $i . '][name]" value="' . $name . '" />';
	
		$html .= '</div>';
		
		$html .= '<div class="cahnrs-pdf-field">';
		
			$email = ( ! empty( $author['email'] ) ) ? $author['email'] : '';
	
			$html .= '<label>Email</label>';
	
			$html .= '<input type="text" name="_author[' . $i . '][email]" value="' . $email . '" />';
	
		$html .= '</div>';
		
		$html .= '<div class="cahnrs-pdf-field">';
		
			$title = ( ! empty( $author['title'] ) ) ? $author['title'] : '';
	
			$html .= '<label>Title</label>';
	
			$html .= '<input type="text" name="_author[' . $i . '][title]" value="' . $title . '" />';
	
		$html .= '</div>';
		
		$html .= '</fieldset>';
		
		return $html;
		
	}
	
}