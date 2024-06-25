@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('email_setting_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.email-settings.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.emailSetting.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'EmailSetting', 'route' => 'admin.email-settings.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.emailSetting.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-EmailSetting">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.host_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.user_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.password') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.smtp_secure') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.port_no') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.from') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.to') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.cc') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.emailSetting.fields.bcc') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emailSettings as $key => $emailSetting)
                                    <tr data-entry-id="{{ $emailSetting->id }}">
                                        <td>
                                            {{ $emailSetting->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->host_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->user_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->password ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->smtp_secure ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->port_no ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->from ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->to ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->cc ?? '' }}
                                        </td>
                                        <td>
                                            {{ $emailSetting->bcc ?? '' }}
                                        </td>
                                        <td>
                                            @can('email_setting_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.email-settings.show', $emailSetting->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('email_setting_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.email-settings.edit', $emailSetting->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('email_setting_delete')
                                                <form action="{{ route('frontend.email-settings.destroy', $emailSetting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('email_setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.email-settings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-EmailSetting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection