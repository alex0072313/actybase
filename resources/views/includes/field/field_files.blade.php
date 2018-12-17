<div class="form-group row">
    <label class="col-form-label col-md-3">{{ $label }}</label>
        <div class="col-md-9">

        <div class="fields_upload_widzet">
            @if(isset($files))
                <div class="m-b-10 f-s-10"><b class="text-inverse text-uppercase">Загруженные файлы:</b></div>
                <div class="files_list card">
                    <ul class="list-group list-group-flush">
                        @foreach($files as $file_id => $file)
                            <li class="list-group-item bg-grey-transparent-1 f-s-12 py-0 pr-0 d-flex justify-content-between">
                                <div class="name">{!! $file !!}</div>
                                <div class="btn-group shadow-none">
                                    <a href="{{ route('fields.rm_exist_file', $file_id) }}" class="btn btn-link btn-xs text-danger rm_exist"><i class="fas fa-fw fa-times"></i></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="file" multiple name="{{ $name }}[]" value="" class="form-control fileupload d-none">
            <button class="btn btn-green btn-xs">Добавить файл(ы)</button>
        </div>

    </div>
</div>
