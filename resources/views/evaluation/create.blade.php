<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>OS </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<section class="container">

    <div class="col-md-12">
        <img src="" alt="" class="logo">
    </div>

    <div class="d-flex justify-content-center">

        <div class="col-md-8">
          @include('messages')
          @include('error')
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                  Avaliação do atendimento 
                </div>
                <div class="card-body">
                    <h5 class="card-title">OS: {{$occurrence->id}}</h5>
                    <h6>Técnico: {{$occurrence->operator->name}}</h6>

                    <hr>
                    <form class="form form-vertical" action="{{ route('evaluation.store') }}" method="POST">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="occurrence_id" value="{{$occurrence->id}}">
                      <input type="hidden" name="occurrence_uuid" value="{{$occurrence->uuid}}">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Avaliação do atendimento</label>
                          <div class="d-flex justify-content-start">
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="rate" value="1" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                 1
                                </label>
                              </div>
                              <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="rate" value="2" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  2
                                </label>
                              </div>
                              <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="rate" value="3" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  3
                                </label>
                              </div>
                              <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="rate" value="4" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  4
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="rate" value="5" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  5
                                </label>
                              </div>
                          </div>                          
                        </div>
                        <div class="form-group">
                            <label for="">Deixe um comentário</label>
                            <textarea class="form-control" name="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger float-right">Enviar</button>
                    </form>
                </div>
              </div>
        </div>
    </div>
</section>
</body>
</html>
