@extends('adminlte::page')

@section('title', 'Almacen')


@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="colorfondo mb-0">You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script>
    Swal.fire(
  'Good job!',
  'You clicked the button!',
  'success'
)
</script>

@endsection
