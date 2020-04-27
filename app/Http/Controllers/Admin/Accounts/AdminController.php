<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Models\Employees\Requests\CreateEmployeeRequest;
use App\Models\Employees\Requests\UpdateEmployeeRequest;
use App\Models\Employees\Repositories\EmployeeRepository;
use App\Models\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;

use App\Http\Middleware\CustomRoleSpatie;
use App\Http\Controllers\Controller;
use App\Models\Employees\Employee;
use Illuminate\Http\Request;
use App\Models\Tools\UploadableTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use UploadableTrait;
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;

    /**
     * Admin Controller Constructor
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @return void
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository
    )
    {
        // Spatie ACL
        $this->middleware('permission:admin-list',['only' => ['index']]);
        $this->middleware('permission:admin-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);

        $this->employeeRepo = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeeRepo->listEmployees()->sortBy('name')->take(5);
        return view('admin.accounts.admin.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = CustomRoleSpatie::pluck('name', 'name')->all();
        return view('admin.accounts.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $data = $request->except('_token','_method');

        if ($request->hasFile('image') && $request->file('image') instanceof UploadedFile) {
            $data['image'] = $this->employeeRepo->saveCoverImage($request->file('image'));
        }
        $this->employeeRepo->createEmployee($data);

        return redirect()->route('admin.admin.index')->with([
            'status'    => 'success',
            'message'   => 'Create Admin successful!'
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = CustomRoleSpatie::pluck('name', 'name')->all();
        $employee = $this->employeeRepo->findEmployeeById($id);

        return view('admin.accounts.admin.edit',compact('employee','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        $employee = $this->employeeRepo->findEmployeeById($id);

        if($request->newPassword === "changePassword") {
            
            $request->validate([
                'password' => ['required', 'string', 'min:5', 'confirmed']
            ]);
            
            $employee->password = Hash::make($request->password);
            $employee->save();
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'email', 'max:191', 'unique:employees,email,'.$id],
                'role' => ['required']
            ]);
            $employeeRepo = new EmployeeRepository($employee);
            if ($request->hasFile('image') && $request->file('image') instanceof UploadedFile) {
                if(!empty($employee->image)) {
                    $employeeRepo->deleteFile($employee->image);
                }
                $data['image'] = $this->employeeRepo->saveCoverImage($request->file('image'));
            }
            $employeeRepo->updateEmployee($data);
            
        }
        return redirect()->route('admin.admin.edit', $id)->with([
            'status'    => 'success',
            'message'   => 'Update Account successful!'
        ]);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $users = $this->employeeRepo->findEmployeeById($id);
        $user = new EmployeeRepository($users);
        $message = '';
        if($request->user_action == 'block'){
            $users->is_active = false;
            $users->save();
            $message = 'User successfully blocked';
        } else if( $request->user_action == 'restore') {
            $users->is_active = true;
            $users->save();
            $message = 'User successfully restored';
        } else {
            if(!empty($users->image) ) {
                $user->deleteFile($users->image);
            }
            $message = 'User successfully destroy';
            $user->deleteEmployee();
        }

        return response()->json([
            'status'      => 'success',
            'message'     => $message,
            'user_status' => $users->is_active
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAccount($id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.accounts.admin.edit_account',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        $employee = $this->employeeRepo->findEmployeeById($id);

        if($request->newPassword === "changePassword") {
            $request->validate([
                'password' => ['required', 'string', 'min:5', 'confirmed']
            ]);
            $getOldPassword = Hash::check($request->oldpassword, $employee->password);

            if($getOldPassword) {
                $employee->password = Hash::make($request->password);
                $employee->save();
                return redirect()->route('admin.logout');
            } else {
                return redirect()->route('admin.edit.account', $id)->with([
                    'status'    => 'danger',
                    'message'   => "Your Password old password or new password something wrong"
                ]);
            }
            
            
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'email', 'max:191', 'unique:employees,email,'.$id]
            ]);
            $getCheckPass = Hash::check($request->confirm_password, $employee->password);

            if($getCheckPass) {
                $employeeRepo = new EmployeeRepository($employee);
                if ($request->hasFile('image') && $request->file('image') instanceof UploadedFile) {
                    if(!empty($employee->image)) {
                        $employeeRepo->deleteFile($employee->image);
                    }
                    $data['image'] = $this->employeeRepo->saveCoverImage($request->file('image'));
                }
                $employeeRepo->updateEmployee($data);
            } else {
                return redirect()->route('admin.edit.account', $id)->with([
                    'status'    => 'danger',
                    'message'   => "Your Password Doesn't Match"
                ]);
            }
            
        }
        return redirect()->route('admin.dashboard')->with([
            'status'    => 'success',
            'message'   => 'Update Account successful!'
        ]);
        
        
    }
}
