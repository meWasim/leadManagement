<?php

namespace App\Models;

use App\Mail\CommonEmailTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Pusher\Pusher;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Utility extends Model
{
    public static function settings()
    {
        $data = DB::table('settings');

        if(Auth::check())
        {
            $data->where('created_by', '=', Auth::user()->ownerId())->orWhere('created_by', '=', 1);
        }
        else
        {
            $data->where('created_by', '=', 1);
        }

        $data = $data->get();

        $settings = [
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "site_enable_stripe" => "off",
            "site_stripe_key" => "",
            "site_stripe_secret" => "",
            "site_enable_paypal" => "off",
            "site_paypal_mode" => "sandbox",
            "site_paypal_client_id" => "",
            "site_paypal_secret_key" => "",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INV",
            "estimation_prefix" => "#EST",
            "invoice_template" => "template1",
            "invoice_color" => "ffffff",
            "invoice_logo" => "",
            "estimation_template" => "template1",
            "estimation_color" => "ffffff",
            "estimation_logo" => "",
            "mdf_prefix" => "#MDF",
            "mdf_template" => "template1",
            "mdf_color" => "ffffff",
            "mdf_logo" => "",
            "default_language" => "en",
            "enable_landing" => "yes",
            "footer_title" => "Payment Information",
            "footer_note" => "Thank you for your business.",
            "gdpr_cookie" => "",
            "cookie_text" => "",
        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function payment_settings()
    {
        $data = DB::table('admin_payment_settings');

        if(Auth::check())
        {
            $data->where('created_by', '=', Auth::user()->ownerId());
        }
        else
        {
            $data->where('created_by', '=', 1);
        }
        $data = $data->get();
        $res = [];
        foreach ($data as $key => $value) {
            $res[$value->name] = $value->value;
        }

        return $res;
    }

    public static function getValByName($key)
    {
        $setting = self::settings();

        if(!isset($setting[$key]) || empty($setting[$key]))
        {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function languages()
    {
        $dir     = base_path() . '/resources/lang/';
        $glob    = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir){
                return str_replace($dir, '', $value);
            }, $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir){
                return preg_replace('/[0-9]+/', '', $value);
            }, $arrLang
        );
        $arrLang = array_filter($arrLang);

        return $arrLang;
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);

        if(count($values) > 0)
        {
            foreach($values as $envKey => $envValue)
            {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if(!$keyPosition || !$endOfLinePosition || !$oldLine)
                {
                    $str .= "{$envKey}='{$envValue}'\n";
                }
                else
                {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        $str .= "\n";

        if(!file_put_contents($envFile, $str))
        {
            return false;
        }

        return true;
    }

    public static function sendNotification($type, $user_id, $obj)
    {
        if(!Auth::check() || $user_id != \Auth::user()->id)
        {
            $notification = Notification::create(
                [
                    'user_id' => $user_id,
                    'type' => $type,
                    'data' => json_encode($obj),
                    'is_read' => 0,
                ]
            );

            // Push Notification
            $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            );

            $pusher          = new Pusher(
                env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), $options
            );
            $data            = [];
            $data['html']    = $notification->toHtml();
            $data['user_id'] = $notification->user_id;

            $pusher->trigger('send_notification', 'notification', $data);

            // End Push Notification
        }
    }

    public static function templateData()
    {
        $arr              = [];
        $arr['colors']    = [
            '003580',
            '666666',
            '6777f0',
            'f50102',
            'f9b034',
            'fbdd03',
            'c1d82f',
            '37a4e4',
            '8a7966',
            '6a737b',
            '050f2c',
            '0e3666',
            '3baeff',
            '3368e6',
            'b84592',
            'f64f81',
            'f66c5f',
            'fac168',
            '46de98',
            '40c7d0',
            'be0028',
            '2f9f45',
            '371676',
            '52325d',
            '511378',
            '0f3866',
            '48c0b6',
            '297cc0',
            'ffffff',
            '000',
        ];
        $arr['templates'] = [
            "template1" => "New York",
            "template2" => "Toronto",
            "template3" => "Rio",
            "template4" => "London",
            "template5" => "Istanbul",
            "template6" => "Mumbai",
            "template7" => "Hong Kong",
            "template8" => "Tokyo",
            "template9" => "Sydney",
            "template10" => "Paris",
        ];

        return $arr;
    }

    // Email Template Modules Function START
    // Common Function That used to send mail with check all cases
    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {
        $usr = Auth::user();

        //Remove Current Login user Email don't send mail to them
        unset($mailTo[$usr->id]);

        $mailTo = array_values($mailTo);

        if($usr->type != 'Super Admin')
        {
            // find template is exist or not in our record
            $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();

            if(isset($template) && !empty($template))
            {
                // check template is active or not by company
                $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->ownerId())->first();

                if($is_active->is_active == 1)
                {
                    $settings = self::settings();

                    // get email content language base
                    $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                    $content->from = $template->from;
                    if(!empty($content->content))
                    {
                        $content->content = self::replaceVariable($content->content, $obj);

                        // send email
                        try
                        {
                            Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));
                        }
                        catch(\Exception $e)
                        {
                            // $error = __('E-Mail has been not sent due to SMTP configuration');
                            $error = $e->getMessage();
                        }

                        if(isset($error))
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => $error,
                            ];
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => true,
                                'error' => false,
                            ];
                        }
                    }
                    else
                    {
                        $arReturn = [
                            'is_success' => false,
                            'error' => __('Mail not send, email is empty'),
                        ];
                    }

                    return $arReturn;
                }
                else
                {
                    return [
                        'is_success' => true,
                        'error' => false,
                    ];
                }
            }
            else
            {
                return [
                    'is_success' => false,
                    'error' => __('Mail not send, email not found'),
                ];
            }
        }
    }

    // used for replace email variable (parameter 'template_name','id(get particular record by id for data)')
    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{deal_name}',
            '{deal_pipeline}',
            '{deal_stage}',
            '{deal_status}',
            '{deal_price}',
            '{deal_old_stage}',
            '{deal_new_stage}',
            '{task_name}',
            '{task_priority}',
            '{task_status}',
            '{lead_name}',
            '{lead_email}',
            '{lead_pipeline}',
            '{lead_stage}',
            '{lead_old_stage}',
            '{lead_new_stage}',
            '{estimation_name}',
            '{estimation_client}',
            '{estimation_status}',
            '{app_name}',
            '{company_name},',
            '{email}',
            '{password}',
            '{app_url}',
        ];
        $arrValue    = [
            'deal_name' => '-',
            'deal_pipeline' => '-',
            'deal_stage' => '-',
            'deal_status' => '-',
            'deal_price' => '-',
            'deal_old_stage' => '-',
            'deal_new_stage' => '-',
            'task_name' => '-',
            'task_priority' => '-',
            'task_status' => '-',
            'lead_name' => '-',
            'lead_email' => '-',
            'lead_pipeline' => '-',
            'lead_stage' => '-',
            'lead_old_stage' => '-',
            'lead_new_stage' => '-',
            'estimation_name' => '-',
            'estimation_client' => '-',
            'estimation_status' => '-',
            'app_name' => '-',
            'company_name' => '-',
            'email' => '-',
            'password' => '-',
            'app_url' => '-',
        ];

        foreach($obj as $key => $val)
        {
            $arrValue[$key] = $val;
        }

        $arrValue['app_name']     = env('APP_NAME');
        $arrValue['company_name'] = self::settings()['company_name'];
        $arrValue['app_url']      = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }

    // Make Entry in email_tempalte_lang table when create new language
    public static function makeEmailLang($lang)
    {
        $template = EmailTemplate::all();
        foreach($template as $t)
        {
            $default_lang                 = EmailTemplateLang::where('parent_id', '=', $t->id)->where('lang', 'LIKE', 'en')->first();
            $emailTemplateLang            = new EmailTemplateLang();
            $emailTemplateLang->parent_id = $t->id;
            $emailTemplateLang->lang      = $lang;
            $emailTemplateLang->subject   = $default_lang->subject;
            $emailTemplateLang->content   = $default_lang->content;
            $emailTemplateLang->save();
        }
    }
    // Email Template Modules Function END

    // get font-color code accourding to bg-color
    public static function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3)
        {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        }
        else
        {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array(
            $r,
            $g,
            $b,
        );

        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    public static function getFontColor($color_code)
    {
        $rgb = self::hex2rgb($color_code);
        $R   = $G = $B = $C = $L = $color = '';

        $R = (floor($rgb[0]));
        $G = (floor($rgb[1]));
        $B = (floor($rgb[2]));

        $C = [
            $R / 255,
            $G / 255,
            $B / 255,
        ];

        for($i = 0; $i < count($C); ++$i)
        {
            if($C[$i] <= 0.03928)
            {
                $C[$i] = $C[$i] / 12.92;
            }
            else
            {
                $C[$i] = pow(($C[$i] + 0.055) / 1.055, 2.4);
            }
        }

        $L = 0.2126 * $C[0] + 0.7152 * $C[1] + 0.0722 * $C[2];

        if($L > 0.179)
        {
            $color = 'black';
        }
        else
        {
            $color = 'white';
        }

        return $color;
    }

    public static function delete_directory($dir)
    {
        if(!file_exists($dir))
        {
            return true;
        }

        if(!is_dir($dir))
        {
            return unlink($dir);
        }

        foreach(scandir($dir) as $item)
        {
            if($item == '.' || $item == '..')
            {
                continue;
            }

            if(!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item))
            {
                return false;
            }

        }

        return rmdir($dir);
    }

    public static function addNewData()
    {
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');

        $usr            = Auth::user();
        // print_r($usr);die('++++++');
        $arrPermissions = [
            'Manage MDFs',
            'Request MDF',
            'Edit MDF',
            'Delete MDF',
            'View MDF',
            'Manage MDF Types',
            'Create MDF Type',
            'Edit MDF Type',
            'Delete MDF Type',
            'Manage MDF Sub Types',
            'Create MDF Sub Type',
            'Edit MDF Sub Type',
            'Delete MDF Sub Type',
            'Manage MDF Status',
            'Create MDF Status',
            'Edit MDF Status',
            'Delete MDF Status',
            'Create MDF Payment',
            'MDF Add Expense',
            'MDF Edit Expense',
            'MDF Delete Expense',
        ];

        foreach($arrPermissions as $ap)
        {
            // check if permission is not created then create it.
            $permission = Permission::where('name', 'LIKE', $ap)->first();
            if(empty($permission))
            {
                Permission::create(['name' => $ap]);
            }
        }

        $ownerRole        = Role::where('name', 'LIKE', 'Owner')->first();
        $ownerPermissions = $ownerRole->getPermissionNames()->toArray();

        $ownerNewPermission = [
            'Manage MDFs',
            'Request MDF',
            'Edit MDF',
            'Delete MDF',
            'View MDF',
            'Manage MDF Types',
            'Create MDF Type',
            'Edit MDF Type',
            'Delete MDF Type',
            'Manage MDF Sub Types',
            'Create MDF Sub Type',
            'Edit MDF Sub Type',
            'Delete MDF Sub Type',
            'Manage MDF Status',
            'Create MDF Status',
            'Edit MDF Status',
            'Delete MDF Status',
            'Create MDF Payment',
            'MDF Add Expense',
            'MDF Edit Expense',
            'MDF Delete Expense',
        ];

        foreach($ownerNewPermission as $op)
        {
            // check if permission is not assign to owner then assign.
            if(!in_array($op, $ownerPermissions))
            {
                $permission = Permission::findByName($op);
                $ownerRole->givePermissionTo($permission);
            }
        }

        $userRole        = Role::where('name', 'LIKE', 'Employee')->first();
        $userPermissions = $userRole->getPermissionNames()->toArray();

        $userNewPermission = [
            'Manage MDFs',
            'Request MDF',
            'Edit MDF',
            'Delete MDF',
            'View MDF',
            'MDF Add Expense',
            'MDF Edit Expense',
            'MDF Delete Expense',
        ];

        foreach($userNewPermission as $op)
        {
            // check if permission is not assign to owner then assign.
            if(!in_array($op, $userPermissions))
            {
                $permission = Permission::findByName($op);
                $userRole->givePermissionTo($permission);
            }
        }
    }

    public static function get_messenger_packages_migration()
    {
        $totalMigration = 0;
        $messengerPath  = glob(base_path() . '/vendor/munafio/chatify/database/migrations' . DIRECTORY_SEPARATOR . '*.php');
        if(!empty($messengerPath))
        {
            $messengerMigration = str_replace('.php', '', $messengerPath);
            $totalMigration     = count($messengerMigration);
        }

        return $totalMigration;
    }

    // Used to check permission is exist or not in database
    public static function checkPermissionExist($permission)
    {
        $permission = Permission::where('name', 'LIKE', $permission)->count();

        return $permission;
    }

    

    public static function getAdminPaymentSetting(){
        $data = DB::table('admin_payment_settings');
        $settings=[];
        if(\Auth::check())
        {
            $user_id = 1;
            $data = $data->where('created_by', '=', $user_id);
        }
        $data = $data->get();
        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function getselectedThemeColor(){
        $color = env('THEME_COLOR');
        if($color == "" || $color == null){
            $color = 'blue';
        }
        return $color;
    }

    public static function getAllThemeColors(){
        $colors = [
            'blue','denim','sapphire','olympic','violet','black','cyan','dark-blue-natural','gray-dark','light-blue','light-purple','magenta','orange-mute','pale-green','rich-magenta','rich-red','sky-gray'
        ];
        return $colors;
    }

    public static function checkImgTransparent($img){
        try{
            $im = imagecreatefrompng($img);
            $rgba = imagecolorat($im,1,1);
            $alpha = ($rgba & 0x7F000000) >> 24;
            if($alpha>0){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            return false;
        }
    }
}
