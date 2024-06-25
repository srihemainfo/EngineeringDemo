<div class="container">

    <div class="row gutters">
        {{-- {{ dd($list); }} --}}
        <div class="col" style="padding:0;">
            <div class="card h-100">
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('admin.patents.stu_update', ['user_name_id' => $student->user_name_id, 'name' => $student->name, 'id' => $stu_edit->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h5 class="mb-2 text-primary">Patents Details</h5>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                                <div class="form-group">
                                    <label for="title">Topic</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter Topic"
                                        value="{{ $stu_edit->title }}">
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-2"></div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                                <div class="form-group">
                                    <label for="remark">Remarks</label>
                                    <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remarks" rows="2"
                                        value="{{ $stu_edit->remark }}">{{ $stu_edit->remark }}</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="0">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    {{-- <button type="button" id="cancel" name="cancel"
                                        class="btn btn-secondary">Cancel</button> --}}
                                    <button type="submit" id="submit" name="submit" value="submit"
                                        class="btn btn-primary">{{ $stu_edit->add }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (count($list) > 0)
        <div class="row gutters mt-3 mb-3">
            <div class="col" style="padding:0;">
                <div class="card h-100">
                    @php
                        $user = auth()->user();

                        if ($user) {
                            // Get the user's ID
                            $userId = $user->id;
                            // dd($userId);
                            // You can also use the following equivalent syntax:
                            // $userId = auth()->id();

                            // $userId now contains the ID of the authenticated user
                        } else {
                            // User is not authenticated
                            // Handle accordingly
                        }
                    @endphp
                    <div class="card-body table-responsive">
                        <h5 class="mb-3 text-primary">Patent List</h5>
                        <table class="list_table">
                            <thead>
                                <tr>
                                    <th>
                                        Topic
                                    </th>
                                    <th>
                                        Remarks
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($list); $i++)
                                    <tr>
                                        <td>{{ $list[$i]->title }}</td>
                                        <td>{{ $list[$i]->remark }}</td>
                                        <td>
                                            @if ($userId == 1)
                                                @if ($list[$i]->status == '0')
                                                    <form method="POST"
                                                        action="{{ route('admin.patents.stu_updater', ['user_name_id' => $student->user_name_id, 'name' => $student->name, 'id' => $list[$i]->id]) }}"
                                                        enctype="multipart/form-data"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                                        @csrf
                                                        <button type="submit" name="accept" value="accept"
                                                            class="btn btn-success  ">Accept</button>
                                                    </form>

                                                    <form
                                                        action="{{ route('admin.patents.destroy', $list[$i]->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token"
                                                            value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn  btn-danger mt-2"
                                                            value="{{ 'Reject' }}">
                                                    </form>
                                                @endif

                                                @if ($list[$i]->status == '1')
                                                    <div class="p-2 Approved">
                                                        Approved </div>
                                                @endif
                                            @endif

                                            @if ($userId == $student->user_name_id)
                                                @if ($list[$i]->status == '0')
                                                    <div class="p-2 Pending">
                                                        Pending </div>
                                                @elseif ($list[$i]->status == '0')
                                                    <div class="p-2 Approved">
                                                        Approved</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('admin.patents.stu_updater', ['user_name_id' => $student->user_name_id, 'name' => $student->name, 'id' => $list[$i]->id]) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <button type="submit" id="updater" name="updater" value="updater"
                                                    class="btn Edit btn-info">Edit</button>
                                            </form>
                                            <form action="{{ route('admin.patents.destroy', $list[$i]->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn mt-2 btn-danger"
                                                    value="{{ trans('global.delete') }}">
                                            </form>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
