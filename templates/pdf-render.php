<?php

$memcache_obj = new Memcache;
$memcache_obj->connect('localhost', 11211);

$memcache_obj->flush();

$pdf = new CAHNRS_PDF();

$post_id = sanitize_text_field( $_GET['pdf-id'] );
$post = get_post( $post_id );

;?>
<!doctype html>
<html>
<head>
<?php do_action( 'cahnrswp_pdf_css' , $post , $pdf ); ?>
<meta charset="utf-8">
<title><?php echo apply_filters( 'cahnrswp_pdf_title' , $post->post_title , $post );?></title>
</head>
<body>
<?php echo $pdf->get_pdf_content( $post );?>
</body>
</html>

