var Pnr = {

  settings: {
    pnrTypeHead: $('.pnr-type-ahead'),
    pnrInput: ('#pnr_number'),
    pnrSubmit: ('#pnr-form-submit')
  },
  init: function() {
    this.bindUIActions();
  },

  showPNRTypehead: function(fetchPnr) {
    Pnr.settings.pnrTypeHead.css({
      "height": "130px",
      'margin-bottom': "16px"
    });
    if (fetchPnr === true) {
      this.fetchPNRDetail();
    } else {
      this.settings.pnrTypeHead.css({
        'box-shadow': '0 0 30px #2AB3DB'
      });
    }
  },

  removePNRTypehead: function() {
    this.settings.pnrTypeHead.css({
      "height": "0px",
      'margin-bottom': "0px"
    });
  },
  fetchPNRDetail: function() {
    var pnrNumber = $("#pnr_number").val();
    $.ajax({
      cache: false,
      dataType: 'json',
      url: BASE_PATH + '/getPnrDetail/' + pnrNumber,
      method: 'GET',
      beforeSend: function() {
        $(".pnr-type-ahead .horizontal-loader").removeClass("hidden");
        $("#pnr-search-result-container #pnr_result_message_any").html("");
        $("#pnr-search-result-container #pnr_result_message_any").addClass("hidden");
        $("#pnr-search-result-container .right-arrow-icon__pnr_result").addClass("hidden");
      },
      success: function(data) {
        $(".pnr-type-ahead .horizontal-loader").addClass("hidden");
        if (data && data.status) {
          if (data.status === true) {
            $("#pnr-search-result-container #pnr_date").html(data.doj);
            $("#pnr-search-result-container #pnr_train_num").html(data.trainNum);
            $("#pnr-search-result-container #pnr_src_station_name").html(data.srcStationName);
            $("#pnr-search-result-container #pnr_src_station_code").html(data.srcStationCode);
            $("#pnr-search-result-container #pnr_status").html("Confirmed");
            $("#pnr-search-result-container #pnr_train_name").html(data.trainName);
            $("#pnr-search-result-container #pnr_dest_station_name").html(data.destStationName);
            $("#pnr-search-result-container #pnr_dest_station_code").html(data.destStationCode);
            $("#pnr-search-result-container #pnr_seat").html("B2 45");
            $("#pnr-search-result-container .right-arrow-icon__pnr_result").removeClass("hidden");
          } else {
            Pnr.clearPnrResultWithThisMessage("PNR not found !");
          }
        } else {
          Pnr.clearPnrResultWithThisMessage("PNR not found !");
        }
      },
      error: function() {
        $(".pnr-type-ahead .horizontal-loader").addClass("hidden");
        Pnr.clearPnrResultWithThisMessage("Oops ! some server error occured");
      }
    });
  },
  clearPnrResultWithThisMessage: function(message) {

    $("#pnr-search-result-container #pnr_date").html("");
    $("#pnr-search-result-container #pnr_train_num").html("");
    $("#pnr-search-result-container #pnr_src_station_name").html("");
    $("#pnr-search-result-container #pnr_src_station_code").html("");
    $("#pnr-search-result-container #pnr_status").html("");
    $("#pnr-search-result-container #pnr_train_name").html("");
    $("#pnr-search-result-container #pnr_dest_station_name").html("");
    $("#pnr-search-result-container #pnr_dest_station_code").html("");
    $("#pnr-search-result-container #pnr_seat").html("");
    $("#pnr-search-result-container #pnr_result_message_any").html(message);
    $("#pnr-search-result-container #pnr_result_message_any").removeClass("hidden");
    $("#pnr-search-result-container .right-arrow-icon__pnr_result").addClass("hidden");
  },

  verifyAndSubmitPNR: function(button) {
    var pnrNumber = $("#pnr_number").val();
    $.ajax({
      cache: false,
      dataType: 'json',
      url: BASE_PATH + '/getPnrDetail/' + pnrNumber,
      method: 'GET',
      beforeSend: function() {
        $(button).button('loading');
      },
      success: function(data) {
        $(button).button('reset');
        if (data && data.status) {
          if (data.status === true) {
            $('#pnr-search-form').submit();
          } else {
            Pnr.showPNRTypehead(false);
            Pnr.clearPnrResultWithThisMessage("PNR not found !");
          }
        } else {
          Pnr.showPNRTypehead(false);
          Pnr.clearPnrResultWithThisMessage("PNR not found !");
        }
      },
      error: function() {
        Pnr.showPNRTypehead(false);
        Pnr.clearPnrResultWithThisMessage("Oops ! some server error occured");
        $(button).button('reset');
      }
    });
  },

  bindUIActions: function() {

    $('body').on('click', Auth.settings.pnrInput, function(event) {
      if ($(this).val().length === 10) {
        Pnr.showPNRTypehead(true);
      } else {
        Pnr.removePNRTypehead();
      }
    });


    $('body').on('click', Auth.settings.pnrSubmit, function(event) {
      event.preventDefault();
      Pnr.settings.pnrTypeHead.css({
        'box-shadow': 'none'
      });
      Pnr.verifyAndSubmitPNR($(this));
    });
  }
};


$(document).ready(function() {

  Pnr.init();

});