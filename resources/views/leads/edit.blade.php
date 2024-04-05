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

<?php $countrys = App\Models\Country::select('id', 'country')->orderBy('country', 'ASC')->distinct()->get();

?>

<!-- Code write here -->
<h4 class="h4 font-weight-400 float-left modal-title mb-2 ml-2">Edit Operator</h4>
<div class="card shadow-sm mt-0">
    <div class="card-body">
        <form action="{{route('operators.update',$data->operator_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="form-group row">

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Operator Id <sup><i class="fa fa-asterisk" aria-hidden="true" style="font-size: 7px;color:red"></i></sup>
                            @if ($errors->has('id_operator'))
                            <span class="text-danger">{{ $errors->first('id_operator') }}</span>
                        </label>
                        @endif
                        <input type="text" id="" class="form-control" name="id_operator" value="{{$data->operator_id}}" aria-required="true" aria-invalid="false"  readonly>

                        <div class="help-block"></div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Operator Name <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="text" id="" class="form-control" name="operator_name" aria-required="true" aria-invalid="false" placeholder="Name of Operator" value="{{$data->operator_name}}">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share has-success">
                        <label class="control-label" for="businessType">Country <sup><i class="fa fa-asterisk" aria-hidden="true" style="font-size: 7px;color:red"></i></i></sup>
                            @if ($errors->has('country'))
                            <span class="text-danger">{{ $errors->first('country') }}</span>
                        </label>
                        @endif
                        <select name="country_id" class="form-control select2" id="Country">

                            @foreach($countrys as $country)
                            <option value="{{ $country->id}}" {{ old('country') }} {{$country->id==$data->country_id? 'selected' : '' }}>{{ $country->country }}</option>
                            @endforeach

                        </select>
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for=""> Revenue Limit <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="number" id="" class="form-control" name="revenue_limit" aria-required="true" aria-invalid="false" placeholder="" value="{{$data->revenue_limit}}">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">M.O Limit <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="number" id="" class="form-control" name="mo_limit" aria-required="true" aria-invalid="false" placeholder="" value="{{$data->mo_limit}}">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Service Limit <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="number" id="" class="form-control" name="service_limit" aria-required="true" aria-invalid="false" placeholder="" value="{{$data->service_limit}}">
                        <div class="help-block"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <div class="upload-file-button justify-content-between">
                            <span>Upload picture</span>
                            <div class="custom-file float-right" style="width: 100%;">
                                <input type="file" class="custom-file-input" id="" name="operator_logo" placeholder="upload your operator logo" value="{{$data->revenue_limit}}">
                                <label class="custom-file-label" for=""></label>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection