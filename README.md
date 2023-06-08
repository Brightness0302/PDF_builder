# PDF-builder description
This is a PHP project that builds a PDF from data pulled by an API. The API used for this project is https://www.posat-dubrovnik.com/cms/api/v2/test.php?lang=13. 
The PDF will contain a header and footer image, along with tables for all kinds of alcohol, wallop, or tassel. 

# Installation: 
1. Clone the repository 
2. Install the required dependencies using Composer 
3. Make sure that the  allow_url_fopen  directive is enabled in your PHP configuration 

# Usage: 
1. Run the generate_pdf.php file on Apache
2. The script will pull the data from the API and generate a PDF file 
3. The generated PDF file will be saved in the same directory as the script 

# Features: 
1. Pulls data from the specified API 
2. Generates a PDF with a header and footer image 
3. Includes tables for all kinds of alcohol, wallop, or tassel 

# Contributing: 
1. Fork the repository 
2. Make changes to the code 
3. Submit a pull request 
