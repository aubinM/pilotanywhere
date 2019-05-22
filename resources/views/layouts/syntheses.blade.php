@extends('includes.all')

@section('content')


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Synthèse @if(isset($enregistrement->id)) {{$enregistrement->id}} @endif</h1>


</div>
<p><a href="{{route('enregistrements')}}" class="text-primary fas fa-arrow-left"> Retour aux enregistrements</a></p>



<div class="card-body">
    <div class="table ">
        <table class="table table-bordered table-hover table-sm "  >
            @php

            $matieres =array();

            foreach($enregistrement->materiel_origines as $materiel_o){

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
                foreach($enregistrement->materiel_origines as $materiel_o){
                echo '<td class="small font-weight-bold text-center">'.$materiel_o->name.'</td>';
                }
                @endphp
            </tr>
            <tr>
                <td>Vol début run</td>
                @foreach($enregistrement->materiel_origines as $materiel_o)
                <td>
                    {{$materiel_o->pivot->volume_debut}}
                </td>
                @endforeach
                <td class="bg-secondary"></td>

            </tr>
            <tr>
                <td>Vol fin run</td>
                @foreach($enregistrement->materiel_origines as $materiel_o)
                <td>
                    {{$materiel_o->pivot->volume_fin}}
                </td>
                @endforeach
                <td class="bg-secondary"></td>
            </tr>
            <tr>
                <td>Soutiré</td>
                @foreach($enregistrement->materiel_origines as $materiel_o)
                <td>
                    {{$materiel_o->pivot->volume_debut - $materiel_o->pivot->volume_fin }}
                </td>
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
                foreach($enregistrement->materiel_origines as $materiel_o){


                echo '<td class="small font-weight-bold text-center">'.$materiel_o->name.'</td>';

                }
                @endphp

            </tr>
            @foreach($enregistrement->materiel_destinations as $materiel_d)
            <tr>
                <td class="small">{{$materiel_d->name}}</td>
                @foreach($enregistrement->materiel_origines as $materiel_o)
                <td>
                    @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)
                    @if(($materiels->pivot->materiel_destination_id == $materiel_d->id) && ($materiels->pivot->materiel_origine_id == $materiel_o->id))
                    {{$materiels->pivot->volume}}
                    @endif
                    @endforeach
                </td>
                @endforeach

                <td>
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

                <td class="small">Total</td>
                @foreach($enregistrement->materiel_origines as $materiel_o)
                <td>
                    @php $total_origines = 0; @endphp
                    @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)
                    @if($materiels->pivot->materiel_origine_id == $materiel_o->id)
                    @php $total_origines = $total_origines + $materiels->pivot->volume @endphp
                    @endif

                    @endforeach
                    {{$total_origines!=0 ? $total_origines : ""}}
                </td>
                @endforeach
                <td>
                    @php $total_global = 0; @endphp


                    @foreach($enregistrement->materiel_destinations_materiel_origines as $materiels)
                    @php $total_global = $total_global + $materiels->pivot->volume @endphp
                    @endforeach


                    {{$total_global!=0 ? $total_global : ""}}



                </td>
            </tr>




        </table>
    </div>
</div>

@endsection