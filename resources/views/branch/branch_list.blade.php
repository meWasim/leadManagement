@extends('layouts.admin')

@section('title')
    {{ __('Branch Management') }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="javascript:void(0)" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="{{__('Create Branch')}}" data-url="{{Route('branches.create')}}">
                <i class="fas fa-plus"></i> {{__('Add')}}
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <table class="table table-striped dataTable">
                        <thead>
                            <tr>
                                <th>{{__('Branch Name')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $dt)
                                <tr>
                                    <td>{{ $dt->name }}</td>
                                    <td>
                                        <!-- Actions for each branch -->
                                    </td>
                                    <td class="Action">
                                    <a href="javascript:void(0)" data-url="#" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Merchant #')}}"  class="edit-icon"><i class="fas fa-pencil-alt"></i>
                                    </a>

                                   

                                    <form id="deleteForm" method="POST" action="#">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" class="edit-icon" data-confirm="{{ __('Are you sure you want to delete this merchant?') }}" data-confirm-yes="document.getElementById('deleteForm').submit();" data-toggle="tooltip"  style="background-color: red;">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
@endsection
