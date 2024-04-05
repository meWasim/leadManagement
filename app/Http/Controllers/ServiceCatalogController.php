<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Operator;
use App\Models\Country;
use App\Models\User;
use App\Models\ScServices;
use App\Models\ScOperators;
use App\Models\ScServiceProgres;
use App\Models\ScServiceStatus;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceEditRequest;
use App\Mail\ServiceCatalogMail;
use App\Mail\ServiceCatalogUpdateMail;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;


class ServiceCatalogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function create()
    {
        if (\Auth::user()->can('Add New Service')) {
            $companys = Company::orderBy('name', 'ASC')->get();
            $countrys = Country::orderBy('country', 'ASC')->get();
            $operators = Operator::Status(1)->orderBy('operator_name', 'ASC')->get()->toArray();
            $ScOperators = ScOperators::get()->toArray();
            $notAllowuserTypes = array("Owner", "Super Admin", "Business Manager", "Admin", "BOD");
            $Users = User::Types($notAllowuserTypes)->Active()->get();
            // $merged = $operators->merge($ScOperators);
            // $operators = array_merge($operators,$ScOperators);
            // dd($result);
            Session::forget('error');
            return view('service.addService', compact('companys', 'countrys', 'operators', 'Users', 'ScOperators'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function store(ServiceRequest $request)
    {

        $channal = [
            $request->channelowap,
            $request->channeloussd,
            $request->channelosms,
            $request->channeloivr,
        ];
        $cycle = [
            'changeCycleDaily' => $request->changeCycleDaily,
            'changeCycleWeekly' => $request->changeCycleWeekly,
            'changeCycleMonthly' => $request->changeCycleMonthly,
        ];
        $service = [
            'country_id' => $request->country,
            'company_id' => $request->company,
            'operator_id' => $request->operator,
            'service_name' => $request->servicename,
            'aggregator_status' => $request->aggregratorPermission,
            'aggregator' => $request->aggregrator,
            'subkeyword' => $request->subkeyword,
            'short_code' => $request->short_code,
            'type' => $request->type,
            'channel' => serialize($channal),
            'cycle' => serialize($cycle),
            'freemium' => $request->freemiumDays,
            'service_price' => $request->service_price,
            'revenue_share' => (int)$request->revenueShare,
            'account_manager' => $request->account_manager,
            'pmo' => $request->pmo,
            'backend' => $request->backend,
        ];
        $user      = ScServices::create($service);

        $progress = ScServiceStatus::get();
        foreach ($progress as $progres) {
            // dd($request->$dute_date);
            if ($progres->id == 1) {
                $data = [
                    'id_service' => $user->id,
                    'id_service_status' => $progres->id,
                    'dute_date' => date("Y-m-d"),
                    'complete_due_date' => date("Y-m-d"),
                    'status' => 'complete',
                ];
            } else {
                $data = [
                    'id_service' => $user->id,
                    'id_service_status' => $progres->id,
                    'dute_date' => null,
                    'complete_due_date' => null,
                    'status' => 'pending',
                ];
            }


            $datas[] = $data;
        }
        ScServiceProgres::upsert($datas, ['id_service', 'id_service_status'], ['dute_date', 'complete_due_date', 'status',]);

        $accountManager = User::where('id', $request->account_manager)->first();
        $pmo = User::where('id', $request->pmo)->first();

        $detailsPMO = [
            'name' => $pmo->name,
            'service_name' => $request->servicename,
            'information' => "We inform you that your account has been added to the list of PMO users with the following services:"
        ];
        $detailsAccountManager = [
            'name' => $accountManager->name,
            'service_name' => $request->servicename,
            'information' => "We inform you that a new service has been added, here is the data:"
        ];
        // email account manager/
        Mail::to([$accountManager->email])->send(new ServiceCatalogMail($detailsAccountManager));

        // email pmo user
        Mail::to(['budinugrohomei6@gmail.com', 'budisetionugroho0001@gmail.com'])->send(new ServiceCatalogMail($detailsPMO));

        return redirect()->route('report.list')->with(
            'success',
            __('Service successfully create!')
        );
    }

    public function list(Request $request)
    {
        if (\Auth::user()->can('Service List')) {
            $countrys = Country::orderBy('country', 'ASC')->get();
            $operators = Operator::Status(1)->orderBy('operator_name', 'ASC')->get()->toArray();
            $ScOperators = ScOperators::get()->toArray();
            $notAllowuserTypes = array("Owner", "Super Admin", "Business Manager", "Admin", "BOD");
            $users = User::Types($notAllowuserTypes)->Active()->get();
            // $merged = $operators->merge($ScOperators);
            $operators = array_merge($operators, $ScOperators);
            $services = ScServices::orderBy('id', 'DESC');

            $countryId = $request->country;
            $operatorId = $request->operator;
            $account_managerId = $request->account_manager;
            $pmoId = $request->pmo;
            $backendId =  $request->backend;
            if ($request->filled('country')) {
                $services = $services->findByCountry($countryId);
            }
            if ($request->filled('operator')) {
                $services = $services->findByOperator($operatorId);
            }
            if ($request->filled('account_manager')) {
                $services = $services->findByAccountManager($account_managerId);
            }

            if ($request->filled('pmo')) {
                $services = $services->findByPmo($pmoId);
            }
            if ($request->filled('backend')) {
                $services = $services->findByBackend($backendId);
            }
            $services = $services->get();
            return view('service.list', compact('services', 'countrys', 'operators', 'users'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit($id)
    {
        $service = ScServices::FindOrFail($id);
        $companys = Company::orderBy('name', 'ASC')->get();
        $countrys = Country::orderBy('country', 'ASC')->get();
        $operators = Operator::Status(1)->orderBy('operator_name', 'ASC')->get();
        $ScOperators = ScOperators::get();
        $notAllowuserTypes = array("Owner", "Super Admin", "Business Manager", "Admin", "BOD");
        $Users = User::Types($notAllowuserTypes)->Active()->get();
        // dd($Users);
        Session::forget('error');
        return view('service.edit', compact('service', 'companys', 'countrys', 'operators', 'ScOperators'));
    }
    public function update(ServiceEditRequest $request)
    {
        // return $request;
        $channal = [
            $request->channelowap,
            $request->channeloussd,
            $request->channelosms,
            $request->channeloivr,
        ];
        $cycle = [
            'changeCycleDaily' => $request->changeCycleDaily,
            'changeCycleWeekly' => $request->changeCycleWeekly,
            'changeCycleMonthly' => $request->changeCycleMonthly,
        ];
        $portalInformations = [
            'portal_url' => $request->portal_url,
            'cms_url' => $request->cms_url,
            'callback_url' => $request->callback_url,
            'notif_subs_url' => $request->notif_subs_url,
            'notif_unsubs_url' => $request->notif_unsubs_url,
            'notif_renewal_url' => $request->notif_renewal_url,
        ];
        $campaignType = [
            'click_to_sms' => $request->click_to_sms,
            'wap' => $request->wap,
            'api' => $request->api,
        ];
        $service = [
            'country_id' => $request->country,
            'company_id' => $request->company,
            'operator_id' => $request->operator,
            'service_name' => $request->servicename,
            'aggregator_status' => $request->aggregratorPermission,
            'aggregator' => $request->aggregrator,
            'subkeyword' => $request->subkeyword,
            'short_code' => $request->short_code,
            'type' => $request->type,
            'channel' => serialize($channal),
            'cycle' => serialize($cycle),
            'freemium' => $request->freemiumDays,
            'service_price' => $request->service_price,
            'revenue_share' => (int)$request->revenueShare,
            'subscription_keyword' => $request->subscription_keyword,
            'unsubscription_keyword' => $request->unsubscription_keyword,
            'portal_information' => serialize($portalInformations),
            'subs_sms' => $request->subs_sms,
            'unsubs_sms' => $request->unsubs_sms,
            'renewal_sms' => $request->renewal_sms,
            'campaign_type' => serialize($campaignType),
            'campaign_url' => $request->campaign_url,

        ];
        // dd($service);
        $user      = ScServices::findServices($request->id)->update($service);
        return redirect()->route('report.list')->with(
            'success',
            __('Service Updated Successfully!')
        );
    }
    public function operatorCreate(Request $request)
    {
        $country = Country::GetCountryByCountryId([$request->country])->first();
        if ($request->operator != null) {
            // dd($request->operator);
            $status = Operator::GetOperatorByOperatorId([$request->operator])->first();
            // dd($status);
            $data = [
                'country_id' => $status->country_id,
                'operator_name' => $status->operator_name,
                'country_name' => $status->country_name,
                'status' => $status->status,
            ];
            ScOperators::upsert($data, ['country_id', 'operator_name',], ['country_name', 'status'], 'id');
            // dd(ScOperators::last());
            $status = ScOperators::findByCountryId($status->country_id)->findByOperatorName($status->operator_name)->first();
            // $status=ScOperators::scopefindById($status)->first();
            return $status;
        }

        $data = [
            'country_id' => $request->country,
            'operator_name' => $request->operatorName,
            'country_name' => $country->country,
            'status' => 1,
        ];
        ScOperators::upsert($data, ['country_id', 'operator_name',], ['country_name', 'status'],);
        $status = ScOperators::findByCountryId($request->country)->findByOperatorName($request->operatorName)->first();
        return $status;
    }
    public function progressCreate($id)
    {
        $progress = ScServiceStatus::get();
        $progressReports = ScServiceProgres::FindByIdService($id)->get();
        $progressOldData = [];
        foreach ($progressReports as $data) {
            $progressOldData[$data->id_service_status] = $data;
        }
        // dd($progressOldData[1]);
        return view('service.progressCreate', compact('progress', 'id', 'progressOldData'));
    }
    public function progressReport($id)
    {
        $progressReports = ScServiceProgres::FindByIdService($id)->get();
        //dd($progressReports);
        return view('service.progressReport', compact('progressReports'));
    }
    public function progressUpdate(Request $request)
    {

        $datas = [];
        $data = [];
        $progress = ScServiceStatus::get();
        // DB::table('sc_services')
        // dd($progress);
        foreach ($progress as $progres) {

            $progresId = 'progres_' . $progres->id;
            $dute_date = 'date_' . $progres->id;
            $status = 'status_' . $progres->id;
            $data = [
                'id_service' => $request->service_id,
                'id_service_status' => $request->$progresId,
                'dute_date' => $request->$dute_date != '' ? $request->$dute_date : null,
                'complete_due_date' => $request->$dute_date != '' ? $request->$dute_date : null,
                'status' => $request->$status,
            ];
            if ($request->$status == "blocked") {
                $oldStatus = ScServiceProgres::where('id_service', $request->service_id)->where('id_service_status', $request->$progresId)->first()->status;
                // dd($oldStatus);
                if ($oldStatus != $request->$status) {
                    // $userScServices = ScServices::where('id', $request->service_id)->first();

                    $pmo = DB::table('sc_services')
                        ->select('users.email', 'users.name', 'sc_services.service_name')
                        ->leftJoin('users', 'users.id', '=', 'sc_services.pmo')
                        ->where('sc_services.id', $request->service_id)
                        ->first();
                    // dd($pmo);
                    $details = [
                        'name' => $pmo->name,
                        'service_name' => $pmo->service_name,
                        'status' => 'Blocked',
                        'task_status' => ScServiceStatus::where('id', $request->$progresId)->first()->name
                    ];

                    Mail::to([$pmo->email])->send(new ServiceCatalogUpdateMail($details));
                }
            } else if ($request->$status == "complete") {
                $oldStatus = ScServiceProgres::where('id_service', $request->service_id)->where('id_service_status', $request->$progresId)->first()->status;

                if ($oldStatus != $request->$status) {
                    $userScServices = ScServices::where('id', $request->service_id)->first();
                    $userEmail = DB::table('users')
                        ->select('email')
                        ->whereIn('id', [$userScServices->account_manager, $userScServices->pmo])
                        ->orWhere('type', "Business Manager")
                        ->get();
                    $pmo = DB::table('sc_services')
                        ->select('users.email', 'users.name', 'sc_services.service_name')
                        ->leftJoin('users', 'users.id', '=', 'sc_services.pmo')
                        ->where('sc_services.id', $request->service_id)
                        ->first();
                    $details = [
                        'name' => "Teams",
                        'service_name' => $pmo->service_name,
                        'status' => 'Completed',
                        'task_status' => ScServiceStatus::where('id', $request->$progresId)->first()->name
                    ];
                    Mail::to($userEmail)->send(new ServiceCatalogUpdateMail($details));
                }
            }

            $datas[] = $data;
        }
        // dd($datas);
        ScServiceProgres::upsert($datas, ['id_service', 'id_service_status'], ['dute_date', 'complete_due_date', 'status',]);
        return redirect()->route('report.detail', ['id' => $request->service_id])->with(
            'success',
            __('Service Progress Updated Successfully!')
        );
        return $request;
    }
    public function detail($id)
    {

        //edit service
        $service = ScServices::FindOrFail($id);
        $companys = Company::orderBy('name', 'ASC')->get();
        $countrys = Country::orderBy('country', 'ASC')->get();
        $operators = Operator::Status(1)->orderBy('operator_name', 'ASC')->get();
        $ScOperators = ScOperators::get();
        $notAllowuserTypes = array("Owner", "Super Admin", "Business Manager", "Admin", "BOD");
        $Users = User::Types($notAllowuserTypes)->Active()->get();
        // dd($Users);
        Session::forget('error');

        // progress create service
        $progress = ScServiceStatus::get();
        $progressReports = ScServiceProgres::FindByIdService($id)->get();
        $progressOldData = [];
        foreach ($progressReports as $data) {
            $progressOldData[$data->id_service_status] = $data;
        }

        //progressReports
        $progressReports = ScServiceProgres::FindByIdService($id)->get();

        return view('service.detail', compact('service', 'companys', 'countrys', 'operators', 'ScOperators', 'id', 'progress', 'progressOldData', 'progressReports'));
    }
}
