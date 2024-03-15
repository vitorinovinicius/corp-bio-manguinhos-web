<div class="card">
    <div class="card-header">
        <h3 class="box-title">Interferências</h3>
        <a class="heading-elements-toggle">
            <i class="bx bx-dots-vertical font-medium-3"></i>
        </a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li>
                    <a data-action="collapse" class="rotate">
                        <i class="bx bx-chevron-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <label>Interferecia</label>
                    <div class="form-group">
                        @foreach ($interferences as $interference)
                            <div class="form-check">
                                <input class="form-check-input onchangeTipoUser cs_checkbox" id="interferences_{{$interference->id}}" name="interferences[]" type="checkbox" value="{{ $interference->id }}">
                                <label class="form-check-label cs_checkbox_label" for="interferences_{{$interference->id}}">
                                    {{ $interference->description }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>