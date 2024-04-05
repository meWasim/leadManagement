<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\report_summarize;
use App\Models\ReportsPnlsOperatorSummarizes;
use App\Models\Operator;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use App\Models\ReportsSummarizeDashbroads;
use App\Models\ReportSummeriseUsers;
use App\Models\role_operators;
use App\Models\CompanyOperators;
use App\common\Utility;
use App\common\UtilityReports;
use App\common\UtilityDashboard;
use App\Models\NotificationDeployment;
use App\Models\NotificationIncident;
use Config;

class Dashboard_V2_Controller extends Controller
{
    public function index(Request $request)
    {
       if(Auth::check()){
        return view('admin.country_dashboard');
       } else {
            return redirect()->route('login');
        }
    }

}
