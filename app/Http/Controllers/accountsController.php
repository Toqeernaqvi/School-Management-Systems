<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\accounts;

class accountsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = [
            'count_account' => accounts::latest()->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'settings.accounts', //view address
            'title'    => 'Table User'
        ];

        if ($request->ajax()) {
            $accounts = accounts::select('*')->orderByDesc('created_at');
            return Datatables::of($accounts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editUser"><i class=" fi-rr-edit"></i></div>';
                    $btn = $btn . ' <div data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteUser"><i class="fi-rr-trash"></i></div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.v_template', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)

    {
        accounts::create([
            'Title' => $request->title,
            'Description' => $request->description,

        ]);

        return response()->json(['success' => 'Accounts saved successfully!']);


        //  accounts::updateOrCreate(['id' => $request->account_id],
        //         [
        //          'Title' => $request->title,
        //          'Description' => $request->description,

        //         ]);        

        //return response()->json(['success'=>'Accounts saved successfully!']);
        //
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $accounts = accounts::find($id);
        return response()->json($accounts);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        accounts::find($id)->delete();

        return response()->json(['success' => 'Accounts deleted!']);
    }
}
