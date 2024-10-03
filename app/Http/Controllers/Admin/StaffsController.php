<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StaffsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('staffs')
                ->whereNull('staffs.deleted_at')
                ->leftJoin('roles', 'roles.id', '=', 'staffs.role_id')
                ->leftJoin('designation', 'designation.id', '=', 'staffs.designation_id')
                ->select('staffs.id','staffs.email','staffs.phone_number','staffs.status','staffs.name','staffs.employee_id','roles.title as roled','designation.name as des')
                ->get();
            // dd($query);
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'staffs_show';
                $editGate = 'staffs_edit';
                $deleteGate = 'staffs_delete';
                $editFunct = 'editStaffs';
                $viewFunct = 'viewStaffs';
                $deleteFunct = 'deleteStaffs';
                $crudRoutePart = 'Staffs';

                return view('partials.ajaxTableActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'editFunct',
                    'viewFunct',
                    'deleteFunct',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('employee_id', function ($row) {
                return $row->employee_id ? $row->employee_id : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->roled ? $row->roled : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });


            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });

            $table->editColumn('designation', function ($row) {
                return $row->des ? $row->des : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $role = Role::pluck('title', 'id');

        return view('admin.staffs.index', compact('role'));
    }
}
