let token = "44fde4e4c9f84d478ba8f8d053f068c9"

$.ajax({
    method: "GET",
    url: "https://api.weatherbit.io/v2.0/current",
    data: {
        city: "LosAngeles",
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

function display(results){
    $("#top").html(`<p>Today's weather in Los Angeles: ${results.data[0].temp}° ${results.data[0].weather.description}. Feels like ${results.data[0].app_temp}°</p>`)
}