<?php

namespace App\Http\Controllers\Front\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Customers\Customer;
use App\Models\Customers\Repositories\CustomerRepository;
use App\Models\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthenticatesUsers {
        logout as performLogout;
    }

    private $customerRepo;

    /**
     * Create a new controller instance.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->middleware('auth');
        $this->customerRepo = $customerRepository;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getEnc = Crypt::decrypt($id);
        $getIdCustomer = $this->customerRepo->findCustomerById($getEnc);
        return view('front.accounts.edit', [
            'customer' => $getIdCustomer
        ]);
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
        $getEnc = Crypt::decrypt($id);
        $data = $request->except('_token','_method');
        $customer = $this->customerRepo->findCustomerById($getEnc);

        if($request->newPassword === "changePassword") {
            $request->validate([
                'password' => ['required', 'string', 'min:5', 'confirmed']
            ]);
            $getOldPassword = Hash::check($request->oldpassword, $customer->password);

            if($getOldPassword) {
                $customer->password = Hash::make($request->password);
                $customer->save();
                $this->performLogout($request);
                return redirect()->route('login')->with([
                    'status'    => 'success',
                    'notice'    => 'Well done!',
                    'message'   => 'Update Account successful!'
                ]);
            } else {
                return redirect()->route('accounts.edit', $id)->with([
                    'status'    => 'danger',
                    'notice'    => 'Oh snap!',
                    'message'   => "Your old password or new password something wrong"
                ]);
            }
        } else {
            $request->validate([
                'name'      => ['required', 'string', 'max:191'],
                'username'  => ['required', 'string', 'max:191'],
                'email'     => ['required', 'email', 'max:191']
            ]);

            $checkUsername = Customer::where('username', $request->username)->get();
            $checkEmail = Customer::where('email', $request->email)->get();
            if($checkUsername->count() != 1 || $checkEmail->count() != 1) {
                return redirect()->route('accounts.edit', $id)->with([
                    'status'    => 'danger',
                    'notice'    => 'Oh snap!',
                    'message'   => "Username/email has been used!"
                ]);
            }
            $getCheckPass = Hash::check($request->confirm_password, $customer->password);

            if($getCheckPass) {
                $customerRepo = new CustomerRepository($customer);
                if ($request->hasFile('image') && $request->file('image') instanceof UploadedFile) {
                    if(!empty($customer->image)) {
                        $customerRepo->deleteFile($customer->image);
                    }
                    $data['image'] = $this->customerRepo->saveCoverImage($request->file('image'));
                }
                $customerRepo->updateCustomer($data);
            } else {
                return redirect()->route('accounts.edit', $id)->with([
                    'status'    => 'danger',
                    'notice'    => 'Oh snap!',
                    'message'   => "Your Password Doesn't Match"
                ]);
            }
            
        }
        return redirect()->route('accounts.edit',$id)->with([
            'status'    => 'success',
            'notice'    => 'Well done!',
            'message'   => 'Update Account successful!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $getEnc = Crypt::decrypt($id);
        $getDataCustomer = $this->customerRepo->findCustomerById($getEnc);
        $getCheckPass = Hash::check($request->confirm_password, $getDataCustomer->password);
        $getCheckEmail = Customer::where('email', $getDataCustomer->email)->first();

        if($getCheckPass == true && !empty($getCheckEmail)) {
            $this->performLogout($request);
            $customer = new CustomerRepository($getDataCustomer);
            if(!empty($getDataCustomer->image) ) {
                $customer->deleteFile($getDataCustomer->image);
            }
            $customer->deleteCustomer();

            return redirect()->route('login')->with([
                'status'    => 'success',
                'notice'    => 'Well done!',
                'message'   => 'Destroy Account successful!'
            ]);;
        } else {
            return redirect()->route('accounts.edit', $id)->with([
                'status'    => 'danger',
                'notice'    => 'Oh snap!',
                'message'   => "Your Email/Password Doesn't Match"
            ]);;
        }
    }
}
