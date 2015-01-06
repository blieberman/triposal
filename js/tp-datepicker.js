jQuery(document).ready(function($) {
    $("#datepicker1").datepicker({
        numberOfMonths: 2,
        onSelect: function(selected) {
          $("#datepicker2").datepicker("option","minDate", selected)
        }
    });
    $("#datepicker2").datepicker({ 
        numberOfMonths: 2,
        onSelect: function(selected) {
           $("#datepicker1").datepicker("option","maxDate", selected)
        }
    });  
  });//]]>
  $(document).ready(function(){
});
