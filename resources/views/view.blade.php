<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Compass Starter by Ariona, Rian</title>

		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

		<!-- Loading main css file -->
		<link rel="stylesheet" href="{{ asset('assets/style.css') }}">
		
		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>


	<body>
        <div id="overlay"></div>
		<div class="site-content">
			<div class="site-header">
				<div class="container">
					<a href="index.html" class="branding">
						<img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo">
						<div class="logo-type">
							<h1 class="site-title">Weather Information</h1>
							<small class="site-description">Here's Your Weather Information</small>
						</div>
					</a>

					<!-- Default snippet for navigation -->
					<div class="main-navigation">
						<button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
						<ul class="menu">
							<li class="menu-item current-menu-item"><a href="">Home</a></li>
						</ul> <!-- .menu -->
					</div> <!-- .main-navigation -->

					<div class="mobile-navigation"></div>

				</div>
			</div> <!-- .site-header -->

			<div class="hero" data-bg-image="{{ asset('assets/images/banner.png')}}">
				<div class="container">
					<div  class="form-col find-location">
						<input type="text" id="input-text" placeholder="Find your location...">
						<button  id="search-form" >Find</button>
                    </div>

				</div>
			</div>
			<div class="forecast-table">
				<div class="container">
					<div class="forecast-container">
						<div class="today forecast">
							<div class="forecast-header">
								<div class="day">Today</div>
								<div class="date"> @php
                                                echo date('l,d F Y', strtotime(now()));
                                                @endphp</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="location"><span id="city">{{$weather['name']}}</span> <span id="country">({{$weather['sys']['country']}})</span></div>
								<div class="degree">
									<div class="num"><span id="suhu">{{round($weather['main']['temp'])}}</span><sup>o</sup>C</div>
                                    <div class="num" id="icon"><img src="https://openweathermap.org/img/wn/{{$weather['weather'][0]['icon']}}@4x.png" id="icon" alt="" width="fit-contetnt"></div>
									
                                    <div class="forecast-icon">
                                        <div>
                                            <div class="" id="cloud">{{$weather['weather'][0]['main']}}</div>
                                            
                                            <span>
                                                <img src="https://cdn-icons-png.flaticon.com/512/7774/7774377.png" width="30px" alt="sunrise" >
                                                <span id="sunrise">
                                                @php
                                                echo date('H:i:s', $weather['sys']['sunrise']);
                                                @endphp
                                                </span>
                                            </span>
                                            <span>
                                                <img src="https://cdn-icons-png.flaticon.com/512/3233/3233728.png" width="30px" alt="sunset" >
                                                <span id="sunset">
                                                @php
                                                echo date('H:i:s', $weather['sys']['sunset']);
                                                @endphp
                                                </span>
                                            </span>
                                        </div>
                                        <span><img src="{{ asset('assets/images/icon-umberella.png') }}" alt="" id="humidity">{{round($weather['main']['humidity'])}}%</span>
                                        <span><img src="{{ asset('assets/images/icon-wind.png') }}" alt="" id="speed">{{($weather['wind']['speed'])}}km/h</span>
                                        <span><img src="{{ asset('assets/images/icon-compass.png') }}" alt="" id="arah">{{($weather['wind']['deg'])}}<sup>o</sup></span>
									</div>	
                                    
								</div>
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
			

			<footer class="site-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							
						</div>
						<div class="col-md-3 col-md-offset-1">
							<div class="social-links">
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-google-plus"></i></a>
								<a href="#"><i class="fa fa-pinterest"></i></a>
							</div>
						</div>
					</div>
				</div>
			</footer> <!-- .site-footer -->
		</div>
		
		<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugins.js') }}"></script>
		<script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            $(document).ready(function(){
                $('#search-form').click(function(event){
    event.preventDefault();
    let url="{{route('weather')}}";
    let location=$("#input-text").val();
    $("#overlay").css("display", "block");
    
    $.ajax({
        method: 'post',
        url: url,
        data:{
            location:location,
            _token: "{{ csrf_token() }}",
        },
        success: function(resp) {
            addToDiv(resp.data)
            $("#overlay").css("display", "none");
        },
        error: function() {
            $("#overlay").css("display", "none");
        }
    });
});

function addToDiv(resp){
    $("#city").html(resp.name)
    $("#country").html(resp.sys.country);
    $("#cloud").html(resp.weather[0].main);
    $("#suhu").html(resp.weather[0].temp);
    $("#icon").html('<img src="https://openweathermap.org/img/wn/'+resp.weather[0].icon+'@4x.png" id="icon" alt="" width="fit-contetnt">')
    // $("#sunrise").html();
    // $("#sunset").html()
    $("#humidity").html(resp.main.humidity+"%");
    $("#speed").html(resp.wind.speed+"km/h");
    $("#arah").html(resp.wind.deg+"<sup>o</sup>");

}


        });
        </script>
		
	</body>

</html>