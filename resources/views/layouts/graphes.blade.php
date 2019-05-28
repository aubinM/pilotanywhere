@extends('includes.all')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Graphe @if(isset($enregistrement->id)) {{$enregistrement->id}} @endif</h1>
</div>


@endsection