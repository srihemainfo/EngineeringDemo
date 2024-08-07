@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.teachingStaff.title_singular') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.teaching-staffs.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ 'First Name' }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }} "
                        style="text-transform:uppercase;" type="text" name="name" id="name"
                        value="{{ old('name', '') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.teachingStaff.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="last_name">{{ 'Last Name' }}</label>
                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                        style="text-transform:uppercase;" type="text" name="last_name" id="name"
                        value="{{ old('last_name', '') }}">
                    @if ($errors->has('last_name'))
                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.teachingStaff.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="staff_code">{{ 'Staff Code' }}</label>
                    <input class="form-control {{ $errors->has('StaffCode') ? 'is-invalid' : '' }}" type="text"
                        name="StaffCode" id="name" value="{{ old('StaffCode', '') }}">
                    @if ($errors->has('StaffCode'))
                        <span class="text-danger">{{ $errors->first('StaffCode') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="department">{{ 'Department' }}</label>
                    <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }} "
                        name="Dept" id="Dept">
                        @forelse ($department as $id => $entry)
                            <option value="{{ $entry }}">{{ $entry }}</option>
                        @empty
                            <option value="">No Data Found</option>
                        @endforelse
                    </select>
                    @if ($errors->has('department'))
                        <span class="text-danger">{{ $errors->first('department') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="working_as_id">{{ 'Designation' }}</label>
                    <select class="form-control select2 {{ $errors->has('Designation') ? 'is-invalid' : '' }} "
                        name="Designation" id="working_as_id">
                        @foreach ($working_as as $id => $entry)
                            <option value="{{ $id }}">{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('Designation'))
                        <span class="text-danger">{{ $errors->first('Designation') }}</span>
                    @endif
                </div>
                @if ($shift)
                    <div class="form-group">
                        <label class="" for="shift">{{ 'Shift' }}</label>
                        {{-- <input class="form-control" type="text" id="shift" name="shift" value=""> --}}
                        <select class="form-control select2 {{ $errors->has('shift') ? 'is-invalid' : '' }} " name="shift"
                            id="shift">
                            <option value="">Select Shift</option>
                            @foreach ($shift as $id => $entry)
                                <option value="{{ $id }}" {{ old('shift') == $id ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('shift'))
                            <span class="text-danger">{{ $errors->first('shift') }}</span>
                        @endif
                    </div>
                @endif


                <div class="form-group">
                    <label for="doj" class="required">Date Of Joining</label>
                    <input type="text" id="doj" class="form-control date" name="doj"
                        placeholder="Enter Date Of Joining">
                </div>


                <div class="form-group">
                    <label class="required" for="phone">{{ 'Phone' }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }} " type="number"
                        name="phone" id="name" value="">
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ 'Email' }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="name" value="">
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
