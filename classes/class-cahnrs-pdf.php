<?php
class CAHNRS_PDF {
	
	//'http://134.121.225.236/api/pdf/cahnrs-api-pdf/?access-key=wT7oB64w0w0Tn12UyVOEB6XF7sMU48KN&src=http://extension.wsu.edu&folder=impact'
	protected $request_url = 'http://134.121.225.236/api/pdf/cahnrs-api-pdf/?';
	
	protected $access_key = 'wT7oB64w0w0Tn12UyVOEB6XF7sMU48KN';
	
	public $meta_key = '_cwp_pdf';
	
	
	public function init(){
		
		if ( ! empty( $_GET['pdf'] ) || ! empty( $_GET['pdf-id'] ) ){
			
			add_filter( 'template_include', array( $this , 'get_template' ), 99 );
			
		} // end if
		
		add_action( 'edit_form_after_title' , array( $this , 'the_editor' ), 1 );
		
		add_action( 'admin_enqueue_scripts', array( $this , 'add_admin_scripts' ), 11, 1 );
		
		add_action( 'save_post', array( $this , 'save_pdf' ) );
		
	} // end init
	
	
	public function get_template( $template ){
		
		if ( ! empty( $_GET['pdf'] ) ){
			
			switch( $_GET['pdf'] ){
				
				case 'preview':
					$template = plugin_dir_path( dirname( __FILE__ ) ) . '/templates/pdf.php';
					break;
				case 'save':
					$template = plugin_dir_path( dirname( __FILE__ ) ) . '/templates/pdf-save.php';
					break;
				default:
					$template = plugin_dir_path( dirname( __FILE__ ) ) . '/templates/pdf-public.php';
					break;
			} // end switch
			
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
		
		$pdf = json_decode( $json , true );
		
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
	
	
	public function stream( $file_path , $filename = false ){
		
		if ( ! $filename ) $filename = $this->filename;
		
		
		if ( isset( $file_path ) ){
			
			$output = file_get_contents( $file_path );
			
			header("Content-type: application/pdf");
			header('Content-disposition: inline;filename=' . $filename );
			
			echo $output;
			
		} // end if
		
	} // end stream
	
	
	public function the_editor( $post ){
		
		$pdf_url = apply_filters( 'cahnrswp_pdf_public_url' , get_post_meta( $post->ID , $this->meta_key , true ) , $post );
	
		$post_link = get_post_permalink( $post->ID );
		
		include dirname( dirname( __FILE__ ) ) . '/inc/inc-the-editor.php';
		
	} // end the_eidtor
	
	
	/**
	  * Add admin scripts
	  */
	 public function add_admin_scripts( $hook ){
		 
		 if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
				
			wp_enqueue_style( 
				'cwp_pdf_admin_style' , 
				plugin_dir_url( dirname( __FILE__ ) ) . 'css/admin-style.css', 
				array() , 
				CAHNRS_PDF_Generator::$version 
				);
			
			wp_enqueue_script( 
				'cwp_pdf_admin_js', 
				plugin_dir_url( dirname( __FILE__ ) ) . 'js/editor.js', 
				array('jquery-ui-draggable','jquery-ui-droppable','jquery-ui-sortable'), 
				CAHNRS_PDF_Generator::$version, 
				true 
				);
			
		} // end if
		 
	 } // end add_admin_scripts
	 
	 
	 public function save_pdf( $post_id ){
		 
		 if ( ! empty( $_POST[ $this->meta_key ] ) && $this->check_save_permissions( $post_id ) ){
			 
			 update_post_meta( $post_id , $this->meta_key , sanitize_text_field( $_POST[ $this->meta_key ] ) );
			 
		 } // end if
		 
	 } // end save_pdf
	 
	 
	 /**
	 * Check user permissions
	 * @param int $post_id Post ID
	 * @return bool TRUE if has permissions otherwise FALSE
	 */
	protected function check_save_permissions( $post_id ){
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return false;

		} // end if

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( current_user_can( 'edit_page', $post_id ) ) {

				return true;

			} // end if

		} else {

			if ( current_user_can( 'edit_post', $post_id ) ) {

				return true;

			} // end if

		} // end if
		
		return false;
		
	}// end check_permissions
	
	
}