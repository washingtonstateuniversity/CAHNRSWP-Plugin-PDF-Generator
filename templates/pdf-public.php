<?php 

$pdf = new CAHNRS_PDF();

global $post;

$pdf_url = get_post_meta( $post->ID , $pdf->meta_key , true );

$pdf_url = apply_filters( 'cahnrswp_pdf_public_url' , $pdf_url , $post );

if ( $pdf_url ){
	
	$pdf->stream( $pdf_url , $post->post_name . '.pdf' );
	
} // end if