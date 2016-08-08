<?php

global $post;

$pdf = new CAHNRS_PDF();

$response = $pdf->generate_pdf( $post );

$pdf->stream( $response['file'] );

