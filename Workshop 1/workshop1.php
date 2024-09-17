 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Date & Time PHP</title>
 </head>
 <body>
    <h1>Current Date & Time </h1>
    <p>
        <?php
            date_default_timezone_set('America/Costa_Rica'); // Sets the timezone to Costa Rica
            echo date('Y-m-d H:i:s'); //Prints the Current Date & Time in AAAA-MM-DD HH:MM:SS format
        ?>
    </p>
 </body>
 </html>
