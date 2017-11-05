<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require 'html2pdf/html2pdf.class.php';

class Lib_html2pdf
{
	var $CI;
	public function __construct()
    {
        $this->CI =& get_instance();
    }

    function render($content){
    	error_reporting(0);

        $width_in_inches = 10;
        $height_in_inches = 5.5;

        $width_in_mm = $width_in_inches * 25.4; 
        $height_in_mm = $height_in_inches * 25.4;

    	$html2pdf = new HTML2PDF('L', array($width_in_mm, $height_in_mm ), 'en');
	    //$html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('arial');
        $html2pdf->pdf->SetTitle('Lufthansa eCertificate');
        $html2pdf->writeHTML($content);
        //$html2pdf->Output('exemple00.pdf');
        $html2pdf->Output();
    }

}