let token = "54fa06364eab1c8a4f2d7c89019b4865"
let head = "https://api.themoviedb.org/3"

window.onload = function() {
    let endpoint = `${head}/movie/now_playing?api_key=${token}&language=en-US&page=1`
    console.log(endpoint)
    let httpRequest = new XMLHttpRequest();
    httpRequest.open("GET", endpoint);
    httpRequest.send();
    httpRequest.onreadystatechange = function() {
        if(httpRequest.readyState == 4) {
            if(httpRequest.status == 200) {
                console.log(httpRequest.responseText);
                displayResults(httpRequest.responseText);
            }
            else {
                console.log(httpRequest.status);
            }
        }
    }
}

document.querySelector(".d-flex").onsubmit = function(event) {
    document.querySelector(".row").replaceChildren();
    event.preventDefault();
    console.log("Clicked")
    let userInput = document.querySelector("#search-box").value.trim();
        let endpoint = `${head}/search/movie?api_key=${token}&language=en-US&query=${userInput}&page=1&include_adult=false`
        console.log(endpoint)
        let httpRequest = new XMLHttpRequest();
        httpRequest.open("GET", endpoint);
        httpRequest.send();
        httpRequest.onreadystatechange = function() {
            if(httpRequest.readyState == 4) {
                if(httpRequest.status == 200) {
                    console.log(httpRequest.responseText)
                    displayResults(httpRequest.responseText)
                }
                else {
                    console.log(httpRequest.status)
                    if(httpRequest.status == 422){
                        alert("Please enter a search term")
                        location.reload();
                    }
                }
            }
        } 
}

function displayResults(responseText){
    let resultObject = JSON.parse(responseText)
    console.log(resultObject)
    if(resultObject.total_results == 0){
        document.querySelector(".row").innerHTML += "<p>No results found</p>";
    } else {
        let htmlString1 = `<p>Showing <strong>${resultObject.results.length}</strong> of <strong>${resultObject.total_results}</strong> result(s)</p>`
        document.querySelector(".row").innerHTML += htmlString1; 
        let htmlString2 = ""
        for(let i=0; i<resultObject.results.length; i++){
            let posterPath = "https://image.tmdb.org/t/p/w500" + resultObject.results[i].poster_path
            let voteAverage = resultObject.results[i].vote_average
            let voteCount = resultObject.results[i].vote_count
            let overview = resultObject.results[i].overview
            let title = resultObject.results[i].title
            let releaseDate = resultObject.results[i].release_date
    
            if(resultObject.results[i].poster_path == null){
                posterPath = "images/notavailable.jpg"
                console.log("TRUE")
            }
    
            if(overview.length > 200){
                overview = overview.substring(0,200)
                overview += "..."
            }
    
            htmlString2 = 
                `
                <div class="col col-6 col-md-4 col-lg-3">
                    <div class="col-container">
                        <img src="${posterPath}">
                        
                        <div class="overlay">
                            <p>Rating: ${voteAverage}</p>
                            <p>Number of Voters: ${voteCount}</p>
                            <p>${overview}</p>
                        </div>
                    </div>
                    <p>${title}</p>
                    <p>${releaseDate}</p>
                </div>
                `
            
            document.querySelector(".row").innerHTML += htmlString2;
        }
    }
}
