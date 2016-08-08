<?php

require_once dirname( dirname( __FILE__ ) ) . '/classes/class-cahnrs-pdf-save.php';

$pdf_save = new CAHNRS_PDF_Save();

global $post;

$pdf_save->save_pdf( $post );