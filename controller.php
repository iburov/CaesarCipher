<?php
$u = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$l = 'abcdefghijklmnopqrstuvwxyz';

// js function used to submit a form with id "form"
function submit() {
    ?>
    <script>document.getElementById("form").submit();</script>
    <?php
}

// function used to send an error message back to the view
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
            $multiple_results = '';
            for($i=1; $i<26; $i++) {
                $shift = $i;
                $multiple_results .= $shift . '. ' . caesarCipher($shift, $message) .'<br>';
            }
            
            echo '<input type="hidden" name="result" value="' . $multiple_results . '">';

            if(isset($_POST['message'])) {
                echo '<input type="hidden" name="message" value="' . $_POST['message'] . '">';
            }
            if(isset($_POST['shift'])) {
                echo '<input type="hidden" name="shift" value="' . $_POST['shift'] . '">';
            }
            echo '</form>';
            submit();
        } else {
            $shift = $_POST['shift'];
            echo '<form action="index.php" method="post" id="form">';
            echo '<input type="hidden" name="result" value="' . $shift . '. ' . caesarCipher($shift, $message) . '">';
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
function decrypt() {

}

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