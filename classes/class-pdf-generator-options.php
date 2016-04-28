<?php 
class PDF_Generator_Options {
	
	protected $options;
	
	protected $fields = array(
		'_pdf_post_types' => array( array() , 'array' ),
		'_pdf_default_template'  => array( '' , 'text' ),
	);
	
	public function init(){
		
		$this->the_options();
		
		add_action('admin_menu', array( $this , 'add_options_page' ), 10 );
		
	} // end init
	
	
	public function get_options( $reload = false ){ 
	
		if ( ! isset( $this->options ) || $reload ){
			
			$this->the_options();
			
			return $this->options;
			
		} else {
		
			return $this->options; 
			
		} // end if
	
	}
	
	public function get_option( $key ){
		
		$options = $this->get_options();
		
		if ( array_key_exists( $key , $options ) ){
			
			return $options[ $key ];
			
		} else {
			
			return '';
			
		} // end if 
		
	} // end get_option 
	
	
	public function get_fields(){ return $this->fields; }
	
	
	public function the_options(){
		
		foreach ( $this->get_fields() as $key => $field ){
			
			$this->options[ $key ] = get_option( $key , $field[0] );
			
		} // end foreach
		
	} // end the_options
	
	
	public function add_options_page(){
		
		if ( ! empty( $_POST['is_update'] ) ) {
			
			$this->update_options();
			
		} // end if
		
		add_submenu_page( 'options-general.php', 'PDF Generator Settings','PDF Generator', 'manage_options', 'cahnrspdf', array( $this, 'the_options_page' ) );
		
	} // end add_options_page
	
	
	public function the_options_page(){
		
		$settings = $this->get_options( true );
		
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
				
					$html .= '<option value="animal-ag" ' . selected( $settings['_pdf_default_template'], 'animal-ag', false ) . '>Animal Ag</option>';
				
					$html .= '<option value="food-safety"  ' . selected( $settings['_pdf_default_template'], 'food-safety', false ) . '>Consumer Food Safety</option>';
				
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
				
				$value = $_POST[ $key ];
				
				update_option( $key, $value );
				
			} // end if
			
		} // end foreach
		
		$this->the_options();
		
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
	
}