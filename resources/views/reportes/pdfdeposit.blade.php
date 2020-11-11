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
        body
        {
            font-family: Arial, Helvetica, sans-serif;;
            line-height: 1.25;
        }
        img{
            width: 40%;
            position: absolute;
        }
        h3{
            text-align: center;
            margin-left: 230px;
            color: #000000;
        }
        .span1{
            margin-left: 420px;
        }

        .header {
            position: fixed;
            width: 100%;
            height: 120px;
            text-align:center;
            opacity: 0.5;
        }

        #titulo{
            text-align: center;
            margin:60px;
        }
        table {
            border: 1px solid rgb(19, 18, 18);
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
          }

          table tr {
            border: 1px solid rgb(19, 18, 18);
            padding: .35em;
          }

          table th,
          table td {
            padding: .625em;
            border: 1px solid rgb(19, 18, 18);
            text-align: center;
          }

          table th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
            background-color: #11505d;
            color: #fff;
          }

    </style>
    <!-- Creating a SVG image -->

    <img src="vendor/adminlte/dist/img/LogoColor.png" alt="logoende">
        <h3>Ende Andina S.A.M.</h3>

        <span class="span1">{{$now->format('d/m/Y')}}</span>

    <div class="header">
      </div>
      <h1 id="titulo">Depósito</h1>
          <table id="tabla">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Marca</th>
                    <th>Codigo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>

                @forelse($deposit as $item)
                <tr>

                    <td>{{$item->item}}</td>
                    <td>{{$item->Bname}}</td>
                    <td>{{$item->code}}</td>
                    <td>{{$item->state}}</td>
                    <td>{{$item->Dcreated}}</td>
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

