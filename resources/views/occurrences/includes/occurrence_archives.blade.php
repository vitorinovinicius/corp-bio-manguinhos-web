@if($occurrence->occurrence_archives->count())
    <div class="card">
        <div class="card-header">
            <h3 class="box-title">Anexos ({{$occurrence->occurrence_archives->count()}})</h3>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    @foreach($occurrence->occurrence_archives as $occurrenceArchives)
                        <div class="col-4">
                            <div class="form-group">
                                <form action="{{ route('occurrence_archives.destroy', $occurrenceArchives->uuid) }}" method="POST" style="padding-right:11px" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if($occurrenceArchives->getExtension()== 'mpeg' || $occurrenceArchives->getExtension() == 'ogg' || $occurrenceArchives->getExtension() == 'wav' || $occurrenceArchives->getExtension() == 'mp3')
                                        <a href="{{$occurrenceArchives->url}}" target="_blank" class="btn btn-sm btn-success"><i class="bx bx-download"></i> Download</a> |
                                        <button type="button" onclick="playAudio({{$occurrenceArchives->id}})" class="btn btn-sm btn-info">
                                            <i class="bx bx-play"></i> Play
                                        </button> -
                                        <button type="button" onclick="pauseAudio({{$occurrenceArchives->id}})" class="btn btn-sm btn-danger">
                                            <i class="bx bx-pause"></i> Pause
                                        </button> -
                                        <audio src="{{$occurrenceArchives->url}}" id="{{$occurrenceArchives->id}}">
                                            O seu navegador não suporta o elemento <code>audio</code>.
                                        </audio>
                                        <strong>{{ ($occurrenceArchives->name_original) }} </strong>
                                        @shield('occurrences.delete_anexos')
                                        <button type="submit" style="float:right; margin-top:3px" class="btn btn-xs btn-danger">
                                            <i class="bx bx-trash"></i></button>
                                        @endshield
                                    @else
                                        <a href="{{$occurrenceArchives->url}}" target="_blank" class="btn btn-sm btn-success"><i class="bx bx-download"></i> Download</a> |
                                        <strong>{{ ($occurrenceArchives->name_original) }} </strong>
                                        @shield('occurrences.delete_anexos')
                                        <button type="submit" style="float:right; margin-top:3px" class="btn btn-xs btn-danger">
                                            <i class="bx bx-trash"></i></button>
                                        @endshield
                                    @endif
                                </form>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
