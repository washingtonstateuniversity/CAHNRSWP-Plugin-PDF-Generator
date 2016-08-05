<?php

class Animal_Ag_PDF extends Core_Web_Template {
	
	protected $fields = array(
		'_fs_number' => array('', 'text'),
		'_fs_authors' => array( array() , 'array' ),
		);
	
	public function get_pdf_html( $settings ){ 
	
		$html = $this->get_banner( $settings );
		
		$html .= $this->get_part_title( $settings );
		
		$html .= $this->get_html();
		
		//$html .= '<hr>' .htmlspecialchars ( $this->get_html() );
		
		return $html; 
	
	}
	
	public function get_style(){
		
		$style = parent::get_style();
		
		$style .= '<style>' . file_get_contents( dirname(__FILE__) . '/style.css') . '</style>';
		
		return $style;
		
	} // end get_style
	
	public function get_footer(){
		
		$html = '<footer>';
		
		$html .= '<div>Washington State University Extension, P.O. Box 646376,	Pullman, WA</div>';
		
		$html .= '<div class="small-text">WSU	Extension	programs	and	employment	are	available	to	all	without	discrimination.	Evidence	of	noncompliance	may	be	reported	through	your	local	WSU	Extension	office.</div>';
		
		$html .= '</footer>';
		
		return $html;
		
	}
	
	/**
	 * Get coverpage banner
	 * @param object $options Options object
	 * @return string HTML
	 */
	public function get_banner( $settings ){
		
		$html = '<div id="banner">';
		
			$html .= '<img src="' . plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'images/wsu-extension-logo.jpg" width="250" />';
			
			$html .= '<div>';
				
				$html .= '<h2>WSU Animal Agriculture Team</h2>';
					
				$html .= '<div class="pub-number">Fact Sheet #' . $settings['_fs_number'] . '</div>';
				$html .= '<a href="extension.wsu.edu/animalag" class="link">extension.wsu.edu/animalag</a>'; 
				
			$html .= '</div>';
			
		$html .= '</div>';
		
		/*$html = '<table class="logo-banner content-width-wide">';
		
			$html .= '<tr>';
			
				$html .= '<td class="ext-logo" width="200">';
				
					$html .= '<img src="' . plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'images/wsu-extension-logo.jpg" width="250" />';
					
					$html .= 'test';
				
				$html .= '</td>';
				
				$html .= '<td class="title-text">';
				
					$html .= '<h2>WSU Animal Agriculture Team</h2>';
					
					$html .= '<div class="pub-number">Fact Sheet #1009-2003</div>';
					$html .= '<a href="extension.wsu.edu/animalag" class="link">extension.wsu.edu/animalag</a>'; 
				
				$html .= '</td>';
			
			$html .= '</tr>';
		
		$html .= '</table>';
		
		$html .= htmlspecialchars ( $html );*/
		
		return $html;
		
	} // end get_banner
	
	
	/**
	 * Get coverpage title
	 * @param object $options Options object
	 * @return string HTML
	 */
	public function get_part_title( $settings ) {
		
		$html = '<div class="pub-title content-width">';
		
			$html .= '<h1>' . $this->get_title() . '</h1>';
	
			$html .= '<div class="author">By: ';
			
			$a = true;
			
			foreach( $settings['_fs_authors'] as $author ){
				
				if ( $author['name'] ){
				
					if ( ! $a ) $html .= ', ';
					
					$html .= $author['name'];
					
					$a = false;
				
				} // end if
				
			} // end if
			
			$html .= '</div>';
		
		$html .= '</div>';
		
		return $html;
		
	}// end get_banner
	
}