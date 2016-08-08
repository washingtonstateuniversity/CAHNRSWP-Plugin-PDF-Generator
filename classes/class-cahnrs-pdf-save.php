<?php

class CAHNRS_PDF_Save extends CAHNRS_PDF {
	
	public function save_pdf( $post ){ 
		
		if ( $this->check_perms() ){
			
			$response = $this->generate_pdf( $post );
			
			if ( ! empty( $response['file'] ) && ! empty( $response['file_name'] ) ){
			
				$copy_path = $this->copy_pdf( $response['file'] , $response['file_name'] );
				
				$this->update_post_meta( $post , $copy_path );
				
				$this->do_response( $copy_path , $response['file_name'] );
			
			} else {
				
				$this->do_response( false , 'na' );
				
			}// end if 
			
		} else {
			
			$this->do_response( false , 'na' );
			
		} // end if
		
	} // end save_pdf
	
	
	private function copy_pdf( $pdf_path , $filename ){
		
		if ( $this->check_file( $pdf_path ) && $this->check_perms() ){
			
			$uploaddir = wp_upload_dir( 'pdfs');
		
			$uploadfile = $uploaddir['path'] . $filename;
			
			$contents= file_get_contents( $pdf_path );
			
			$savefile = fopen( $uploadfile , 'w' );
			
			fwrite($savefile, $contents);
			
			fclose($savefile);
			
			return $uploaddir['url'] . $filename;
			
		} // end if
		
		return false;
		
	} // end copy_pdf
	
	
	private function update_post_meta( $post , $file_url ){
		
		if ( $file_url && $this->check_perms() ) {
			
			update_post_meta( $post->ID , $this->meta_key , $file_url );
			
		} // end if
		
	} // end update_post_meta
	
	
	private function check_perms(){
		
		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ){
			
			return true;
			
		} // end if
		
		return false;
		
	} // end check_perms
	
	
	private function check_file( $path ){
		
		$regex = '/^http:\/\/134\.121\.225\.236/';
		
		if ( preg_match( $regex , $path ) ){
			
			return true;
			
		} // end if
		
		return false;
		
	} // end path
	
	
	protected function do_response( $path , $filename ){
		
		$json = array(
			'file' => $path,
			'file_name' => $filename,
		);
		
		echo json_encode( $json );
		
	}
	
} // end CAHNRS_PDF_Save