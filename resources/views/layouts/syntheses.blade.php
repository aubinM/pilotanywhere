@extends('includes.all')

@section('content')


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Synthèse @if(isset($enregistrement->id)) {{$enregistrement->id}} @endif</h1>
</div>



<nav aria-label="Page navigation example">


    <ul class="pagination justify-content-center">


        @if($enregistrement->id-1 < 1)
        <li class="page-item disabled" style="list-style-type: none;">
            @else 
        <li class="page-item" style="list-style-type: none;">
            @endif
            <a class="page-link" href="{{$enregistrement->id-1 > 0 ? route('syntheses.show', $enregistrement->id-1) : ""}}" aria-label="Previous">
                <span aria-hidden="true">Précédent</span>

            </a>
        </li>


        @if($enregistrement->id+1 > $enregistrement_last_id)
        <li class="page-item disabled" style="list-style-type: none;">
            @else 
        <li class="page-item" style="list-style-type: none;">
            @endif
            <a class="page-link" href="{{$enregistrement->id+1 <= $enregistrement_last_id ? route('syntheses.show', $enregistrement->id+1) : ""}}" aria-label="Next">
                <span aria-hidden="true">Suivant</span>

            </a>
        </li>
    </ul>


</nav>

<div class="card shadow mb-">

    <div class="card-body">
        <div class="table ">
            <table class="table table-bordered table-hover table-sm ">
                @php

                $matieres =array();

                foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o){

                array_push($matieres,$materiel_o->matiere->name);


                }

                $matieres_count=array_count_values($matieres);
                $matieres =  array_unique($matieres);

                @endphp

                <tr>
                    <th rowspan="2" class="small font-weight-bold text-center">Tanks</th>
                    @php
                    foreach($matieres as $matiere){
                    echo '<th colspan="'.$matieres_count[$matiere].'" class="small font-weight-bold text-center">'.$matiere.'</th>';
                    }
                    @endphp
                    <th class="small font-weight-bold text-center">Total</th>

                </tr>

                <tr>
                    @php
                    foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o){
                    echo '<td class="small font-weight-bold text-center ">'.$materiel_o->name.'</td>';
                    }
                    @endphp
                    <td class="bg-secondary"></td>
                </tr>
                <tr>
                    <td class="small font-weight-bold text-center">Vol début run</td>
                    @foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o)
                    @php $exist = 0; @endphp
                    @foreach($enregistrement->materiel_origines as $materiel_o2)
                    @if($materiel_o->name == $materiel_o2->name)
                    <td class="text-center">
                        {{$materiel_o2->pivot->volume_debut}}
                        @php $exist = 1; @endphp
                    </td>
                    @endif
                    @endforeach

                    @if($exist == 0)
                    <td></td>
                    @endif

                    @endforeach
                    <td class="bg-secondary"></td>

                </tr>
                <tr>
                    <td class="small font-weight-bold text-center">Vol fin run</td>
                    @foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o)
                    @php $exist = 0; @endphp
                    @foreach($enregistrement->materiel_origines as $materiel_o2)
                    @if($materiel_o->name == $materiel_o2->name)
                    <td class="text-center">
                        {{$materiel_o2->pivot->volume_fin}}
                        @php $exist = 1; @endphp
                    </td>
                    @endif
                    @endforeach

                    @if($exist == 0)
                    <td></td>
                    @endif

                    @endforeach
                    <td class="bg-secondary"></td>
                </tr>
                <tr>
                    <td class="small font-weight-bold text-center">Soutiré</td>
                    @foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o)
                    @php $exist = 0; @endphp
                    @foreach($enregistrement->materiel_origines as $materiel_o2)
                    @if($materiel_o->name == $materiel_o2->name)
                    <td class="text-center">
                        {{$materiel_o2->pivot->volume_debut - $materiel_o2->pivot->volume_fin}}
                        @php $exist = 1; @endphp
                    </td>
                    @endif
                    @endforeach

                    @if($exist == 0)
                    <td></td>
                    @endif

                    @endforeach
                    <td class="bg-secondary"></td>

                </tr>

                <tr class="blank_row select-row">
                    <td colspan="1000">&nbsp;</td>
                </tr>



                <tr>
                    <th rowspan="2" class="small font-weight-bold text-center">Tanks</th>
                    @php
                    foreach($matieres as $matiere){
                    echo '<th colspan="'.$matieres_count[$matiere].'" class="small font-weight-bold text-center">'.$matiere.'</th>';
                    }
                    @endphp
                    <th class="small font-weight-bold text-center">Total</th>

                </tr>

                <tr>

                    @php
                    foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o){


                    echo '<td class="small font-weight-bold text-center">'.$materiel_o->name.'</td>';
                    

                    }
                    @endphp
                    <td class="bg-secondary"></td>

                </tr>
                @foreach($enregistrement->materiel_autonome->materiel_destination as $materiel_d)

                <tr>
                    <td class="small font-weight-bold text-center">{{$materiel_d->name}}</td>
                    @foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o)
                    @php $exist = 0; @endphp

                    @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)

                    @if(($materiels->pivot->materiel_destination_id == $materiel_d->id) && ($materiels->pivot->materiel_origine_id == $materiel_o->id))
                    <td class=" text-center">{{$materiels->pivot->volume}}</td>
                    @php $exist = 1; @endphp

                    @endif

                    @endforeach

                    @if($exist == 0)
                    <td></td>
                    @endif

                    @endforeach

                    <td class="text-center">
                        @php $total_destinations = 0; @endphp
                        @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)
                        @if($materiels->pivot->materiel_destination_id == $materiel_d->id)
                        @php $total_destinations = $total_destinations + $materiels->pivot->volume @endphp
                        @endif

                        @endforeach
                        {{$total_destinations!=0 ? $total_destinations : ""}}
                    </td>

                </tr>


                @endforeach
                <tr>

                    <td class="small font-weight-bold text-center">Total</td>
                    @foreach($enregistrement->materiel_autonome->materiel_origine as $materiel_o)
                    <td class="text-center">
                        @php $total_origines = 0; @endphp
                        @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)
                        @if($materiels->pivot->materiel_origine_id == $materiel_o->id)
                        @php $total_origines = $total_origines + $materiels->pivot->volume @endphp
                        @endif

                        @endforeach
                        {{$total_origines!=0 ? $total_origines : ""}}
                    </td>
                    @endforeach
                    <td class="text-center">
                        @php $total_global = 0; @endphp


                        @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)
                        @php $total_global = $total_global + $materiels->pivot->volume @endphp
                        @endforeach


                        {{$total_global!=0 ? $total_global : ""}}



                    </td>
                </tr>
                <tr class="blank_row select-row">
                    <td colspan="1000">&nbsp;</td>
                </tr>

                <tr>
                    <th colspan="2" class="small font-weight-bold text-center">Test recyclage</th>
                    <th colspan="2" class="small font-weight-bold text-center">{{$enregistrement->test_recyclage}} °C</th>
                </tr>





            </table>
        </div>
    </div>

</div>

@endsection