<?php

class Food_Safety_PDF extends PDF_Template {
	
	
	public function get_pdf_html(){ 
	
		$html = '<img src="' . plugin_dir_url(__FILE__) . 'images/cfs-banner.jpg" />';
		
		$html .= '<h1>' . $this->get_title() . '</h1>';
		
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
	
	
}