<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insurance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PracticeApplication;
use App\Models\CoordinatorApplication;
use App\Models\Practice;
use App\Rules\OldPasswordRule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:read_user'])->only('index');
        $this->middleware(['permission:create_user'])->only('create', 'store');
        $this->middleware(['permission:update_user'])->only('update', 'edit');
        $this->middleware(['permission:delete_user'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $practices = Practice::all();
        if (Auth::user()->can('crud_user')) {
            $users = User::with('roles', 'practice')->get();
        } else {
            $users = User::with('practice')->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'super-admin');
            })->get();
        }


        return view('user.index', compact('users', 'practices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = '';
        $practices = Practice::all();
        if (Auth::user()->can('crud_super_admin')) {
            $roles = Role::all();
        } elseif (Auth::user()->can('crud_admin')) {
            $roles = Role::where('name', '!=', 'super-admin')->get();
        } else {
            abort('403', 'You do not have right role or permission to perform this action');
        }
        return view('user.create', compact('roles', 'practices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'user_name' => ['required', 'string', 'min:3', 'max:50', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'practice_id' => ['required'],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'contact_no' => ['nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_name' => ['required'],
        ]);

        $data['slug'] = Str::slug($request->user_name);
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        if ($request->role_name == "super-admin" && Auth::user()->can('crud_super_admin')) {
            $user->assignRole('super-admin');
        } elseif ($request->role_name == "admin" && Auth::user()->can('crud_admin')) {
            $user->assignRole('admin');
        } else {
            $user->assignRole($request->role_name);
        }

        return redirect()->route('user.index')->with('status', 'A new user has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = '';
        $practices = Practice::all();
        if (Auth::user()->can('crud_super_admin')) {
            $roles = Role::all();
        } elseif (Auth::user()->can('crud_admin')) {
            $roles = Role::where('name', '!=', 'super-admin')->get();
        } else {
            abort('403', 'You do not have right role or permission to perform this action');
        }

        return view('user.edit', compact('user', 'roles', 'practices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => ['required', 'min:3', 'max:30'],
            'last_name' => ['required', 'min:3', 'max:30'],
            'user_name' => ['required', 'min:3', 'max:30', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'practice_id' => ['required'],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'contact_no' => ['nullable'],
            'role_name' => ['required'],
        ]);
        $image_name = "default_user_image.jpg";
        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        if ($request->role_name == "super-admin" && Auth::user()->can('crud_super_admin')) {
            $user->assignRole('super-admin');
        } elseif ($request->role_name == "admin" && Auth::user()->can('crud_admin')) {
            $user->assignRole('admin');
        } else {
            $user->assignRole($request->input('role_name'));
        }


        return redirect()->route('user.index')->with('status', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->can('crud_user')) {
            $user->delete();
            return redirect()->route('user.index')->with('status', 'User has been removed');
        }
    }
    public function profile_edit(User $user)
    {
        return view('user.profile', compact('user'));
    }
    public function profile_update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => ['required', 'min:3', 'max:30'],
            'last_name' => ['required', 'min:3', 'max:30'],
            'user_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4048'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'contact_no' => ['nullable'],
        ]);
        $image_name = "default_user_image.jpg";
        if ($request->user_image != null) {
            $imageName = time() . '.' . $request->user_image->extension();
            $request->user_image->move(public_path('images/users/'), $imageName);
        }
        $user->update($data);
        return back()->with('status', 'User profile has been updated');
    }
    public function care_team()
    {
        $practice = Practice::findOrFail(auth()->user()->practice_id);
        $roles = Role::where('name', '!=', 'super-admin')
            ->where('name', '!=', 'admin')
            ->where('name', '!=', 'doctor')
            ->get();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super-admin');
            $query->where('name', '!=', 'admin');
            $query->where('name', '!=', 'doctor');
        })->where('practice_id', auth()->user()->practice_id)->get();

        return view('user.care-team', compact('practice', 'users', 'roles'));
    }
    public function care_team_store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'user_name' => ['required', 'string', 'min:3', 'max:50', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'contact_no' => ['nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_name' => ['required'],
        ]);
        $data['practice_id'] = auth()->user()->practice_id;
        $data['slug'] = Str::slug($request->user_name);
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        $user->assignRole($request->input('role_name'));

        return redirect()->route('care-team.index')->with('status', 'A New Team member has been added');
    }
    public function care_team_edit($id)
    {
        $user = User::findOrFail($id);
        return response($user);
    }
    public function care_team_update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'first_name' => ['required', 'min:3', 'max:30'],
            'last_name' => ['required', 'min:3', 'max:30'],
            'user_name' => ['required', 'min:3', 'max:30', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'contact_no' => ['nullable'],
        ]);
        $user->update($data);
        return redirect()->route('care-team.index')->with('status', 'A Team member has been updated');
    }
    public function change_password_index()
    {
        return view('user.password');
    }
    public function change_password_store(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new OldPasswordRule],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['same:password'],
        ]);
        $user = User::findOrFail(auth()->user()->id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect('home')->with('status', 'Your Password has changed');
    }
}
