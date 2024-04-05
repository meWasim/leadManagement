<div class="card bg-none card-box">
    {{ Form::open(array('url' => 'roles')) }}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('name', __('Role Name'),['class'=>'form-control-label']) }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('permissions', __('Assign Permissions'),['class'=>'form-control-label']) }}
                <table class="table table-striped">
                    <tr>
                        <th class="text-dark">{{__('Module')}}</th>
                        <th class="text-dark">{{__('Permissions')}}</th>
                    </tr>
                    <tr>
                       {{-- <td>{{__('Account')}}</td>
                        <td>
                            <div class="row">
                                @if(in_array('System Settings',$permissions))
                                    @php($key = array_search('System Settings', $permissions))
                                    <div class="col-4 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('System Settings'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                            </div>
                        </td> --}}
                    </tr>
                    <?php
                    $modules = [
                        'User',
                        'Role',

                    ];


                    if(\Auth::user()->type == 'Super Admin')
                    {
                        $modules[] = 'Language';
                    }

                    ?>

                    @foreach($modules as $module)
                        <?php

                            $s_name = $module . "s";


                        ?>
                        <tr>
                            <td>{{__($module)}}</td>
                            <td>
                                <div class="row">
                                    @if(in_array('Manage '.$s_name,$permissions))
                                        @php($key = array_search('Manage '.$s_name, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, 'Manage',['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                    @if(in_array('Create '.$module,$permissions))
                                        @php($key = array_search('Create '.$module, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, __('Create'),['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                    @if(in_array('Request '.$module,$permissions))
                                        @php($key = array_search('Request '.$module, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, __('Request'),['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                    @if(in_array('Edit '.$module,$permissions))
                                        @php($key = array_search('Edit '.$module, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, __('Edit'),['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                    @if(in_array('Delete '.$module,$permissions))
                                        @php($key = array_search('Delete '.$module, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, __('Delete'),['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                    @if(in_array('View '.$module,$permissions))
                                        @php($key = array_search('View '.$module, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, __('View'),['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                    @if(in_array('Move '.$module,$permissions))
                                        @php($key = array_search('Move '.$module, $permissions))
                                        <div class="col-3 custom-control custom-checkbox">
                                            {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                            {{ Form::label('permission_'.$key, __('Move'),['class'=>'custom-control-label font-weight-500']) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{__('Other')}}</td>
                        <td>
                            <div class="row">
                                @if(in_array('Dashboard',$permissions))
                                    @php($key = array_search('Dashboard', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Dashboard'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Reports Management',$permissions))
                                    @php($key = array_search('Reports Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Reports Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Report Summary',$permissions))
                                    @php($key = array_search('Report Summary', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Report Summary'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Reporting Details',$permissions))
                                    @php($key = array_search('Reporting Details', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Reporting Details'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('PNL Summary',$permissions))
                                    @php($key = array_search('PNL Summary', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('PNL Summary'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('PNL Detail',$permissions))
                                    @php($key = array_search('PNL Detail', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('PNL Detail'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Adnet Report',$permissions))
                                    @php($key = array_search('Adnet Report', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Adnet Report'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Analytic Management',$permissions))
                                    @php($key = array_search('Analytic Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Analytic Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Ads Monitoring',$permissions))
                                    @php($key = array_search('Ads Monitoring', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Ads Monitoring'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Revenue Monitoring',$permissions))
                                    @php($key = array_search('Revenue Monitoring', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Revenue Monitoring'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Revenue Alert',$permissions))
                                    @php($key = array_search('Revenue Alert', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Revenue Alert'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('ROI Report',$permissions))
                                    @php($key = array_search('ROI Report', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('ROI Report'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Log Performance',$permissions))
                                    @php($key = array_search('Log Performance', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Log Performance'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Management',$permissions))
                                    @php($key = array_search('Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                {{-- @if(in_array('Rev Share Management',$permissions))
                                    @php($key = array_search('Rev Share Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Rev Share Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif --}}
                                {{-- @if(in_array('Company Assign',$permissions))
                                    @php($key = array_search('Company Assign', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Company Assign'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif --}}
                                @if(in_array('Company Management',$permissions))
                                    @php($key = array_search('Company Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Company Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Currency Management',$permissions))
                                    @php($key = array_search('Currency Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Currency Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Operator Management',$permissions))
                                    @php($key = array_search('Operator Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Operator Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Finance Management',$permissions))
                                    @php($key = array_search('Finance Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Finance Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Revenue Reconcile',$permissions))
                                    @php($key = array_search('Revenue Reconcile', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Revenue Reconcile'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                 @if(in_array('Target Revenue',$permissions))
                                    @php($key = array_search('Target Revenue', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Target Revenue'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Activity Log Management',$permissions))
                                    @php($key = array_search('Activity Log Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Activity Log Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('User Activity',$permissions))
                                    @php($key = array_search('User Activity', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('User Activity'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('System Activity',$permissions))
                                    @php($key = array_search('System Activity', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('System Activity'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Service Catalogue',$permissions))
                                    @php($key = array_search('Service Catalogue', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Service Catalogue'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Add New Service',$permissions))
                                    @php($key = array_search('Add New Service', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Add New Service'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Service List',$permissions))
                                    @php($key = array_search('Service List', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Service List'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Product Management',$permissions))
                                    @php($key = array_search('Product Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Product Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Add New Product',$permissions))
                                    @php($key = array_search('Add New Product', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Add New Product'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Product List',$permissions))
                                    @php($key = array_search('Product List', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Product List'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Pivot Management',$permissions))
                                    @php($key = array_search('Pivot Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Pivot Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Tools Management',$permissions))
                                    @php($key = array_search('Tools Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Tools Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Tools Show',$permissions))
                                    @php($key = array_search('Tools Show', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Tools Show'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif

                                @if(in_array('Log File Management',$permissions))
                                    @php($key = array_search('Log File Management', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Log File Management'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                                @if(in_array('Cron Log',$permissions))
                                    @php($key = array_search('Cron Log', $permissions))
                                    <div class="col-6 custom-control custom-checkbox">
                                        {{ Form::checkbox('permissions[]',$key,false,['class' => 'custom-control-input','id'=>'permission_'.$key]) }}
                                        {{ Form::label('permission_'.$key, __('Cron Log'),['class'=>'custom-control-label font-weight-500']) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-12 text-right">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
