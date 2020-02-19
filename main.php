<!-- MAIN VIEW DIV -->
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <h1>Caesar cipher</h1>

    <!-- Script that shows errors sent from the controller (if any) -->
    <?php
    if(isset($_POST['error'])) {
        echo '<div class="error row">' . $_POST['error'] . '</div>';
    } else {
        echo '';
    }
    ?>

    <!-- Form that is sent to the controller -->
    <form action="index.php?controller" method="post" class="mt-2">

        <!-- Plaintext/Cipher textarea -->
        <?php
        $message = '';
        if(isset($_POST['message'])) {
            $message = $_POST['message'];
        } 
        ?>
        <textarea name="message" id="myTextArea" class="col-12 form-control" placeholder="Your plaintext or cipher here..." maxlength="300"><?php echo $message ?></textarea>

        <!-- Shift number if the user want to encrypt the message with a specific shift -->
        <?php
        $shift = '';
        if(isset($_POST['shift'])) {
            $shift = $_POST['shift'];
        } 
        ?>
        <input type="number" name="shift" title="Leave empty for all possible ciphers" class="col-xs-6 col-sm-6 col-md-3 col-lg-2 form-control mt-2" placeholder="Shift" min="0" max="25" step="1" value='<?php echo $shift ?>'>
        
        <!-- Two submit button that send information to the controller whether the message should be encrypted or decrypted -->
        <div class="row mt-2">
            <div class="col-1"></div>
            <input type="submit" name="encrypt" class="btn col-4" value="Encrypt">
            <div class="col-2"></div>
            <input type="submit" name="decrypt" class="btn col-4" value="Decrypt">
            <div class="col-1"></div>
        </div>
    </form>
</div>

<!-- Results block that shows encypted/decrypted message(s). Shown only when a result is sent from the controller. -->
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="results m-2" id="results">
        <h2 class="center">RESULTS</h2>
        <?php
        if(isset($_POST['result'])) {
            // echo $_POST['result'];
            echo implode("<br>", $_POST['result']);
        } else {
            ?>
            <script>document.getElementById("results").style.display = "none";</script>
            <?php
        }
        ?>
    </div>
</div>
