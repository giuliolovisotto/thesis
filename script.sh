#!/bin/sh
# This is a comment
echo "Sending requests..";
rm log.out
wget -a log.out http://localhost/comp_class.php ;
wget -a log.out http://localhost/usecase.php ;
wget -a log.out http://localhost/tr_req_uc.php ;
wget -a log.out http://localhost/req.php ;
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
cp /var/www/specifica.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/specifica.tex
cp /var/www/requisiti.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/requisiti.tex
cp /var/www/casiduso.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/casiduso.tex
cp /var/www/trReqUc.tex /home/giulio/documents/UNIVERSITA/tesi/thesis/sections/trReqUc.tex

echo "Now generating pdflatex..";
pdflatex -halt-on-error -synctex=1 -output-format='pdf' -output-directory='./build' -interaction=nonstopmode ../thesis.tex >> log.out
evince ./build/thesis.pdf > /dev/null

echo "Done\n"; 
