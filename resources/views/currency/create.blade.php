@extends('layouts.admin')

@section('title')
{{ __('Manage Country') }}
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


<!-- Code write here -->
<div class="card shadow-sm mt-0">
    <div class="card-body">
        <form action="{{route('currency.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">


                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Country Name <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="text" id="" class="form-control" name="country" value="{{old('country')}}" aria-required="true" aria-invalid="false" placeholder="Name of Country">
                        <div class="help-block"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Country Code <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="text" id="" class="form-control" name="country_code" value="{{old('country_code')}}" aria-required="true" aria-invalid="false" placeholder=" Enter Country Code">
                        <div class="help-block"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for=""> Currency Code <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="text" id="" class="form-control" name="currency_code" value="" aria-required="true" aria-invalid="false" placeholder="Enter Currency Code">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Currency Value <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="text" id="" class="form-control" name="currency_value" value="" aria-required="true" aria-invalid="false" placeholder="Enter Currency Value">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">USD <sup><i class="fa fa-question-circle" aria-hidden="true"></i></sup></label>
                        <input type="text" id="" class="form-control" name="usd" value="" aria-required="true" aria-invalid="false" placeholder="Enter Usd">
                        <div class="help-block"></div>
                    </div>
                </div>

                <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <div class="upload-file-button justify-content-between">
                            <span>Upload Country Flag</span>
                                <div class="custom-file float-right" style="width: 100%;">
                                    <input type="file" class="custom-file-input" id="" name="flag" placeholder="upload your country flag">
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
