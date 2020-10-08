<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
</head>
<body>
    <style>
        img{
            width: 40%;
            position: absolute;
        }
        h3{
            text-align: center;
            margin-left: 200px;
            color: #000000;
        }
        .span1{
            margin-left: 280px;
        }
        .span2{
            margin-left: 200px;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #beb9b9b0;
            color:#fff;
            z-index: 1000;
            height: 120px;
            overflow: hidden;
            -webkit-transition: height 0.3s;
            -moz-transition: height 0.3s;
            transition: height 0.3s;
            text-align:center;
            line-height:160px;
            opacity: 0.5;

        }
        #tabla{
            margin: auto;
            margin-top: 5%;
            border:1px solid;
        }
        #titulo{
            text-align: center;
            margin:60px;
        }
        th, td{
            border:1px solid;
            padding: 0.3em;
            width: 25%;
        }

    </style>
    <img src="vendor/adminlte/dist/img/LogoColor.png" alt="logoende">

        <h3>Ende Andina S.A.M.</h3>
        <span class="span1">02/10/2020 </span>
        <span class="span2">03:01 pm </span>
    <div class="header">
      </div>
      <h1 id="titulo">Tabla</h1>
      <p>Codigo</p>
      <p>Reserva</p>
      <table id="tabla">
        <thead>
            <tr>
                <th>Id</th>
                <th>Item</th>
                <th>Marca</th>
                <th>Codigo</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warehouse as $item)
            <tr>

                <td>{{$item->id}}</td>
                <td>{{$item->item}}</td>
                <td>{{$item->brand}}</td>
                <td>{{$item->code}}</td>
                <td>{{$item->quantity}}</td>
            @empty
            <td class=" list-group-item border-0 ">
                No existen datos para mostrar
            </td>
            @endforelse
            </tr>
        </tbody>

    </table>

</body>
</html>
