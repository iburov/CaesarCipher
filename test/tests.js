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
      console.log($(".results .result_unit").length);
    }
  }
});
