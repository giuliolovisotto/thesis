<?php
mysql_connect("localhost", "root", "root") or die(mysql_error());
mysql_select_db("tesi") or die(mysql_error());

// Retrieve all the data from the "example" table
$result = mysql_query("SELECT codice, descrizione, fonte, tipo FROM requisiti WHERE class ='funzionale'");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$stream="";
$file = 'requisiti.tex';
$stream .= '\subsubsection{Requisiti funzionali} \label{sec:reqfun}
\begin{center}
\begin{longtable}{ | l | p{5cm} | c | p{1.5cm} |}
\caption{Tabella requisiti funzionali} \\\\
\hline 
\textbf{Codice} & \textbf{Descrizione} & \textbf{Tipologia} & \textbf{Fonte} \\\\ \hline
\endfirsthead
\multicolumn{4}{c}%'."\n".'
{\tablename\ \thetable\ -- \textit{Continued from previous page}} \\\\
\hline
\textbf{Codice} & \textbf{Descrizione} & \textbf{Tipologia} & \textbf{Fonte} \\\\
\hline
\endhead
\hline \multicolumn{4}{r}{\textit{Continued on next page}} \\\\
\endfoot
\hline
\endlastfoot '."\n";

while ($row = mysql_fetch_array($result)) {
    $stream .= $row[0]." & ".$row[1]." & ".$row[3]." & ".$row[2].' \\\\ \hline'."\n";

}
    $stream .= '\end{longtable}'."\n".'\end{center}'."\n\n" ;







$result = mysql_query("SELECT codice, descrizione, fonte, tipo FROM requisiti WHERE class ='vincolo'");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$stream .= '\subsubsection{Requisiti di vincolo} \label{sec:reqvin}
\begin{center}
    \begin{longtable}{ | l | p{5cm} | c | p{1.5cm} |}
    \caption{Tabella requisiti di vincolo} \\\\
    \hline 
    \textbf{Codice} & \textbf{Descrizione} & \textbf{Tipologia} & \textbf{Fonte} \\\\ \hline
\endfirsthead
\multicolumn{4}{c}% '."\n".'
{\tablename\ \thetable\ -- \textit{Continued from previous page}} \\\\
\hline
\textbf{Codice} & \textbf{Descrizione} & \textbf{Tipologia} & \textbf{Fonte} \\\\
\hline
\endhead
\hline \multicolumn{4}{r}{\textit{Continued on next page}} \\\\
\endfoot
\hline
\endlastfoot'."\n";

while ($row = mysql_fetch_array($result)) {
    $stream .= $row[0]." & ".$row[1]." & ".$row[3]." & ".$row[2].' \\\\ \hline '."\n";

}
    $stream .= '\end{longtable}'."\n".'\end{center}'."\n\n";



$result = mysql_query("SELECT codice, descrizione, fonte, tipo FROM requisiti WHERE class ='qualita'");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$stream .= '\subsubsection{Requisiti di qualita} \label{sec:reqqua}
\begin{center}
    \begin{longtable}{ | l | p{5cm} | c | p{1.5cm} |}
    \caption{Tabella requisiti di qualita} \\\\
    \hline 
    \textbf{Codice} & \textbf{Descrizione} & \textbf{Tipologia} & \textbf{Fonte} \\\\ \hline
\endfirsthead
\multicolumn{4}{c}% '."\n".'
{\tablename\ \thetable\ -- \textit{Continued from previous page}} \\\\
\hline
\textbf{Codice} & \textbf{Descrizione} & \textbf{Tipologia} & \textbf{Fonte} \\\\
\hline
\endhead
\hline \multicolumn{4}{r}{\textit{Continued on next page}} \\\\
\endfoot
\hline
\endlastfoot'."\n";

while ($row = mysql_fetch_array($result)) {
    $stream .= $row[0]." & ".$row[1]." & ".$row[3]." & ".$row[2].' \\\\ \hline '."\n";

}
    $stream .= '\end{longtable}'."\n".'\end{center}'."\n\n";

$stream = mb_convert_encoding($stream, 'UTF-8', 'OLD-ENCODING');

file_put_contents($file, $stream);

echo $stream;
mysql_close();

?>

