@if(app('router')->is("export.index"))
    <div class="row">

        @if(isset($interferences) && $interferences)
            <div class="col-md-4">
                <div class="form-group">
                    <label for="interference">Interferência</label>
                    <div>
                        <select name="interference" class="select2 form-control" id="interference" data-placeholder="Interferência">
                            <option></option>
                            @foreach($interferences as $interference)
                                <option value="{{$interference->id}}" {{((app('request')->input('interference')==$interference->id) ? "selected":"")}}>{{$interference->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-4">
            <div class="form-group">
                <label for="export_dynamics">Exportar itens do formulário?</label>
                <div>
                    <select name="export_dynamics" class="select2 form-control" id="export_dynamics" data-placeholder="Exportar itens dinâmicos?">
                        <option value="0" {{((app('request')->input('export_dynamics')==0) ? "selected":"")}}>Não</option>
                        <option value="1" {{((app('request')->input('export_dynamics')==1) ? "selected":"")}}>Sim</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endif
