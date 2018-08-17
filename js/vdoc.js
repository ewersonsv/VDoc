$("input[name='doc']").on('blur', function(){
  var doc = $(this).val();
  $.get('./functions/filter.php?doc=' + doc,function(data){
    $('#doc').html(data);
  });
});
jQuery('.doc').keyup(function () { 
    this.value = this.value.replace(/[^0-9/.-]/g,'');
});
