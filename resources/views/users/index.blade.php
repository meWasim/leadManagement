@extends('layouts.admin')

@section('title')
    {{ __('Manage Users') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Create User')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="{{__('Create User')}}" data-url="{{route('users.create')}}">
                    <i class="fas fa-plus"></i> {{__('Add')}}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach($users as $user)
            <div class="col-lg-3 col-sm-6 col-md-6">
                <div class="card profile-card">
                    @if(Gate::check('Edit User') || Gate::check('Delete User'))
                        <div class="edit-profile user-text">
                            <div class="dropdown action-item">
                                @if($user->is_active == 1)
                                    <a href="#" class="action-item" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if(\Auth::user()->type != 'Super Admin')
                                            <a href="{{route('users.show',$user->id)}}" class="dropdown-item text-sm">{{__('View')}}</a>
                                        @endif
                                        @can('Edit User')
                                            <a href="#" class="dropdown-item text-sm" data-url="{{ route('users.edit',$user->id) }}" data-ajax-popup="true" data-title="{{__('Edit User')}}">{{__('Edit')}}</a>
                                        @endcan
                                        @can('Edit User')
                                            <a href="{{ route('users.show.operator',$user->id) }}" class="dropdown-item text-sm" data-url="" data-ajax-popup="true" data-title="{{__('Edit User')}}">{{__('Add operator')}}</a>
                                        @endcan
                                        @can('Delete User')
                                            <a class="dropdown-item text-sm" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$user['id']}}').submit();">
                                                @if($user->delete_status == 0){{__('Delete')}} @else {{__('Restore')}}@endif
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user['id']],'id'=>'delete-form-'.$user['id']]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                @else
                                    <a href="#" class="action-item"><i class="fas fa-lock"></i></a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="avatar-parent-child">
                        <img @if($user->avatar) src="{{asset('/avatars/'.$user->avatar)}}" @else src="{{asset('assets/img/avatar/avatar-1.png')}}" @endif class="avatar rounded-circle avatar-xl">
                    </div>
                    @if(\Auth::user()->type != 'Super Admin')
                        <h4 class="h4 mb-0 mt-2"><a href="{{route('users.show',$user->id)}}">{{ $user->name }}</a></h4>
                    @else
                        <h4 class="h4 mb-0 mt-2">{{ $user->name }}</h4>
                    @endif
                    @if($user->delete_status == 1)
                        <h5 class="office-time mb-0">{{__('Deleted')}}</h5>
                    @endif
                    <div class="sal-right-card">
                        <span class="badge badge-pill badge-blue">{{ ucfirst($user->type) }}</span>
                    </div>
                    <h6 class="office-time mb-0 mt-4" style="padding-bottom: 30px;">{{ $user->email }}</h6>
                    @if(\Auth::user()->type == 'Super Admin')
                        <div class="mt-4">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-6 text-center">
                                    <span class="d-block font-weight-bold mb-0">{{!empty($user->getPlan()->first())?$user->getPlan()->name:''}}</span>
                                </div>
                                <div class="col-6 text-center Id">
                                    <a href="#" data-url="{{ route('plan.upgrade',$user->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Upgrade Plan')}}">{{__('Upgrade Plan')}}</a>
                                </div>
                                <div class="col-12">
                                    <hr class="my-3">
                                </div>
                                <div class="col-12 text-center pb-2">
                                    <span class="text-dark text-xs">{{__('Plan Expired : ') }} {{!empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date): __('Unlimited')}}</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="d-block text-sm font-weight-bold mb-0">{{ $user->totalUser() }}</span>
                                    <span class="d-block text-sm text-muted">{{__('Users')}}</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="d-block text-sm font-weight-bold mb-0">{{ $user->totalCilent() }}</span>
                                    <span class="d-block text-sm text-muted">{{__('Clients')}}</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="d-block text-sm font-weight-bold mb-0">{{ $user->totalDeals() }}</span>
                                    <span class="d-block text-sm text-muted">{{__('Deals')}}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
