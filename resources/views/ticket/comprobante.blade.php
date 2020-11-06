<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante</title>
</head>
<style>
    body{
        font-family: -apple-system,BlinkMacSystemFont,"Segoe  UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      text-align: left;
  }
  .principal{
    width: 90%;
    border-radius: 5px;
    padding: 15px;
    margin-right: auto;
    margin-left: auto;
    display: flex;

  }
  .image{
    width: 30%;
    text-align:center;
    margin-top: auto;
    margin-bottom: auto;
    display: flex;

  }
  .title{
    text-align: center;
    margin-left: 40%;
    width: 70%;
    position: fixed;
  }
  .text-title{
    padding-bottom:0px;
  }
  .img-title{
    max-width:150px;
    max-height:80px;
  }
  .table{
    width:100%;
    padding:10px;
    margin-top: 20px;

  }
  .center{
    text-align:center;
  }
  .right{
    text-align:right;
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
    padding: .25em;
  }

  table th,
  table td {
    padding: .225em;
    border: 1px solid rgb(19, 18, 18);
  }

  .contenedor{
      width: 100%;
      padding: 1em;
  }
.firma{
    margin: 10px;
    padding: 10px;
    float: left;

}
 #fm1{
    width: 45%;
    text-align: center;
    line-height: 0;
}
 #fm2{
    width: 45%;
    text-align: center;
    line-height: 0;
}
#fm3{
    width: 45%;
    text-align: center;
    line-height: 0;
}
.firma1{
    margin-left: 30%;
    margin-right: 30%;
}

</style>
<body>
    <div class="principal">
      <div class="image">
        <img src="vendor/adminlte/dist/img/LogoColor.png" width="100%" alt="logoende">
      </div>
      <div class="title">
        <div><strong>Ende Andina S.A.M</strong></div>
        <div>Contacto@endeandina.bo</div>
        <div>Teléfono: 591-4 466 4001</div>
      </div>
    </div>
    <div class="principalT">
      <div style="width:100%;text-align:center;font-size:20px">
       <hr><div><strong>Comprobante de Almacén</strong></div><hr>
      </div>
    </div>
      <div style="width:80%">
        <div style="padding-top:7px;padding-left:20px;width:100%;">

          <div><strong>Entregado a:  </strong>{{$ticket[0]->responsable}}</div><br>
          <div><strong>Responsable:  </strong> {{$ticket[0]->Uname}}</div><br>

        </div>
      </div>
      <div style="width:80%">
        <div style="padding-top:7px;padding-left:20px;width:100%;">
            <div><strong>Fecha:</strong> {{$now->format('d/m/Y')}}</div><br>
            <div><strong>Código:  </strong>{{$ticket[0]->Tcode}}</div>

        </div>
      </div>
    <div class="">
        <h3 class="center"><u>Artículos </u></h3>
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="center">Item</th>
            <th class="center">Cantidad</th>
          </tr>
        </thead>
        <tbody>
            @forelse($ticket as $item)
          <tr>
            <td class="center">{{$item->Witem}} - {{$item->Wcode}}</td>
            <td class="right">{{$item->Tquantity}}</td>
            @empty
            <td class=" list-group-item border-0 ">
                No existen datos para mostrar
            </td>
            @endforelse
            </tr>
        </tbody>
      </table>

    </div>
<br><br><br>
<div class="contenedor">
    <div class="firma" id="fm1">
        <hr>
        <p>{{$ticket[0]->responsable}}</p>
    </div>
    <div class="firma" id="fm2">
        <hr>
        <p>{{$ticket[0]->Uname}}</p>
    </div>
</div><br><br><br><br><br>
<div class="firma1" id="fm3">
    <hr>
    <p>Encargado</p>
</div>

  </body>

</html>
