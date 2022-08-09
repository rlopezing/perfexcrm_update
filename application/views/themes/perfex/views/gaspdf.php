<?php
$dimensions = $pdf->getPageDimensions();

$pdf_logo_url = pdf_logo_url();
$pdf->writeHTMLCell(($dimensions['wk'] - ($dimensions['rm'] + $dimensions['lm'])), '', '', '', $pdf_logo_url, 0, 1, false, true, 'L', true);

$pdf->ln(4);
// Get Y position for the separation
$y = $pdf->getY();

$simulator_info = '<div style="color:#424242;">';
    $simulator_info .= format_organization_info();
$simulator_info .= '</div>';

$rowcount = max(array($pdf->getNumLines($simulator_info, 80)));

// Simulator to
$client_details = '<b>'._l('simulator_to').'</b>';
$client_details .= '<div style="color:#424242;">';
    $client_details .= format_simulator_info($simulator,'pdf');
$client_details .= '</div>';

$pdf->ln(6);

$simulator_date_add = _l('simulator_date_add') . ': ' . _d($simulator->dateadded);
$subject = _l('simulation_content');
$simulator_the_best_rate = _l('simulator_the_best_rate');
$content = '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="8">';
$content .= '<tr><td>'._l('simulator_savings').' '._l('simulator_fixed_term').' (€):</td><td>'.$simulator->savings_potency.'</td></tr>';
$content .= '<tr><td>'._l('simulator_savings').' '._l('simulator_variable_term').' (€):</td><td>'.$simulator->savings_energy.'</td></tr>';
$content .= '<tr><td>'._l('simulator_savings').' (€):</td><td>'.$simulator->total_savings.'</td></tr>';
$content .= '<tr><td colspan="2">'._l('commission_marketer').': '.$simulator->marketer_savings.'</td></tr>';
$content .= '</table>';

// Get the proposals css
// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div style="width:675px !important;">
	<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="8">
		<tr><td>$simulator_info</td><td style="text-align:right;">$client_details</td></tr>
	</table>
</div>

<p style="font-size:20px;"># $number
<br /><span style="font-size:15px;">$subject</span>
</p>
$simulator_date_add
<br />
<p style="font-size:18px; text-transform: uppercase;">$simulator_the_best_rate:</p>
<div style="width:675px !important;">$content</div>
EOF;

$pdf->writeHTML($html, true, false, true, false, '');
