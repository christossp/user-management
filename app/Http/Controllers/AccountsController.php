<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Input;

use App\Account;

use Session;

class AccountsController extends Controller
{
	
	public function index(){
		
		$accounts = Account::all();
		
		return view('accounts.index', compact('accounts'));
		
	}
	
	public function create()
	{
		return view('accounts.create');
	}
	
	public function store()
	{
		
		$this->validate(request(),[
		
			'name' => 'required',
			'email' => 'required|unique:accounts',
			'password' => 'required',
			'type' => 'required'
		]);

		$post  = new Account;
		
		$post->name = request('name');
		
		$post->email = request('email');
		
		$post->password = Hash::make(request('password'));
		
		$post->type= request('type');
		
		$post->save();

		return redirect('/createaccount')->with('message','User created');
			
	}
	
	public function editshow($id)
	{
		$account = Account::find($id);
	
		return view('accounts.edit')->with('account', $account);
		
		//return redirect('/accounts')->with('message','User updated');;;
	}
	
	public function edit($id)
	{

		$this->validate(request(),[
		
			'name' => 'required',
			'email' => 'required',
			'type' => 'required'
		]);
		
		$account = Account::find($id);
		
		$account->name = request('name');
		$account->email = request('email');
		$account->type= request('type');
		
		if(request('password')){
			$account->password = Hash::make(request('password'));
		}

		$account->save();

		return redirect('/accounts')->with('message','User updated');
	}
	
	
	public function destroy($id)
	{
		$account = Account::find($id);
		
		$account->delete();
		
		return redirect('/accounts')->with('message','User deleted');;
	}
	
	public function adfetch(){
		
		return view('accounts.adfetch');
		
	}
	
	public function adfetchAjax(Request $request){
		
		
		$checkboxes = json_decode($request->checkboxes);
		
		$allEntries = $this->searchLdap($checkboxes);

		return response()->json(['users'=>$allEntries]); 
		

		
	}
	
	public function searchLdap($places)
	{
		
		$allEntries = [];
		
		$hostname="ldap://mtl-dc01.jssresearch.local";
		$ds=ldap_connect($hostname, 389);
		ldap_set_option ($ds, LDAP_OPT_REFERRALS, 0) or die('Unable to set LDAP opt referrals');
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
		
		if ($ds) {

			foreach($places as $place){
				
				
				$dn = 'OU=Users,' . $place . ',OU=MyBusiness,DC=JSSResearch,DC=local';

				if (!($ldapc=ldap_bind($ds,'cspiliotopoulos@jssresearch.com','cspil12345$'))) { 
					echo "<p>Error:" . ldap_error($ds) . "</p>"; 
					echo "<p>Error number:" . ldap_errno($ds) . "</p>"; 
					echo "<p>Error:" . ldap_err2str(ldap_errno($ds)) . "</p>"; 
					die;
				} else {
					
				}

				$attributes = array("cn",'l','mail');
				
				$filter = '(&(objectclass=user)(!(cn=Externals)))';

				$result = ldap_search($ds, $dn, $filter, $attributes);
				$info = ldap_get_entries($ds, $result);
				
				
				
				for ($i=0; $i < $info["count"]; $i++) {
					
					if(isset($info[$i]['mail'][0])){
						
						if(isset($info[$i]['l'][0])){
							$place = $info[$i]['l'][0];
						} else {
							$place = '';
						}
						
						$User = [];
						
						//query db to se if user is already stored
						$result = Account::where('email', $info[$i]['mail'][0])->get();
						
						if($result->isEmpty()){
							$stored = 'no';
						} else {
							$stored = 'yes';
						}
						
						$User = array('name'=>$info[$i]['cn'][0], 'email'=>$info[$i]['mail'][0], 'place'=>$place, 'stored'=>$stored);
						array_push($allEntries, $User);
					}
					
				}
				
	
			}
		
		
		} else{
			echo "<h4>Unable to connect to LDAP server</h4>";
		}

		ldap_unbind($ds);
		
		return $allEntries;
	}

	
	public function getLdapUsers(Request $request)
	{
		
		$checkboxes = Input::get('node');
		
		$users = $this->searchLdap($checkboxes);
		
		return view('accounts.adfetch', compact('users'));
	}
	
	public function storeAdUsers(Request $request)
	{
	
		$checkboxes = json_decode($request->checkboxes);
		
		$emails = [];
		
		foreach($checkboxes as $checkbox){
			
			$value = explode(':',$checkbox);
			
			$email = $value[0];
			$name =  $value[1];
			
			//ajax response
			$emails [] = $email;
			
			$result = Account::where('email', $email)->get();
			
			if($result->isEmpty()){
				
				$account = new Account;
				$account->name = $name;
				$account->email = $email;
				$account->password = '';
				$account->type = 'ad';
				$account->save();
				
				
			}
		}

		return response()->json(['users'=>$emails]); 
	}



}
