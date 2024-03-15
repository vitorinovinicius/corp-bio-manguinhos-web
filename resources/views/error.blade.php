@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p>Alguns problemas forem encontrados nos campos</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li><i class="bx bx-remove"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
