<?php
mysql_connect("localhost", "root", "root") or die(mysql_error());
mysql_select_db("tesi") or die(mysql_error());

// Retrieve all the data from the "example" table


$stream="";
$file = 'trReqUc.tex';


echo ' 
\newpage
\subsubsection{Tracciamento requisiti}\label{sec:tracciamento}
\begin{center}
    \begin{longtable}{ | c | p{1.5cm} |}
    \caption{Tabella tracciamento requisiti - casi d\'uso} \\\\
    \hline 
    \textbf{Fonte} & \textbf{Requisiti}  \\\\ \hline
\endfirsthead
\multicolumn{2}{c}% '."\n".'
{\tablename\ \thetable\ -- \textit{Continued from previous page}} \\\\
\hline
 \textbf{Fonte} & \textbf{Requisiti} \\\\
\hline
\endhead
\hline \multicolumn{2}{r}{\textit{Continued on next page}} \\\\
\endfoot
\hline
\endlastfoot '."\n";

$result3 = mysql_query("SELECT codice FROM requisiti WHERE fonte='Interno'");
while($row3 = mysql_fetch_array($result3)){
	echo "Interno & ".$row3[0].' \\\\ \hline <'."\n";
}

$result4 = mysql_query("SELECT codice FROM requisiti WHERE fonte='Capitolato'");
while($row4 = mysql_fetch_array($result4)){
	echo "Capitolato & ".$row4[0].' \\\\ \hline '."\n";
}

$result = mysql_query("SELECT codice, titolo FROM casiduso");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

while($row=mysql_fetch_array($result)){
    $list = "";
    $res2 = mysql_query("SELECT codice, fonte FROM requisiti");
    while($row2 = mysql_fetch_array($res2)){
	$some = $row[0];
	$some .= ".";
	//echo $some."<br>";
        if (strpos($row2[1], $row[0]) !== FALSE and strpos($row2[1], $some)===FALSE){
            //echo $row[0]." is contained in ".$row2[1]."<br>";
	    echo $row[0]." ".$row[1]." & ".$row2[0].' \\\\ \hline '."\n";
        }
    }
}
    echo '\end{longtable} '."\n".'
\end{center} '."\n";


$stream = mb_convert_encoding($stream, 'UTF-8', 'OLD-ENCODING');

file_put_contents($file, $stream);

echo $stream;

mysql_close();

?>

