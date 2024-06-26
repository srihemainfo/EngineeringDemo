@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Show Regulation
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.toolssyllabus-years.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.toolssyllabusYear.fields.id') }}
                            </th>
                            <td>
                                {{ $toolssyllabusYear->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Name
                            </th>
                            <td>
                                {{ $toolssyllabusYear->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.toolssyllabusYear.fields.year') }}
                            </th>
                            <td>
                                {{ $toolssyllabusYear->year }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Frame By
                            </th>
                            <td>
                                {{ $toolssyllabusYear->frame_by }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.toolssyllabus-years.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
