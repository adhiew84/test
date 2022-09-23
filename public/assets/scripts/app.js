$('#search-form').click(function(event){
    event.preventDefault();
    let url="{{route('weather')}}";
    let location=$("#input-text").val();
    
    
    $.ajax({
        method: 'post',
        url: url,
        data:{
            location:location,
            _token: "{{ csrf_token() }}",
        },
        success: function(resp) {
            addToDiv(resp)
        },
        error: function() {
            
        }
    });
});

function addToDiv(resp){
    $("#city").html(resp.name)
    $("#country").html(resp.sys.country);
    $("#cloud").html();
    $("#suhu").html(resp.weather[0].temp);
    $("#icon").html('<img src="https://openweathermap.org/img/wn/'+resp.weather[0].icon+'@4x.png" id="icon" alt="" width="fit-contetnt">')
    // $("#sunrise").html();
    // $("#sunset").html()
    $("#humidity").html(resp.main.humidity+"%");
    $("#speed").html(resp.wind.speed+"km/h");
    $("#arah").html(resp.wind.deg+"<sup>o</sup>");

}