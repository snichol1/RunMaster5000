$('#buying_slider_min').change(function() {
    var min = $(this).val();
    var max = $('#buying_slider_max').val();
    
    if(min > max) {
      $('#buying_slider_max').val(min);
      $('.maxBuyingSlider').slider('refresh');  
    }
});

$('#buying_slider_max').change(function() {
    var min = $('#buying_slider_min').val();
    var max = $(this).val();
    
    if(min > max) {
      $('#buying_slider_min').val(max);
      $('.minBuyingSlider').slider('refresh');  
    }
});​