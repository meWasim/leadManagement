@extends('layouts.admin')

@section('title')
{{ __('Manage Operator') }}
@endsection

@section('action-button')
<div class="all-button-box row d-flex justify-content-end">
    @can('Create Role')
    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6"></div>
    @endcan
</div>
@endsection
@section('content')
@php
if ($errors->any()) {
foreach ($errors->all() as $error) {
Session::flash('error', $error);
}
}
@endphp
@if(Session::has('flash_message_success'))
<p class="alert {{ Session::get('alert-class', 'alert-success') }}">
    {{ Session::get('flash_message_success') }}
</p>
@endif
@if(Session::has('flash_message_error'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('flash_message_error') }}
</p>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('currency.create')}}" role="button" class="btn btn-primary"><i class="fa fa-plus"> Add Country</i></a>
                <div class="operatorManagement">

                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('Country Id')}}</th>
                                    <th>{{__('Country Name')}}</th>
                                    <th>{{__('Country Code')}}</th>
                                    <th>{{__('Currency Code')}}</th>
                                    <th>{{__('Currency Value')}}</th>
                                    <th>{{__('USD')}}</th>
                                    <th>{{__('Flag')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
