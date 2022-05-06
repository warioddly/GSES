<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\UserPosition;
use App\Models\UserSpeciality;
use App\Models\UserSpecialityNumber;
use App\Models\UserSpecialitySpecialityNumber;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            if ($request->query('searchText')) {
                $data
                    ->where('last_name', 'like', '%' . $request->query('searchText') . '%')
                    ->orWhere('name', 'like', '%' . $request->query('searchText') . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->query('searchText') . '%');
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(users.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('position', function (User $user) {
                    return $user->position()->value('title');
                })
                ->addColumn('roles', function (User $user) {
                    return view('security.users.index-roles', compact('user'));
                })
                ->addColumn('action', function (User $user) {
                    return AppHelper::indexActionBlade($user, 'security.users', 'user');
                })
                ->rawColumns(['roles', 'action'])
                ->toJson();
        }

        // $data = User::orderBy('id','DESC')->paginate(5);
        return view('security.users.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $userPositions = UserPosition::pluck('title', 'id')->all();
        $userSpecialities = UserSpeciality::pluck('title', 'id')->all();
        $userSpecialityNumbers = UserSpecialityNumber::pluck('title', 'id')->all();
        $userSpecialitySpecialityNumbers = UserSpecialitySpecialityNumber::select('speciality_id', 'speciality_number_id')->get();

        return view('security.users.create', compact('roles',
            'userPositions', 'userSpecialities', 'userSpecialityNumbers', 'userSpecialitySpecialityNumbers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'last_name' => 'required',
            'name' => 'required',
            'middle_name' => 'nullable',
            'position_id' => 'nullable',
            'speciality_id' => 'nullable',
            'speciality_number_id' => 'nullable',
            'academic_degrees' => 'nullable',
            'speciality_experience' => 'nullable',
            'expert_experience' => 'nullable',
            'certificate_file' => 'nullable',
            'certificate_file_id' => 'nullable',
            'certificate_valid' => 'nullable',
            'phone' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm-password',
            'confirm-password' => 'required|min:8|same:password',
            'roles' => 'required'
        ]);

        $input = $request->all();

        $input['certificate_file_id'] = AppHelper::saveDocument('certificate_file', 'users');

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('security.users.index')
            ->with('success', __('User created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('security.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $userPositions = UserPosition::pluck('title', 'id')->all();
        $userSpecialities = UserSpeciality::pluck('title', 'id')->all();
        $userSpecialityNumbers = UserSpecialityNumber::pluck('title', 'id')->all();
        $userSpecialitySpecialityNumbers = UserSpecialitySpecialityNumber::select('speciality_id', 'speciality_number_id')->get();
        $statuses = UserStatus::pluck('title','id')->all();

        return view('security.users.edit',
            compact('user', 'roles', 'userRole',
                'userPositions', 'userSpecialities', 'userSpecialityNumbers', 'userSpecialitySpecialityNumbers','statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'last_name' => 'required',
            'name' => 'required',
            'middle_name' => 'nullable',
            'position_id' => 'nullable',
            'speciality_id' => 'nullable',
            'speciality_number_id' => 'nullable',
            'academic_degrees' => 'nullable',
            'speciality_experience' => 'nullable',
            'expert_experience' => 'nullable',
            'certificate_file' => 'nullable',
            'certificate_file_id' => 'nullable',
            'certificate_valid' => 'nullable',
            'phone' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|same:confirm-password',
            'confirm-password' => 'nullable|min:8|same:password',
            'roles' => 'required',
            'status_id'=>'required'
        ]);

        $input = $request->all();

        // Upload file
        if (empty($input['certificate_file_id'])) {
            $input['certificate_file_id'] = AppHelper::saveDocument('certificate_file', 'users');
        }

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('security.users.index')
            ->with('success', __('User updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('security.users.index')
            ->with('success', __('User deleted successfully'));
    }

    public function updateProfile(Request $request)
    {
//        dd($request->all());
        $user = auth()->user();
        $user_id = $user->id;
        $request->validate([
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => "required|string|max:255|unique:users,email,$user_id",
            'phone' => 'nullable|string|max:255',
            'new_password'=>'nullable|string|min:6|max:255|confirmed',
            'new_password_confirmation'=>'nullable|required_if:new_password,text|string|max:255',
        ]);
        $data = $request->except('new_password', 'new_password_confirmation');
        if(!is_null($request->new_password)){
            $data['password'] = Hash::make($request->new_password);
        }
        $user->update($data);
        return redirect()->route('profile.show')
            ->with('success', __('Profile updated successfully'));
    }
}
