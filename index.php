<!-- INDEX PAGE THAT INCLUDES ALL THE NECESSARY ELEMENTS OF THE PAGE (NAV, MAIN, FOOTER) -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caesar Cipher</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
    <script src="test/tests.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
    <?php
    include 'nav.php';
    
    // Script that determines the url and updates the main content only. My PHP version of SPA
    $url_arr = [];
    parse_str($_SERVER['QUERY_STRING'], $url_arr);
    reset($url_arr);

    $page_dir = "";
			
    switch(key($url_arr)) {
        case '':
            $page_dir = 'main.php';
            break;
        case 'controller':
            $page_dir = 'controller.php';
            break;
        default:
            $page_dir = 'error_404.php';
            break;
    }

    echo '<div class="main row">';
    include $page_dir;
    echo '</div>';
    
    include 'footer.php';
    ?>
</body>
</html>