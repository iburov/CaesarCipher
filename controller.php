<?php
$u = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$l = 'abcdefghijklmnopqrstuvwxyz';

// js function used to submit a form with id "form"
function submit() {
    ?>
    <script>document.getElementById("form").submit();</script>
    <?php
}

// function used to send an error message and sticky data back to the view
function error($message) {
    echo '<form action="index.php" method="post" id="form">';
    echo '<input type="hidden" name="error" value="' . $message . '">';
    if(isset($_POST['message'])) {
        echo '<input type="hidden" name="message" value="' . $_POST['message'] . '">';
    }
    if(isset($_POST['shift'])) {
        echo '<input type="hidden" name="shift" value="' . $_POST['shift'] . '">';
    }
    echo '</form>';
    submit();
}

// function that actually encrypts a message based on given shift
function caesarCipher($shift, $message) {
    global $u, $l;

    $cipher = '';
    for($i=0; $i<strlen($message); $i++) {
        if(strpos($u, $message[$i])!==false) {
            $newIndex = (strpos($u, $message[$i])+$shift)%26;
            $newLetter = substr($u, $newIndex, 1);
            $cipher .= $newLetter;
        } else if(strpos($l, $message[$i])!==false) {
            $newIndex = (strpos($l, $message[$i])+$shift)%26;
            $newLetter = substr($l, $newIndex, 1);
            $cipher .= $newLetter;
        } else {
            $cipher .= $message[$i];
        }
    }
    return $cipher;
}

// algorithm to encrypt the plaintext
function encrypt($message) {
    if(isset($_POST['shift'])) {
        if($_POST['shift']=='') {
            echo '<form action="index.php" method="post" id="form">';

            // generates multiple ciphers
            $multiple_results = array();
            for($i=1; $i<26; $i++) {
                $shift = $i;
                array_push($multiple_results, $shift . ': ' . caesarCipher($shift, $message));
            }
            //multiple inputs generated to send an array to the view
            foreach($multiple_results as $result) {
                echo '<input type="hidden" name="result[]" value="<b>' . $result . '">';
            }

            if(isset($_POST['message'])) {
                echo '<input type="hidden" name="message" value="' . $_POST['message'] . '">';
            }

            if(isset($_POST['shift'])) {
                echo '<input type="hidden" name="shift" value="' . $_POST['shift'] . '">';
            }
            
            echo '</form>';
            submit();
        } else {
            //generates cipher based on specified shift
            $shift = $_POST['shift'];
            echo '<form action="index.php" method="post" id="form">';
            echo '<input type="hidden" name="result[]" value="<div class=\'result_unit\'><b>' . $shift . ': ' . caesarCipher($shift, $message) . '</b></div>">';
            if(isset($_POST['message'])) {
                echo '<input type="hidden" name="message" value="' . $_POST['message'] . '">';
            }
            if(isset($_POST['shift'])) {
                echo '<input type="hidden" name="shift" value="' . $_POST['shift'] . '">';
            }
            echo '</form>';
            submit();
        }
    } else {
        error("Shift not set");
    }
}


// algorith used to decrypt a message
function decrypt($message) {
    // get json array of english words
    $json = file_get_contents('node_modules\an-array-of-english-words\index.json');
    $json_arr = json_decode($json, true);

    // generate array of all possible decrypted messages
    $multiple_results = array();
    for($i=1; $i<26; $i++) {
        $shift = $i;
        array_push($multiple_results, (($shift-26)*-1) . ': ' . caesarCipher($shift, $message));
    }

    // assign word count as key for every version of decrypted message
    $count = 0;
    $count_arr = array();
    for($j=0; $j<count($multiple_results); $j++) {
        for($k=0; $k<count($json_arr); $k++) {
            if(strpos($multiple_results[$j], $json_arr[$k])!==false) {
                $count++;
            }
        }
        array_push($count_arr, array($count, $multiple_results[$j]));
        $count = 0;
    }

    // sort the array of decryped messages descending number of words
    sort($count_arr);
    $count_arr = array_reverse($count_arr);

    echo '<form action="index.php" method="post" id="form">';
    //multiple inputs generated to send an array to the view
    foreach($count_arr as $result) {
        echo '<input type="hidden" name="result[]" value="<div class=\'result_unit\'><b>' . $result[1] . '</b><br> Words found:' . $result[0] . '"></div>';
    }
    if(isset($_POST['message'])) {
        echo '<input type="hidden" name="message" value="' . $_POST['message'] . '">';
    }
    echo '</form>';
    submit();
}

//general validations
if(isset($_POST['message'])) {
    if($_POST['message']!='') {
        $message = $_POST['message'];
        if(isset($_POST['encrypt'])) {
            encrypt($message);
        } else if(isset($_POST['decrypt'])) {
            decrypt($message);
        } else {
            error('An error occured');
        }
    } else {
        error('Empty field');
    }
} else {
    error('Message not set');
}
?>