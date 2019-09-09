<?php

	$html = '<br><br><br><br>';	
	$html .= '<h2 style="text-align: center;">Relatório de Ordem de Serviço</h2> ';
	$html .= '<hr> ';
	$html .= '<h3 style="font-size: 1.4em;" > Solicitante </h3>' ;
	$html .= '<label style="font-weight: bold;">Data Abertura:</label> ' . getdate()[mday] . '/' . getdate()[mon] . '/' . getdate()[year]  ;
	$html .= '<label style="margin-left: 100px; font-weight: bold;" >Tecnico:</label> ' . $os[0]->nome;
	$html .= '<label style="margin-left: 100px; font-weight: bold;" >Nº OS:</label> ' . $os[0]->id_os;
	$html .= '<br>';
	$html .= '<label style="font-weight: bold;">Tipo Equipamento:</label> ' . $os[0]->tipo ;
	$html .= '<label style="margin-left: 50px; font-weight: bold;">Equipamento:</label> ' . $os[0]->nome_equipamento ;
	$html .= '<label style="margin-left: 50px; font-weight: bold;">Nº Série:</label> ' . $os[0]->numero_serie ;
	$html .= '<br><br>';
	$html .= '<label style="font-weight: bold;">Motivo:</label> ' . $os[0]->motivo ;
	$html .= '<br><br>';
	$html .= '<label style="font-weight: bold;">Observação:</label> ' . $_POST['observacao'] ;
	$html .= '<br><br><hr> ';
	$html .= '<div style="text-align: center; margin-top: 150px;">';
	$html .= '____________________________';
	$html .= '<br>       Responsável';
	$html .= '</div>';

	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;


	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Carrega seu HTML
	$dompdf->load_html('
			<div style="text-align: center; margin-top: 50px;">
			<img src="./img/sanmichel.jpg">
			</div>
			<h1 style="text-align: center;">
			Sodré Miguel Ltda
			</h1>
			'. $html .'
		');

	$dompdf->setPaper('A4', 'portrait');

	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream("OS");	

?>