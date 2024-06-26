@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.task.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.tasks.update', [$task->id]) }}" enctype="multipart/form-data" onsubmit="return checkData(event)">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label class="required" for="name">{{ trans('cruds.task.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                            name="name" id="name" value="{{ old('name', $task->name) }}" required>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="due_date">{{ trans('cruds.task.fields.due_date') }}</label>
                        <input class="form-control date {{ $errors->has('due_date') ? 'is-invalid' : '' }}" type="text"
                            name="due_date" id="due_date" value="{{ old('due_date', $task->due_date) }}">
                        @if ($errors->has('due_date'))
                            <span class="text-danger">{{ $errors->first('due_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.due_date_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="description">{{ trans('cruds.task.fields.description') }}</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                            id="description">{{ old('description', $task->description) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.description_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="attachment">{{ trans('cruds.task.fields.attachment') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('attachment') ? 'is-invalid' : '' }}"
                            id="attachment-dropzone">
                        </div>
                        @if ($errors->has('attachment'))
                            <span class="text-danger">{{ $errors->first('attachment') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.attachment_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label class="required" for="status_id">{{ trans('cruds.task.fields.status') }}</label>
                        <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status_id" id="status_id" required>
                            @foreach ($statuses as $id => $entry)
                                <option value="{{ $id }}"
                                    {{ (old('status_id') ? old('status_id') : $task->status->id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $entry }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.status_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="tags">{{ trans('cruds.task.fields.tag') }}</label>
                        <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]"
                            id="tags" multiple>
                            @foreach ($tags as $id => $tag)
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('tags', [])) || $task->tags->contains($id) ? 'selected' : '' }}>
                                    {{ $tag }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('tags'))
                            <span class="text-danger">{{ $errors->first('tags') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.tag_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="role_id" class="required">{{ trans('cruds.task.fields.select_role') }}</label>
                        <select class="form-control select2" name="role_id" id="role_id" onchange="getUsers(this)">
                            @foreach ($roles as $id => $entry)
                                <option value="{{ $id }}" {{ $task->role_id == $id ? 'selected' : '' }}>
                                    {{ $entry }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role_id'))
                            <span class="text-danger">{{ $errors->first('role_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.assigned_to_helper') }}</span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="assigned_to_id" class="required">{{ trans('cruds.task.fields.assigned_to') }}</label>
                        <select class="form-control select2" name="assigned_to_id" id="assigned_to_id">
                            <option value="">Select To Assign</option>
                            @if (count($assigned_tos) > 0)
                                @foreach ($assigned_tos as $data)
                                    <option value="{{ $data->id }}" {{ $data->id == $task->assigned_to_id ? 'selected':'' }}>{{ $data->name }}
                                        {{ ($data->employID == null ? $data->register_no : '(' . $data->employID . ')') == null ? '' : '(' . $data->register_no . ')' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('assigned_to_id'))
                            <span class="text-danger">{{ $errors->first('assigned_to_id') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.task.fields.assigned_to_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.options.attachmentDropzone = {
            url: '{{ route('admin.tasks.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function(file, response) {
                $('form').find('input[name="attachment"]').remove()
                $('form').append('<input type="hidden" name="attachment" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="attachment"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($task) && $task->attachment)
                    var file = {!! json_encode($task->attachment) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="attachment" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        function getUsers(element) {
            if ($(element).val() != '') {
                $.ajax({
                    url: '{{ route('admin.tasks.get_users') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'role_id': $(element).val()
                    },
                    success: function(response) {

                        let data = response.data;
                        let status = response.status;

                        let options = '';
                        if (status == true) {
                            options += '<option value="">Select To Assign</option>';
                            let datalen = data.length;
                            let numb = '';
                            if (datalen > 0) {
                                for (let a = 0; a < datalen; a++) {
                                    if (data[a].register_no != null) {
                                        numb = ' (' + data[a].register_no + ')';
                                    } else if (data[a].employID != null) {
                                        numb = ' (' + data[a].employID + ')';
                                    }
                                    options += `<option value="${data[a].id}">${data[a].name} ${numb}</option>`;
                                }
                            }
                            $("#assigned_to_id").html(options);
                            $("#assigned_to_id").select2();

                        } else {
                            Swal.fire('', data, 'error');
                        }
                    }
                })
            } else {
                Swal.fire('', 'Please Select The Role', 'warning');
            }
        }

        function checkData(event) {

            if ($("#name").val() == '') {
                event.preventDefault();
                Swal.fire('', 'Please Fill The Task Name', 'error');
                return false;
            } else if ($("#role_id").val() == '') {
                event.preventDefault();
                Swal.fire('', 'Please Choose The Role', 'error');
                return false;
            } else if ($("#assigned_to_id").val() == '') {
                event.preventDefault();
                Swal.fire('', 'Please Assign The Task', 'error');
                return false;
            } else {
                return true;
            }
        }
    </script>
@endsection
