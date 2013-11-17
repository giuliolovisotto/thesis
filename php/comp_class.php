<?php
mysql_connect("localhost", "root", "root") or die(mysql_error());
mysql_select_db("tesi") or die(mysql_error());

// Retrieve all the data from the "example" table

$result = mysql_query("SELECT codice, nome, descrizione, padre FROM componenti");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$stream="";
while ($row = mysql_fetch_array($result)) {
    $file = 'specifica.tex';
    $fullname=$row[1];
    //echo $row[1]."<br>";
    if($row[3]!=""){ //se diverso da vuoto recupero fullname
        //echo 'we are here the component name is '.$row[1]."<br>";
        $q = "SELECT padri.nome FROM componenti figli JOIN componenti padri WHERE figli.padre = padri.codice AND figli.nome = '".$row[1]."';";
        //echo $q."<br>";
        $R = mysql_query($q);
        $Rrow = mysql_fetch_array($R);
        $fullname=$Rrow[0]."::".$fullname;
        //echo $fullname."<br>";
    } //
    $stream .= "\subsubsection{".$row[0]." - ".$fullname."} \label{sec:".strtolower($row[0])."}\n";
    $stream .= $row[2]."\\\\\n";

    //echo $stream;

    //get the relation from this component and the others
    $p = "SELECT comp1, comp2, descrizione FROM comp_usa WHERE comp1 ='".$row[0]."';";
   // echo $p."<br>";
    $relations = mysql_query($p);
    //echo mysql_num_rows($relations)."<br>";
    if (mysql_num_rows($relations)>0){ //stampiamo le relazioni
        $stream .= "Relazioni con altri componenti: \n";
        $stream .= "\begin{itemize} \n";
        while($larow = mysql_fetch_array($relations)){
            $stream .= '\item [\textbf{'.$larow[1].'}]'."\n";
            $stream .= $larow[2]." \n";
        }
        $stream .= '\end{itemize}'." \n\n";
    }

    $r = "SELECT id, nome, componente, eredita, descrizione FROM classi WHERE componente ='".$row[0]."';";
    //echo $r."<br>";
    $classes=mysql_query($r);
    if (mysql_num_rows($classes)>0){ //stampiamo le relazioni
        echo 'ha classi! <br>';

        $stream .= "Classi contenute nel componente: \n";
        $stream .= "\begin{itemize} \n";
        while($classesrow = mysql_fetch_array($classes)){
            $stream .= '\item \textbf{'.$classesrow[1].'}'."\n";
            $stream .= '\begin{description}'."\n";
            $stream .= '\item [\textit{descrizione e utilizzo:}] '.$classesrow[4]."\n";
            if($classesrow[3]!=""){
                $stream .= '\item [\textit{classi ereditate:}] '.$classesrow[3]."\n";
            }
            $stream .= '\end{description}'."\n";
        }
        $stream .= '\end{itemize}'."\n\n";
    }

}
$stream = mb_convert_encoding($stream, 'UTF-8', 'OLD-ENCODING');

file_put_contents($file, $stream);

echo $stream;

mysql_close();




?>

