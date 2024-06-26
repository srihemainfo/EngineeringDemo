@extends('layouts.admin')
@section('content')
@can('email_setting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.email-settings.create') }}">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EmailSetting">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('email_setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.email-settings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.email-settings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'host_name', name: 'host_name' },
{ data: 'user_name', name: 'user_name' },
{ data: 'password', name: 'password' },
{ data: 'smtp_secure', name: 'smtp_secure' },
{ data: 'port_no', name: 'port_no' },
{ data: 'from', name: 'from' },
{ data: 'to', name: 'to' },
{ data: 'cc', name: 'cc' },
{ data: 'bcc', name: 'bcc' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-EmailSetting').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
