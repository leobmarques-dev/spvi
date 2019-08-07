<?php
function validaCSV_BD($CSV_como_array){

	if(isset($CSV_como_array)){
	
		if(
			$CSV_como_array[0] == "Data" AND
			$CSV_como_array[1] == "Participante" AND
			$CSV_como_array[2] == "VI" AND
			$CSV_como_array[3] == "NumTentativas" AND
			$CSV_como_array[4] == "CliquesOP1" AND
			$CSV_como_array[5] == "CliquesOP2" AND
			$CSV_como_array[6] == "S+OP1" AND
			$CSV_como_array[7] == "S+OP2" AND
			$CSV_como_array[8] == "VIsOP1" AND
			$CSV_como_array[9] == "VIsOP2" AND
			$CSV_como_array[10] == "CliquesS+_OP1" AND
			$CSV_como_array[11] == "CliquesS+_OP2" AND
			$CSV_como_array[12] == "momentoS+OP1" AND
			$CSV_como_array[13] == "momentoS+OP2" AND
			$CSV_como_array[14] == "TempoTotal" AND
			$CSV_como_array[15] == "NomeOp1" AND
			$CSV_como_array[16] == "NomeOp2" AND
			$CSV_como_array[17] == "OperandoEscolhido" AND
			$CSV_como_array[18] == "NomeArqCSV"
			
		){ $compativel = true;	}
		
		if ($compativel != true) {
			echo '<h4>Campos do CSV com Problemas de compatibilidade (CSV <=> BD):</h4><ul>';
				if ($CSV_como_array[0] != "Data") {
					echo "<li>Data</li>";
				} if ($CSV_como_array[1] != "Participante") {
					echo "<li>Participante</li>";
				} if ($CSV_como_array[2] != "VI") {
					echo "<li>VI</li>";
				} if ($CSV_como_array[3] != "NumTentativas") {
					echo "<li>NumTentativas</li>";
				} if ($CSV_como_array[4] != "CliquesOP1") {
					echo "<li>CliquesOP1</li>";
				} if ($CSV_como_array[5] != "CliquesOP2") {
					echo "<li>CliquesOP2</li>";
				} if ($CSV_como_array[6] != "S+OP1") {
					echo "<li>S+OP1</li>";
				} if ($CSV_como_array[7] != "S+OP2") {
					echo "<li>S+OP2</li>";
				} if ($CSV_como_array[8] != "VIsOP1") {
					echo "<li>VIsOP1</li>";
				} if ($CSV_como_array[9] != "VIsOP2") {
					echo "<li>VIsOP2</li>";
				} if ($CSV_como_array[10] != "CliquesS+_OP1") {
					echo "<li>CliquesS+_OP1</li>";
				} if ($CSV_como_array[11] != "CliquesS+_OP2") {
					echo "<li>CliquesS+_OP2</li>";
				} if ($CSV_como_array[12] != "momentoS+OP1") {
					echo "<li>momentoS+OP1</li>";
				} if ($CSV_como_array[13] != "momentoS+OP2") {
					echo "<li>momentoS+OP2</li>";
				} if ($CSV_como_array[14] != "TempoTotal") {
					echo "<li>TempoTotal</li>";
				} if ($CSV_como_array[15] != "NomeOp1") {
					echo "<li>NomeOp1</li>";
				} if ($CSV_como_array[16] != "NomeOp2") {
					echo "<li>NomeOp2</li>";
				} if ($CSV_como_array[17] != "OperandoEscolhido") {
					echo "<li>OperandoEscolhido</li>";
				} if ($CSV_como_array[18] != "NomeArqCSV") {
					echo "<li>NomeArqCSV</li>";
				}
			echo '</ul>';	
		}
		
		return $compativel;
	}
	
}
?>