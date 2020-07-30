<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxM_a3Zktq6XKJtYb7NVpqrdJJVFgOYkU&callback=initMap"
      key="AIzaSyAxM_a3Zktq6XKJtYb7NVpqrdJJVFgOYkU"
    ></script>
    <title>Consulta Pontos próximos</title>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
    </style>
    <script>
      "use strict";

      let map;

      function initMap() {

        <?php 

          if(isset($resultados)) {
            $ponto_string = "";
            $ponto_ordem = 1;
            $first_result = false;

            foreach($resultados as $ponto) {

                if(!$first_result) {
                  $first_result = "{lat: ".$ponto->latitude.", lng: ".$ponto->longitude."}";
                }

                $ponto_string .= "['".$ponto->nome_fantasia."', ".$ponto->latitude.", ".$ponto->longitude.", ".$ponto_ordem."],";
                $ponto_ordem++;
            }

            // remove último caractere
            $ponto_string = substr($ponto_string, 0, -1);
            echo "var pontos = [".$ponto_string."];";
          }

          ?>

        map = new google.maps.Map(document.getElementById("map"), {
          center: <?php echo $first_result; ?>,
          zoom: 8
        });

        setMarkers(map, pontos);

      }

      

      function setMarkers(map, beaches) {

        for (var i = 0; i < beaches.length; i++) {
          var beach = beaches[i];
          var marker = new google.maps.Marker({
            position: {lat: beach[1], lng: beach[2]},
            map: map,
            title: beach[0],
            zIndex: beach[3]
          });
        }
      }
    </script>
  </head>
  <body>