# readpdftest
PDF reader/writer with Symfony4, PHP7
A web application that can read, edit and save a PDF. User can upload a PDF file en see this text as a HTML. You can change the text and save and download content as a new PDF file.
Add very simple this two libraries to your Symfony with composer
composer require smalot/pdfparser
composer require knplabs/knp-snappy-bundle
Download and instal wkHtmlToPdf for windows or linux from : https://wkhtmltopdf.org/downloads.html

Fix your path in .dev file
###> knplabs/knp-snappy-bundle ###
#WKHTMLTOPDF_PATH=/usr/local/bin/wkhtmltopdf
#WKHTMLTOIMAGE_PATH=/usr/local/bin/wkhtmltoimage
#windows
WKHTMLTOPDF_PATH="\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\""
WKHTMLTOIMAGE_PATH="\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\""
###< knplabs/knp-snappy-bundle ###


