<?php
class PDF_Generator_Admin {
	
	
	protected $sanitize;
	
	
	protected $fields = array(
		'_pdf_post_types' => array( array() , 'array' ),
		'_pdf_default_template'  => array( '' , 'text' ),
	);
	
	protected $settings = array();
	
	
	public function get_fields(){ return $this->fields; }
	
	
	public function __construct( $sanitize ){
		
		$this->sanitize = $sanitize;
		
	} // end __construct
	
	
	public function the_options(){
		
		add_action('admin_menu', array( $this , 'add_options_page' ), 10 );
		
	} // end the_options
	
	
	public function add_options_page(){
		
		if ( ! empty( $_POST['is_update'] ) ) {
			
			$this->update_options();
			
		} // end if
		
		add_submenu_page( 'options-general.php', 'PDF Generator Settings','PDF Generator', 'manage_options', 'cahnrspdf', array( $this, 'the_options_page' ) );
		
	} // end add_options_page
	
	
	public function the_options_page(){
		
		$settings = $this->get_settings();
		
		$html = '<h1>PDF Generator Settings</h1>';
		
		$html .= '<form method="post" action="">';
		
		$html .= '<input type="hidden" value="true" name="is_update" />';
		
		$html .= '<table class="form-table"><tbody>';
		
			$html .= '<tr>';
			
				$html .= '<th scope="row">Allow On:</th>';

				$html .= '<td>' . $this->get_post_type_inputs( $settings ) . '</td>';
				
			$html .= '</tr>';
			
			$html .= '<tr>';
			
				$html .= '<th scope="row">Default Template:</th>';

				$html .= '<td><select name="_pdf_default_template">';
				
					$html .= '<option value="">Select...</option>';
				
					$html .= '<option value="animal-ag" ' . selected( $settings['_pdf_default_template'], 'animalag', false ) . '>Animal Ag</option>';
				
					$html .= '<option value="food-safety"  ' . selected( $settings['_pdf_default_template'], 'consumerfoodsafety', false ) . '>Consumer Food Safety</option>';
				
				$html .= '</select></td>';
				
			$html .= '</tr>';
			
		$html .= '</tbody></table>';
		
		$html .= '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
		
		$html .= '</form>';
		
		echo $html;
		
	} // end the_options_page
	
	
	public function update_options(){
		
		foreach( $this->get_fields() as $key => $field ){
			
			if ( isset( $_POST[ $key ] ) ){
				
				$value = $this->sanitize->clean( $_POST[ $key ] , $field[1] );
				
				update_option( $key, $value );
				
			} // end if
			
		};
		
	} // end update_options
	
	
	protected function get_post_type_inputs( $settings ){
		
		$html = '';
		
		$post_types = get_post_types( array( 'public' => true ) , 'objects'  );
		
		foreach( $post_types as $post_type ){
			
			$html .= '<div class="cahnrs-option-field">';
			
				if ( in_array( $post_type->name , $settings['_pdf_post_types'] ) ){
					
					$checked = 'checked="checked" ';
					
				} else {
					
					$checked = '';
					
				}// end if
			
				$html .= '<input id="pdf-post-type-' . $post_type->name . '" type="checkbox" name="_pdf_post_types[]" value="' . $post_type->name . '" ' . $checked . '/>';
				
				$html .= '<label for="pdf-post-type-' . $post_type->name . '">' . $post_type->labels->name . '</label>';
			
			$html .= '</div>';
			
		} // end foreach
		
		return $html;
		
	} // end get_post_type_inputs
	
	
	public function get_settings(){
		
		if ( empty( $this->settings ) ){
		
			foreach( $this->get_fields() as $key => $field ){
				
				$this->settings[ $key ] = get_option( $key , $field[0] );
				
			} // end foreach
			
			return $this->settings;
		
		} else {
			
			return $this->settings;
			
		}// end if
		
	} // end get_settings
	
}