@if($move)
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                @if(!empty($move->check_in_lat)  AND !empty($move->check_in_long))
                    <div class="form-group col-md-12">
                        <div id="map" style="width: 100%;"></div>
                    </div>
                @endif
           </div>
        </div>
    </div>
@endif
