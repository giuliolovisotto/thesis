#!/bin/sh
# This is a comment
echo "Sending requests..";
rm log.out
wget -a log.out http://localhost/comp_class.php ;
wget -a log.out http://localhost/usecase.php ;
wget -a log.out http://localhost/tr_req_uc.php ;
wget -a log.out http://localhost/req.php ;
wget -a log.out http://localhost/esitistatica.php ;
wget -a log.out http://localhost/esitoreq.php ;
wget -a log.out http://localhost/esitovalidazione.php ;
wget -a log.out http://localhost/tests.php ;



echo "Requests sent, check log.out for output";
rm ./*.php* ;
echo "Sleep for 3 sec hoping that everything gets updated..";
sleep 1;
echo "..1";
sleep 1;
echo "..2";
sleep 1;
echo "..3";
echo "Copy files to thesis directory..";
mv /var/www/specifica.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/specifica.tex
mv /var/www/requisiti.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/requisiti.tex
mv /var/www/casiduso.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/casiduso.tex
mv /var/www/trReqUc.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/trReqUc.tex
mv /var/www/esitistatica.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/esitistatica.tex
mv /var/www/testvalidaz.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/testvalidaz.tex
mv /var/www/esitoreq.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/esitoreq.tex
mv /var/www/esitovalidazione.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/esitovalidazione.tex

echo "Now generating pdflatex..";
pdflatex -halt-on-error -synctex=1 -output-format='pdf' -output-directory='./build' -interaction=nonstopmode ../thesis.tex >> log.out
evince ./build/thesis.pdf > /dev/null

echo "Done\n"; 
