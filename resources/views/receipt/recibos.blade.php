<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>
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
  .title{
    width: 30%;
    text-align:center;
    margin-top: auto;
    margin-bottom: auto;
    display: flex;
    position: fixed;

  }
  .image{
    width: 30%;
    margin-left: 60%;
    text-align:center;
    margin-bottom: auto;
    display: flex;

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
      <div class="title">
       <h1>Recibo</h1>
      </div>
      <div class="image">
        <img src="vendor/adminlte/dist/img/LogoColor.png" width="100%" alt="logoende">
      </div>
    </div>
      <div style="width:80%" class="datos">
        <div style="padding-top:7px;padding-left:20px;width:100%;">
          <div><strong>Código:  </strong>{{$receipt[0]->Rcode}}</div>
          <div><strong>Entregado a:  </strong>{{$receipt[0]->responsable}}</div>
          <div><strong>Responsable:  </strong> {{$receipt[0]->Uname}}</div>
         <div><strong>Fecha de entrega:</strong> {{$receipt[0]->delivery_date->toDateString()}}</div>
         @if($receipt[0]->return_date!=null || $receipt[0]->return_date!="")
             <div><strong>Fecha de devolucion: </strong>{{$receipt[0]->return_date->toDateString()}}</div>
         @endif
        </div>
      </div>
    <div class="">
        <h3 class=""style="margin-left: 30px;"><u>Artículos Recibidos</u></h3>

            @foreach($receipt as $item)
                <ul>
                    <li> {{$item->itemCode}}</ol>
                </ul>


            @endforeach


    </div>
<br><br><br>
<div class="contenedor">
    <div class="firma" id="fm1">
        <hr>
        <p>{{$receipt[0]->responsable}}</p>
    </div>
    <div class="firma" id="fm2">
        <hr>
        <p>{{$receipt[0]->Uname}}</p>
    </div>
</div><br><br><br><br><br>
<div class="firma1" id="fm3">
    <hr>
    <p>Encargado</p>
</div>

  </body>

</html>
