<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cyborg/bootstrap.min.css" integrity="sha384-GKugkVcT8wqoh3M8z1lqHbU+g6j498/ZT/zuXbepz7Dc09/otQZxTimkEMTkRWHP" crossorigin="anonymous">
        <!-- JS, Popper.js, and jQuery -->

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

        <title>@yield('title')</title>

        <style>
            html, body {
                height:100%;
                background: white
            }
            .LogoIcon{
                max-height: 50px
            }
            .primary{
                color: #523DD7
            }
            h1,h2,h3{
                color:  #523DD7
            }

        </style>

    </head>
    <body>

        <div class='Master row justify-content-center py-4  h-100'>
            <div class='col-10'>
                <div class='row justify-content-betwen'>
                    <div class='col-6'>
                        <div class='row'>
                            <div class='col-auto'>
                                <img class=" LogoIcon mx-auto d-block" src="assets/images/logoIcon.png">
                            </div>
                            <div>
                                <h4 class='text-info text font-weight-bold'>
                                    @yield('pageTitle')
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class='col-6'>
                        <div class='row'>
                            <div class='col-4'>
                                <a href='/Evaluacion' class='text-light'>
                                    <button type="button" class="btn btn-info  w-100">
                                        Módulo evaluación
                                    </button>
                                </a>
                            </div>
                            <div class='col-4 text-info'>
                                <a href='/Compras' class='text-light'>
                                    <button type="button" class="btn btn-info  w-100">
                                        Módulo compras
                                    </button>
                                </a>
                            </div>
                            <div class='col-4 text-info'>
                                <a href='/Recomendador' class='text-light'>
                                    <button type="button" class="btn btn-info  w-100">
                                        Recomendador
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-10 primary'>
                @yield('content')
            </div>
        </div>
    </body>
</html>
