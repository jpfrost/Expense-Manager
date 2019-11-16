<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\UserRole;
use App\ExpenseCategory;
use App\Expense;

use Auth;
use Validator;
use Hash;

class MainController extends Controller
{
    function index(){
    	return view('pages.index');
    }

    function login(Request $request){
    	Auth::attempt($request->all());
    	return $this->getCurrentUser();
    	
    }

    function getUserRole(User $user){
    	$user->role = Role::find($user->role_id);
    	$user->role->access = UserRole::where('role_id',$user->role_id)->pluck('type');
    	return $user;
    }

    function getCurrentUser(){
    	if(Auth::check()){
    		return response()->json($this->getUserRole(Auth::user()),200);
    	}
    	return response()->json(['msg' => 'incorrect credentials'],205);
    }

    function logout(){
    	if(Auth::check()){
    		Auth::logout();
    		return response()->json('',200);
    	}
    	return response()->json(['msg' => 'Invalid Request'],205);
    }

    function getAllUsers(){
    	$users = User::all();
    	$users->map(function($user){
    		return $this->getUserRole($user);
    	});
    	return response()->json($users,200);	
    }

    function getAllRoles(){
    	return response()->json(Role::all(),200);
    }

    function saveAccount(Request $request){
    	
    	if($request->id != 0){
    		$user = User::find($request->id);
    	}else{
    		$user = new User;
    	}

    	$user->name = $request->name;
    	if($request->password != ''){
    		$user->password = bcrypt($request->password);
    	}
    	$user->email = $request->email;
    	$user->role_id = $request->role_id;
    	$user->save();

    	return response()->json($this->getUserRole($user),200);
    }

    function deleteAccount(Request $request){
    	return response()->json(User::destroy($request->id),200);
    }

    function getRoleAccess(Request $request){
    	return response()->json(UserRole::where('role_id',$request->id)->pluck('type'),200);
    }

    function saveRole(Request $request){
    	if($request->id != 0){
    		$role = Role::find($request->id);
    	}else{
    		$role = new Role;
    	}

    	$role->name = $request->name;
    	$role->save();

    	UserRole::where('role_id',$request->id)->delete();

    	foreach ($request->access as $key => $value) {
    		$userRole = new UserRole;
    		$userRole->role_id = $role->id;
    		$userRole->type = $value;
    		$userRole->save();
    	}

    	return response()->json($role,200);
    }

    function deleteRole(Request $request){
    	return response()->json(Role::destroy($request->id),200);
    }

    function getAllExpenses(){
    	return response()->json(ExpenseCategory::all(),200);
    }

    function saveExpense(Request $request){
    	if($request->id != 0){
    		$expense = ExpenseCategory::find($request->id);
    	}else{
    		$expense = new ExpenseCategory;
    	}

    	$expense->name = $request->name;
    	$expense->save();

    	return response()->json($expense,200);
    }

    function deleteExpense(Request $request){
    	return response()->json(ExpenseCategory::destroy($request->id),200);
    }

    function getAllUserExpenses(Request $request){
    	$userExpenses = Expense::all();
    	$userExpenses->map(function($expense){
    		$expense->category = ExpenseCategory::find($expense->expense_cat_id);
    		$expense->user = User::find($expense->user_id);
    	});

    	return response()->json($userExpenses,200);
    }

    function saveUserExpense(Request $request){
    	if($request->id != 0){
    		$expense = Expense::find($request->id);
    	}else{
    		$expense = new Expense;
    	}

    	$expense->user_id = Auth::user()->id;
    	$expense->amount = $request->amount;
    	$expense->expense_cat_id = $request->expense_cat_id;
    	$expense->save();

    	$expense->category = ExpenseCategory::find($expense->expense_cat_id);
		$expense->user = User::find($expense->user_id);

    	return response()->json($expense,200);
    }

    function getGraphData(){
    	$expenses = ExpenseCategory::all();
    	$expenses->map(function($expense){
    		$expense->total = Expense::where('expense_cat_id',$expense->id)->pluck('amount')->sum();
    	});

    	return response($expenses,200);
    }

    function changePassword(Request $request){
    	
    	if(Hash::check($request->password,Auth::user()->password)){

	    	$validate = [
				'newPassword' => 'same:reNewPassword',
			];

			$validator = Validator::make($request->all(), $validate);


	        if ($validator->fails()) {
	            return response()->json(['emsg' => $validator->getMessageBag()->toArray()],201);
	        }

	        Auth::user()->password = bcrypt($request->newPassword);
	        Auth::user()->save();

	        return response()->json(['msg' => 'Successfully Change password'],200);

        }else{
        	return response()->json(['emsg' => 'current password does not match'],201);
        }
    }

}