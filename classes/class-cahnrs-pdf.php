<?php
class CAHNRS_PDF {
	
	//'http://134.121.225.236/api/pdf/cahnrs-api-pdf/?access-key=wT7oB64w0w0Tn12UyVOEB6XF7sMU48KN&src=http://extension.wsu.edu&folder=impact'
	protected $request_url = 'http://134.121.225.236/api/pdf/cahnrs-api-pdf/?';
	
	protected $access_key = 'wT7oB64w0w0Tn12UyVOEB6XF7sMU48KN';
	
	
	public function get_template( $template ){
		
		if ( ! empty( $_GET['pdf'] ) ){
		
			$template = plugin_dir_path( dirname( __FILE__ ) ) . '/templates/pdf.php';
			
		} else if ( ! empty( $_GET['pdf-id'] ) ){
			
			$template = plugin_dir_path( dirname( __FILE__ ) ) . '/templates/pdf-render.php';
			
		} // end if
		
		return $template;
		
	} // end get_template
	
	
	public function get_pdf_content( $post ){
		
		$pdf_content = apply_filters( 'cahnrswp_pdf_html' , $post->post_content , $post );
		
		return $pdf_content;
		
	} // end get_pdf_content
	
	
	public function generate_pdf( $post ){
		
		$build_url = $this->build_pdf_url( $post );
		
		$request_url = $this->build_request_url( $build_url , $post );
		
		$json = file_get_contents( $request_url );
		
		$pdf = json_decode($json);
		
		return $pdf;
		
	} // end generate_pdf
	
	
	protected function build_pdf_url( $post ){
		
		$url = get_site_url();
		
		if ( strpos( $url , '?' ) !== false ){
			
			$url .= '&';
			
		} else {
			
			$url .= '?';
			
		} // end if
		
		$url .= 'pdf-id=' . $post->ID;
		
		return $url;
		
	} // end build_pdf_url
	
	
	protected function build_request_url( $build_url , $post ){
		
		$url = $this->request_url . 'access-key=' . $this->access_key;
		
		$url .= '&folder=' . $this->build_site_url();
		
		$url .= '&filename=' . $post->post_name;
		
		$url .= '&src=' . urlencode( $build_url );
		
		return $url;
		
	}
	
	protected function build_site_url(){
		
		$url = get_site_url();
		
		$url = str_replace( array( 'http://','https://','www' ) , '' , $url );
		
		$url = str_replace( array('.','/') , '-' , $url );
		
		return $url;
		
	} // end build_site_url
	
	
	public function stream( $response ){
		
		if ( isset( $response->file ) ){
			
			$output = file_get_contents( $response->file );
			
			header("Content-type: application/pdf");
			header('Content-disposition: inline;filename=' . $this->filename );
			
			echo $output;
			
		} // end if
		
	} // end stream
	
	
}