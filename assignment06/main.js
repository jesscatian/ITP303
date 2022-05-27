let token = "44fde4e4c9f84d478ba8f8d053f068c9"


let storedState = localStorage.getItem("state")
if(storedState){
    console.log(storedState)
    $("#state-input").find('option[value="' + storedState + '"]').attr("selected", "selected");
    apiCall(storedState)
}


function apiCall(state){
    $.ajax({
        method: "GET",
        url: "https://api.weatherbit.io/v2.0/current",
        data: {
            city: state,
            key: token,
            units: "I"
        }
    })
    .done(function(results){
        console.log(results)
        display(results)
    })
    .fail(function(results) {
        console.log("Error")
    })
}

function display(results){
    $("#results").html = ""
    $("#results").html(`${results.data[0].temp}° ${results.data[0].weather.description}. Feels like ${results.data[0].app_temp}°`)
}

$("#state-input").on("change", function(){
    console.log($("#state-input").val())
    state = $("#state-input").val()
    localStorage.setItem("state", state)
    apiCall(state)
})

$("#user-input").on("keypress", function(event){
    if ( event.which == 13 ) {
        let newItem = $("#user-input").val()
        $("#list").append(`<li><span class="box">☐</span>${newItem}</li>`)
        $("#user-input").val("")
     }
})

$("ul").on("click", ".box", function(event){
    event.stopPropagation()
    $($(this).parent()).fadeOut( "slow", function() {
      });
})

$("ul").on("click", "li", function(){
    if($(this).hasClass("clicked")){
        $(this).removeClass("clicked")
    } else {
        $(this).addClass("clicked")
    }
})

$("#plus").on("click", function(){
    $("#user-input").slideToggle()
})



