<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\Customerphoneno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

     use RegistersUsers;
    

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [

    //         'phoneNo' => ['required', 'string', 'max:255'],
    //         'nic' => ['required', 'string', 'max:255'],
    //         //'email' => ['required', 'string', 'email', 'max:255'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    // protected function create(array $data)
    // {
    //     $customer = new Customer();
    //     $customerId = Customer::pluck('customerId')->last();
    //     // return Customers_phoneNo::create([
    //     //     'phoneNo' => $data['phoneNo'],
    //     //     'nic' => $data['nic'],
    //     //     'email' => $data['email'],
    //     //     'password' => Hash::make($data['password']),
    //     // ]);

    //     return Customer::create([
    //         'customerId' => $data['$customerId'],
    //         'fname' => $data['fname'],
    //         'lname' => $data['lname'],
    //         'no' => $data['no'],
    //         'street' => $data['street'],
    //         'city' => $data['city'],
    //     ]);
    

    // }

    public function register(Request $request){

        $validatedData = $request->validate([
            'fname' => 'required|max:225',
            'lname' => 'required|max:225',
            //'email' => 'required|email|max:225',
            'phoneNo' => 'required|max:10',
            'nic' => 'required|max:10',
            'no' => 'required|max:225',
            'street' => 'required|max:225',
            'city' => 'required|max:225',
            'password' => 'required|confirmed|max:225',
        ]);


        $customer = new Customer();
        $user = new User();
        $customerEx = new Customerphoneno();

        $customerId = Customer::pluck('customerId')->last();
        $customer->customerId =$customerId + 1;
        $customer->fname = $request['fname'];
        $customer->lname = $request['lname'];
        $customer->no = $request['no'];
        $customer->street = $request['street'];
        $customer->city = $request['city'];

        $userId = User::pluck('userId')->last();
        $user->userId = $userId + 1;
        $user->username = "customer";
        $user -> password = bcrypt(request('password'));

        
        

        $customerId = Customerphoneno::pluck('customerId')->last();
        $customerEx->customerId = $customerId + 1;
        $customerEx->phoneNo = $request['phoneNo'];
        $customerEx->nic = $request['nic'];
        $customerEx->email = $request['email'];  
        // $customerEx->userId = $userId + 1;
        $customerEx -> password = bcrypt(request('password'));
        
        $customer->save();
        $user->save();
        $customerEx->save();
        return redirect('userDashboard');  
    }
}
