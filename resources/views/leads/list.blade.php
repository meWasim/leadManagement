@extends('layouts.admin')

@section('title')
{{ __('User Verification') }}
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
      
        <div class="d-flex justify-content-end mr-6 mb-4"><a href="{{Route('leads.create')}}" role="button" class="btn btn-primary" ><i class="fa fa-plus"> Add New </i></a></div>
        
        <div class="card">
            <div class="card-body ">
                
                    <div class="operatorManagement"> 

                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Branch')}}</th>
                                    <th>{{__('ResourceID')}}</th>
                                    <th>{{__('CompanyName')}}</th>
                                    <th>{{__('ContactPerson')}}</th>
                                    <th>{{__('MobileNumber')}}</th>
                                    <th>{{__('MailId')}}</th>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('PinCode')}}</th>
                                    <th>{{__('Product')}}</th>
                                    <th>{{__('Service')}}</th>
                                    <th>{{__('NextFollowUpDate')}}</th>
                                    <th>{{__('Remarks')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leads as $lead)
                                <tr>
                                    <td>{{ $lead->Date }}</td>
                                    <td>{{ $lead->Branch }}</td>
                                    <td>{{ $lead->ResourceID }}</td>
                                    <td>{{ $lead->CompanyName }}</td>
                                    <td>{{ $lead->ContactPerson }}</td>
                                    <td>{{ $lead->MobileNumber }}</td>
                                    <td>{{ $lead->MailId }}</td>
                                    <td>{{ $lead->Address }}</td>
                                    <td>{{ $lead->PinCode }}</td>
                                    <td>{{ $lead->Product }}</td>
                                    <td>{{ $lead->Service }}</td>
                                    <td>{{ $lead->NextFollowUpDate }}</td>
                                    <td>{{ $lead->Remarks }}</td>
                                    <td>
                                        @can('Edit Lead')
                                        <a href="{{route('leads.edit', $lead->id)}}" class="edit-icon"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                        <form action="{{route('leads.destroy', $lead->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            @can('Delete Lead')
                                            <button class="delete-icon" style="border: none;"><i class="fas fa-trash"></i></button>
                                            @endcan  
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
