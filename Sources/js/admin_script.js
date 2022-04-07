$(document).ready(function(){


  $('a.delete_rec').click(function(event){
    let result = confirm('Biztosan törlöd?');

    if(result) {
      let table = $(this).attr("table");
      let id = $(this).attr("rec_id");

      location.href = "?library/delete"+table+"/"+table+"/"+id;
    }
  });

});
