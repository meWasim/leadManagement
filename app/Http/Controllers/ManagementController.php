<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use App\Models\Country;
use App\Models\Operator;
use App\Models\User;
use App\Models\Service;
use App\Models\CompanyOperators;
use App\Models\UsersOperatorsServices;
use App\Http\Requests\UserOperator;
use App\Http\Requests\OperatorDisplayName;

class ManagementController extends Controller
{
    public function userManagement()
    {
        if (isset($_GET['date'])) {
          
            echo $_GET['date'];


        }

        return view('report.index');
    }

    public function revShareManagement()
    {
        if (isset($_GET['date'])) {
            echo $_GET['date'];
        }

        return view('management.revenue');
    }

    public function companyAssign()
    {
        if (isset($_GET['date'])) {
            echo $_GET['date'];
        }

        return view('report.index');
    }

    public function companyManagement()
    {
        if (\Auth::user()->can('Company Management')) {
            $companies = Company::orderby('id', 'DESC')->get();

            return view('management.list_company', compact('companies'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function addCompany()
    {
        $company = new Company();

        return view('management.add_company', compact('company'));
    }

    public function createCompany(Request $request)
    {
        $data = $request->all();

        $company = new Company();
        $company->name = $data['name'];
        $rules = $company->rules();
        $request->validate($rules);

        if ($company->save()) {
            Session::flash('success', 'Company created successfully!!');
        } else {
            Session::flash('error', 'Error, something is going wrong!!');
        }

        return redirect()->to('/management/company');
    }

    public function editCompany($id)
    {
        $company = Company::where('id', '=', $id)->first();

        return view('management.edit_company', compact('company'));
    }

    public function updateCompany(Request $request, $id)
    {
        $data = $request->all();
        $company = Company::where('id', '=', $id)->first();
        $company->name = $data['company'];

        if ($company->save()) {
            Session::flash('success', 'Company updated successfully!!');
        } else {
            Session::flash('error', 'Error, something is going wrong!!');
        }

        return redirect()->to('/management/company');
    }

    public function currencyManagement()
    {
        if (\Auth::user()->can('Currency Management')) {
            $countries = Country::orderby('country')->get();

            return view('management.list_currency', compact('countries'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function addCurrency()
    {
        $country = new Country();

        return view('management.add_currency', compact('country'));
    }

    public function createCountry(Request $request)
    {
        $data = $request->all();
        $country = new Country();
        $file = $request->file('flag');

        if (isset($file) && !empty($file)) {
            $flag = $file->getClientOriginalName();
            $new_flag = 'flag-' . strtolower($data['country']) . '.png';
            $file->storeAs('flags', $new_flag);
        } else {
            $new_flag = 'no-flag.png';
        }

        $country->country = $data['country'];
        $country->country_code = $data['country_code'];
        $country->currency_code = $data['currency_code'];
        $country->usd = $data['usd'];
        $country->flag = $new_flag;

        if ($country->save()) {
            Session::flash('success', 'Currency created successfully!!');
        } else {
            Session::flash('error', 'Currency created successfully!!');
        }

        return redirect()->to('/management/currency');
    }

    public function editCurrency($id)
    {
        $country = Country::where('id', '=', $id)->first();

        return view('management.edit_currency', compact('country'));
    }

    public function updateCountry(Request $request, $id)
    {
        $data = $request->all();
        $country = Country::where('id', '=', $id)->first();

        if (isset($file) && !empty($file)) {
            $flag = $file->getClientOriginalName();
            $new_flag = 'flag-' . strtolower($data['country']) . '.png';
            $file->storeAs('flags', $new_flag);
        } else {
            $new_flag = (isset($country['flag']) && !empty($country['flag'])) ? $country['flag'] : 'no-flag.png';
        }

        $country->country = $data['country'];
        $country->country_code = $data['country_code'];
        $country->currency_code = $data['currency_code'];
        $country->usd = $data['usd'];
        $country->flag = $new_flag;

        if ($country->save()) {
            Session::flash('success', 'Currency updated successfully!!');
        } else {
            Session::flash('error', 'Currency updated successfully!!');
        }

        return redirect()->to('/management/currency');
    }

    public function operatorManagement()
    {
        if (\Auth::user()->can('Operator Management')) {
            Session::forget('error');
            $operators = Operator::with('country', 'revenueshare', 'company_operators', 'account_manager')->get();
            // dd($operators[0]->account_manager->user->name);
            return view('report.operatorlist', compact('operators'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function editOperator($id)
    {
        $company = Company::where('id', '=', $id)->first();

        return view('management.edit_company', compact('company'));
    }

    public function update_operator(Request $request)
    {
        $res = [];
        $id = $request->operator_id;
        $status = $request->status;

        if ($status) {
            $msg = 'Category activated';
            Session::flash('success', 'Operator Updated successfully!!');
        } else {
            $msg = 'Category deactivated';
            Session::flash('error', 'Operator deactivated successfully!!');
        }

        $dtl = Operator::whereId($id)->first();

        $dtl->status = $status;

        if ($dtl->save()) {
            $res['status'] = true;
            $res['msg'] = $msg;
        } else {
            $res['status'] = false;
            $res['msg'] = 'Somthing went wrong, try again later';
        }

        echo json_encode($res);
    }
    public function showUserOperator($user_id)
    {
        $user = User::findOrFail($user_id);
        // $operators=null;
        $operators = Operator::Status(1)->get();
        // dd($operators[0]->services);
        $activeUserOperators = UsersOperatorsServices::select('id_operator', 'id_service')->GetOperaterServiceByUserId($user_id)->distinct()->get();
        $activeUserOperatorsArray = $activeUserOperators->pluck('id_operator')->toArray();
        $activeUserServicesByOperaterArray = $activeUserOperators->pluck('id_service')->toArray();
        // dd($activeUserServicesByOperaterArray);
        // $activeUserOperatorsArray=[];
        return view('users.users_operator', compact('user', 'operators', 'activeUserOperatorsArray', 'activeUserServicesByOperaterArray'));
    }
    public function userOperatorStore(UserOperator $request)
    {
        $data = [];
        $operators = $request->operators;
        $key = 0;
        $serviceIds = [];

        foreach ($operators as $operator) {
            $servicesName = 'services_' . $operator;
            $services = $request->$servicesName;

            if (isset($services) && !empty($services)) {
                foreach ($services as $service) {
                    $data[$key] = [
                        'user_id' => $request->user_id,
                        'id_operator' => $operator,
                        'id_service' => $service,
                    ];
                    array_push($serviceIds, $service);
                    $key++;
                 }
            }
        }

        $OperaterService = UsersOperatorsServices::GetOperaterServiceByUserId($request->user_id)->GetOperaterServiceByNotInServiceId($serviceIds)->delete();
        // dd($OperaterService);
        $status = UsersOperatorsServices::upsert($data, ['id'], ['user_id', 'id_operator', 'id_service',]);

        return redirect()->route('users')->with('success', __('User operator successfully updated!'));
    }

    public function operatorNameEdit($operator_id)
    {
        $operator = Operator::with('company_operators', 'account_manager')->FindOrFail($operator_id);
        $companys = Company::get();
        $users = User::where('type', '=', 'Account Manager')->get();

        return view('operator.editOperatorName', compact('operator','companys','users'));
    }

    public function operatorNameUpdate(OperatorDisplayName $request)
    {
        Operator::GetOperatorByOperatorId([$request->operator])->update(
            [
                'display_name' => $request->operatorName,
                // 'service_type'=>$request->service_type,
                'business_type' => $request->business_type,
                'vat' => $request->vat,
                'wht' => $request->wht,
                'miscTax' => $request->miscTax,
                'hostingCost' => $request->hostingCost,
                'content' => $request->content,
                'rnd' => $request->rnd,
                'bd' => $request->bd,
                'miscCost' => $request->miscCost,
                'marketCost' => $request->marketCost,
            ]
        );

        if(isset($request->company) && !empty($request->company)){
            $company = CompanyOperators::where('company_id', '=', $request->company)->where('operator_id', '=', $request->operator)->first();

            if(empty($company)){
                $operatorsArr[] = ['company_id' => $request->company, 'operator_id' => $request->operator];

                CompanyOperators::insert($operatorsArr);
            }
        }

        if(isset($request->manager) && !empty($request->manager)){
            $manager = UsersOperatorsServices::where('user_id', '=', $request->manager)->where('id_operator', '=', $request->operator)->first();

            if(empty($manager)){
                $services = Service::where('operator_id', '=', $request->operator)->get();

                $operatorsArr = array();

                foreach($services as $service){
                    $operatorsArr[] = ['user_id' => $request->manager, 'id_operator' => $request->operator, 'id_service' => $service->id_service];
                }

                UsersOperatorsServices::insert($operatorsArr);
            }
        }

        return redirect()->back()->with('success', __('Operator Details successfully updated!'));
    }
    
    public function projectManagement()
    {
        return view('management.project-management');
    }
}
 