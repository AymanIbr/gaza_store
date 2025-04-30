<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <title>Api Products</title>

    <style>
        #weather-form {
            position: relative;
        }
        #weather-form i {
            position: absolute;
            right: 15px;
            top: 17px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center">Wether App</h2>

        <form onsubmit="getWeather(event)" class="w-50 mt-4 mx-auto" action="" id="weather-form">
            <input type="text" placeholder="Type city name .. " name="wether" class="form-control form-control-lg" id="wether">
            <i class="fas fa-spinner fa-spin"></i>
        </form>
        <h2 class="display-3 text-center" id="temp"></h2>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        function getWeather(e)
        {
            e.preventDefault();

            let city = document.querySelector("#weather-form input");

            let url = 'https://api.openweathermap.org/data/2.5/weather?q='+city.value+'&appid=75fdd5997be419abd4f865a6dfa6cb1e&units=metric';

            // console.log(url);
            // $.ajax({
            //     type: 'get'
            // })

            axios.get(url)
            .then((res) => {
                console.log(res.data.main.temp);
                document.querySelector("#temp").innerHTML = res.data.main.temp;
            }).catch((err) => {
                document.querySelector("#temp").innerHTML = city.value + ' not found';
            })

        }
    </script>

</body>

</html>
