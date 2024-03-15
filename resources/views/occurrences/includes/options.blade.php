@if($occurrence->status == 2 )
    @if($occurrence->financial)
        <a href="{{route('financials.show',$occurrence->financial->uuid)}}" target="_blank" class="btn btn-icon btn-sm btn-warning" title="Interação administrativa"><i class="bx bx-check"></i></a>
    @else
        @is(['superuser','financeiro','regiao'])
        <a href="{{route('financials.create',$occurrence->uuid)}}" target="_blank" class="btn btn-icon btn-sm btn-primary" title="Aprovar OS"><i class="bx bx-check"></i></a>
        @endis
    @endif
@endif
<button type="button" class="btn btn-icon btn-sm btn-information" data-toggle="modal" data-target="#modal-information"
        data-nome-os="{{optional($occurrence->occurrence_type)->name}}"
        data-obs-empreiteira="{{ optional($occurrence->occurrence_data_basic)->obs_empreiteira }}"
        data-toggle="tooltip" title="Informações"
>
    <i class="bx bx-info-circle"></i>
</button>
@shield('occurrence.show')
<a href="{{ route('occurrences.show', $occurrence->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
@endshield
@shield('occurrence.edit')
<a href="{{ route('occurrences.edit', $occurrence->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
@endshield
