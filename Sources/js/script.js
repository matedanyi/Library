//Fantasy számláló sessionStorage panel/nyito záró alapján
/*
$(document).on('change', '[name="fantasy"]', function() {
    var checkbox = $(this), // Selected or current checkbox
        value = checkbox.val(); // Value of checkbox
    if (checkbox.is(':checked'))
    {
        if (sessionStorage.fantasy) {
          sessionStorage.fantasy = Number(sessionStorage.fantasy)+1;
        } else {
          sessionStorage.fantasy = 1;
    }
      console.log('checked');
      document.getElementById("fantasyResult").innerHTML = "Fantasy (" + sessionStorage.fantasy + ")";
    }
    else{
      console.log('not checked');
    }

});

$(document).ready(function(){
  sessionStorage.setItem("fantasy", "0");
  document.getElementById("fantasyResult").innerHTML = "Fantasy (" + sessionStorage.fantasy + ")";
});
*/
//Regény számláló sessionStorage
$(document).on('change', '[class="input_kategoria"]', function () {
  var checkbox = $(this), // Selected or current checkbox
    value = checkbox.val(); // Value of checkbox
  $('[for="' + checkbox.attr('name') + '"]');
  let label = $(this).next();


  if (checkbox.is(':checked')) {
    if (sessionStorage.getItem(checkbox.attr('name'))) {
      let ertek = Number(sessionStorage.getItem(checkbox.attr('name')));

      sessionStorage.setItem(checkbox.attr('name'), ertek + 1);
    } else {
      sessionStorage.setItem("label_" + checkbox.attr('name'), label.html());
      sessionStorage.setItem(checkbox.attr('name'), 1);
    }
    console.log('checked');

    let newLabel = sessionStorage.getItem("label_" + checkbox.attr('name'));
    newLabel += '(' + sessionStorage.getItem(checkbox.attr('name')) + ')';
    label.html(newLabel);


    /* checkbox name értéke alapján vissza kell keresni a label-t és módosítani a szöveg mögötti zárójelek közötti számot   (  KÉSZ VAN!!!)  A lenti az egyik megoldás. Fentebb is működik*/
    /*$('[for="' + checkbox.attr('name') + '"]');
    let label = $(this).next();
    let  labelArray = label.html().split("(");
    console.log(labelArray);
    let newLabel = labelArray[0] + '(' + sessionStorage.getItem(checkbox.attr('name')) + ')' ;


    console.log(label.html());
    console.log(checkbox.attr('name'));
    console.log(newLabel);
    label.html(newLabel);
    */
    /*("regenyResult").innerHTML = "Regény (" + sessionStorage.regeny + ")";*/
  }
  else {
    console.log('not checked');
  }

});

/*    $(document).ready(function(){
      sessionStorage.setItem("regeny", "0");
      document.getElementById("regenyResult").innerHTML = "Regény (" + sessionStorage.regeny + ")";
    });

    //Motivációs számláló sessionStorage
    $(document).on('change', '[name="motivacios"]', function() {
        var checkbox = $(this), // Selected or current checkbox
            value = checkbox.val(); // Value of checkbox
        if (checkbox.is(':checked'))
        {
            if (sessionStorage.motivacios) {
              sessionStorage.motivacios = Number(sessionStorage.motivacios)+1;
            } else {
              sessionStorage.motivacios = 1;
        }
          console.log('checked');
          document.getElementById("motivaciosResult").innerHTML = "Motivációs (" + sessionStorage.motivacios + ")";
        }
        else{
          console.log('not checked');
        }

    });

    $(document).ready(function(){
      sessionStorage.setItem("motivacios", "0");
      document.getElementById("motivaciosResult").innerHTML = "Motivációs (" + sessionStorage.motivacios + ")";
    });
*/

//panel nyitó/záró
$(document).ready(function () {
  if (localStorage.getItem("panel") == 'closed') {
    $('#kategoria').addClass("rejtett");
  }

  $('#panel-zaro').click(function () {
    $("#kategoria").animate({
      width: "0"
    }, 700, function () {
      $("#kategoria").addClass("rejtett");
    });

    localStorage.setItem("panel", "closed");

  });

  $('#panel-nyito').click(function () {
    $("#kategoria").removeClass("rejtett");
    $("#kategoria").animate({
      width: "25%"
    }, 700, function () {

      localStorage.setItem("panel", "opened");
    });
  });

  //kereső gomb rejtése
  $('#search').click(function () {
    $("#cancel").show();
  });

  $('#cancel').click(function () {
    $("#cancel").hide();
  });


  $('#search').click(function () {
    let str = $('input[name="search"]').val();

    $.ajax({
      method: "POST",
      url: "?library/searchBooks/",
      data: { 'title': str }
    })
      .done(function (msg) {
        $("#table-content").html(msg);
      });
  });

  $('#searchBar').keydown(function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      $('#search').trigger('click');
    }
  })


  $('#cancel').click(function () {
    $('input[name="search"]').val('');

    $.ajax({
      method: "POST",
      url: "?library/allBooks/",
      data: null
    })
      .done(function (msg) {
        $("#table-content").html(msg);
      });

  });

  $('.book-row').click(function () {
    let id = $(this).attr('book');
    $.ajax({
      method: "POST",
      url: "?library/detail",
      data: { 'book': id }
    })
      .done(function (msg) {
        $("#detail-view").html(msg);
      });
  });


  $('main').prepend("<img id='loading' style='width: 30%; z-index: 500; position: absolute; top: 200px; left: 700px;'  src='Sources/img/spinner.gif' />");
  let loading = $('#loading').hide();
  $(document).ajaxStart(function () {
    loading.show();
  }).ajaxStop(function () {
    loading.hide();
  });


  $(".category").click(function (event) {
    let id = event.target.id;
    console.log(id);
    // alert(id);
    // if (isNaN(id)) {
    //   console.log(id + " is not a number <br/>");
    // } else {
    //   console.log(id + " is a number <br/>");
    // }

    $.ajax({
      method: "POST",
      url: "?library/searchCategories/",
      data: { 'cat': id }
    })
      .done(function (msg) {
        console.log(msg)
        $("#table-content").html(msg);
      });

  });



});
