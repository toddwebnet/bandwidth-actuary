<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
    <title>Bandwidth Actuary</title>
</head>
<body>
<div class="jumbotron">
    <h1 class="display-4">Bandwidth Actuary</h1>


</div>


<div class="container">
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th style="padding-left: 25px">
                    {{ number_format($percent,0) }}%
                </th>
                @foreach($days as $day)
                    <th>{{ $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT) }}</th>
                @endforeach
            </tr>
            </thead>
            @foreach($data as $row)
                <tr>
                    <td><b>{{ $row['hostname'] }}</b></td>
                    @foreach($days as $day)
                        <td>{{ number_format($row['days'][$day], 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>

    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="/js/Chart.bundle.min.js"></script>
<script src="/js/chartjs-plugin-annotation.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>
