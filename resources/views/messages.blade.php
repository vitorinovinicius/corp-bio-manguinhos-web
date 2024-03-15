@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center">
            <i class="bx bx-like"></i>
            <span>
                  <em> {!! session('message') !!}</em>
                </span>
        </div>
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center">
            <i class="bx bx-error"></i>
            <span>
                  <em>  {!! session('error') !!}</em>
                </span>
        </div>
    </div>
@endif