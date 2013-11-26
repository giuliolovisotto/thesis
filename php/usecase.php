<?php
mysql_connect("localhost", "root", "root") or die(mysql_error());
mysql_select_db("tesi") or die(mysql_error());

// Retrieve all the data from the "example" table
$result = mysql_query("SELECT codice, titolo, descrizione, pre, post, img, padre FROM casiduso");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$stream="";
$file = 'casiduso.tex';
while ($row = mysql_fetch_array($result)) {
    $stream .= "\subsubsection{".$row[0].": ".$row[1]."} \label{sec:".$row[0]."}\n";
    $stream .= "\begin{description}\n";
    $stream .= '\item[\em{descrizione }]'.$row[2]."\n";
   // $a = "SELECT owner, descrizione, figlio FROM flussi WHERE owner='".$row[0]."'<br>";
    $flussi=mysql_query("SELECT owner, descrizione, figlio FROM flussi WHERE owner='".$row[0]."'");
    if (mysql_num_rows($flussi)>0){
        $stream .= '\item[\em{flusso principale degli eventi }] \mbox{}'."\n".' \begin{enumerate}'."\n";
        while ($flusso = mysql_fetch_array($flussi)) {
            $stream .= "\item ". $flusso[1]."\n";
        }
	$stream .= '\end{enumerate}'."\n";
    }

    if (""!=$row[3]){
        $stream .= '\item[\em{precondizione }] '.$row[3]."\n";
    }
    if (""!=$row[4]){
        $stream .= '\item[\em{postcondizione }] '.$row[4]."\n";
    }

    $scenari=mysql_query("SELECT descrizione, padre FROM scenalt WHERE padre='".$row[0]."'");
    if (mysql_num_rows($scenari)>0){
        $stream .= '\item[\em{scenari alternativi }] \mbox{}'."\n".'
  \begin{enumerate}'."\n";
        while ($scenario = mysql_fetch_array($scenari)) {
            $stream .= "\item ". $scenario[0]."\n";
        }
	$stream .= '\end{enumerate}'."\n";
    }

    $stream .= '\end{description}'."\n\n";

    if (""!=$row[5]){
        $stream .= '\begin{figure}[htpb] '."\n".'
\centering '."\n".'
\includegraphics[scale=0.4]{./images/'.$row[5].'} '."\n".'
\caption{'.$row[0].' - '.$row[1].'} '."\n".'
\label{fig:'.strtolower($row[0]).'}'."\n".'
\end{figure} '."\n\n";
    }


}
$stream = mb_convert_encoding($stream, 'UTF-8', 'OLD-ENCODING');

file_put_contents($file, $stream);

echo $stream;

mysql_close();

?>

