// These are some kind of test that check
// if correct elements are displayed and
// that there is the correct number of results during decryption and ecryption without the shift
$(document).ready(function() {
  if ($(".results").css("display") == "none") {
    console.log("results not showing");
  } else {
    let shiftSet = false;
    let messageSet = false;

    if ($(".shift").val() != "") {
      console.log("shift set");
      shiftSet = true;
    } else {
      console.log("shift not set");
    }

    if ($(".message").val() != "") {
      console.log("message set");
      messageSet = true;
    } else {
      console.log("message not set");
    }

    if (messageSet && !shiftSet) {
      if ($(".results .result_unit").length == 25) {
        console.log("Correct number of results");
      } else {
        console.log(
          "Incorrect number of results - TEST FAILED" +
            $(".results .result_unit").length
        );
      }
    }
  }
});
