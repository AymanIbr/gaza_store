<x-layout title="Order Details">

    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Order # {{ $order->number }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <div id="map" style="height: 60vh"></div>





    @push('js')
        <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

        <script>
            var map, marker;
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('7862401d29b0df60ae22', {
                cluster: 'ap2',
                // private
                channelAuthorization:{
                    endpoint:"/broadcasting/auth",
                    headers: {
                        'X-CSRF-Token':"{{ csrf_token() }}"
                    }
                }
            });

            var channel = pusher.subscribe('deliveries');
            // private
            // var channel = pusher.subscribe('private-deliveries.{{ $order->id }}');

            channel.bind('location-updated', function(data) {
                marker.setPosition({
                    lat: Number(data.lat),
                    lng: Number(data.lng)
                })
            });
        </script>


        <script>
            // Initialize and add the map
            function initMap() {
                // The location of Delivery
                const location = {
                    lat: Number('{{ $order->delivery->lat }}'),
                    lng: Number('{{ $order->delivery->lng }}')
                };
                // The map, centered at Uluru
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: location,
                });
                // The marker, positioned at Uluru
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
            }

            window.initMap = initMap;
        </script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUvj0eUJ4F9Rwl761So-iy-M0z7OHrbHA&callback=initMap&v=weekly"
            defer></script>
    @endpush


</x-layout>
