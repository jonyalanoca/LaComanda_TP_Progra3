<?php
    require_once './interfaces/IApiUsable.php';
    require_once './lib/FPDF/fpdf.php';
    require_once './models/Imagen.php';

    class PdfController
    {
        public function Descargar($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $fotoBase64=$parametros['fotoBase64'];
            $fotoBinaria=base64_decode($fotoBase64);

            $ruta=Imagen::Guardar("temporal.jpg", $fotoBinaria);

            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'Trabajo Practico - La Comanda');
            $pdf->Image($ruta, 10, 30, 50, 0);
            $pdf->Output('./downloads/Logo.pdf', 'F');
            
            unlink($ruta);

            $payload = json_encode(array("mensaje" => "Se descargo el Pdf con exito."));
            
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
 
    }
?>