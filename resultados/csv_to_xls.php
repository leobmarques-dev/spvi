<?php
/* Get the excel.php class here: http://www.phpclasses.org/browse/package/1919.html */
require_once("../classes/excel.php");

$argv[1] = $escreve; // Envia o CSV com todo o desempenho do aluno gerado em funcoes_resultados.php
 
$inputFile=$argv[1];
$xlsFile=$argv[2];
 
if( empty($inputFile) || empty($xlsFile) ) {
    die("Usage: ". basename($argv[0]) . " in.csv out.xls\n" );
}
 
$fh = fopen( $inputFile, "r" );
if( !is_resource($fh) ) {
    die("Error opening $inputFile\n" );
}
 
/* Assuming that first line is column headings */
if( ($columns = fgetcsv($fh, 1024, "\t")) == false ) {
    print( "Error, couldn't get header row\n" );
    exit(-2);
}
$numColumns = count($columns);
 
/* Now read each of the rows, and construct a
    big Array that holds the data to be Excel-ified: */
$xlsArray = array();
$xlsArray[] = $columns;
while( ($rows = fgetcsv($fh, 1024, "\t")) != FALSE ) {
    $rowArray = array();
    for( $i=0; $i&lt;$numColumns;$i++ ) {
        $key = $columns[$i];
        $val = $rows[$i];
        $rowArray["$key"] = $val;
    }
    $xlsArray[] = $rowArray;
    unset($rowArray);
}
fclose($fh);
 
/* Now let the excel class work its magic. excel.php
    has registered a stream wrapper for "xlsfile:/"
    and that's what triggers its 'magic': */
$xlsFile = "xlsfile://".$xlsFile;
$fOut = fopen( $xlsFile, "wb" );
if( !is_resource($fOut) ) {
    die( "Error opening $xlsFile\n" );
}
fwrite($fOut, serialize($xlsArray));
fclose($fOut);
 
exit(0);
?>