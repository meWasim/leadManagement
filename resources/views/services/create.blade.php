@extends('layouts.admin')

@section('title')
{{ __('Manage Service') }}
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
@if (Session::has('flash_message_success'))
<p class="alert {{ Session::get('alert-class', 'alert-success') }}">
    {{ Session::get('flash_message_success') }}
</p>
@endif
@if (Session::has('flash_message_error'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
    {{ Session::get('flash_message_error') }}
</p>
@endif

<?php $countrys = App\Models\Country::select('country', 'id')
    ->orderBy('country', 'ASC')
    ->distinct()
    ->get();
// dd($countrys);
?>
<?php $operators = App\Models\Operator::Status(0)
    ->orderBy('operator_name', 'ASC')
    ->get(); ?>
@php
$CountryId = request()->get('country');
$filterOperator = request()->get('operatorId');
@endphp

{{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif --}}
<!-- Code write here -->
@can('Create Service')
<h5 class=" font-weight-400 float-left modal-title mb-2 ml-2">Add Service</h5>
@endcan
<div class="card shadow-sm mt-0">
    <div class="card-body">
        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" id="serviceform" class="needs-validation" novalidate>
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group field-orev-share has-success ">
                        <label class="control-label" for="service_type">Select Service Type
                            <sup><i class="fa fa-asterisk" style="color: red; font-size:7px;"></i></sup>
                        </label>
                        <select name="service_type" class="form-control select2 " aria-required="true" id="service_type" required>
                            <option value="">Service type</option>
                            <option value="Web SDK">Web SDK</option>
                            <option value="Hosted DCB">Hosted DCB</option>
                        </select>
                        <label class="invalid-feedback mt--20">
                            Please select a service type.
                        </label>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="businessType">Select Payment Type <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <select name="payment_type" value="{{ old('payment_type') }}" class="form-control select2" aria-required="true" id="payment_type" required>
                            <option value="">Payment Type</option>
                            <option value="Subscription">Subscription</option>
                            <option value="Onetime Purchase">Onetime Purchase</option>

                        </select>
                        <label class="invalid-feedback">
                            Please select a payment type.
                        </label>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="country">Where will you Provide The Service:
                            <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i></sup>
                        </label>

                        <select name="country_id" class="form-control select2" id="country" required>
                            <option value="">Choose Country</option>
                            @foreach ($countrys as $country)
                            <option value="{{ $country->id }}" <?php echo isset($CountryId) && $CountryId == $country->id ? 'selected' : ''; ?>>
                                {{ $country->country }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a country.
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="operator">Operator Name <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <select name="operator_id" value="{{ old('service_operator') }}" class="form-control select2" id="operator" required>
                            <option value="">Choose Operator</option>
                            <!-- Options will be populated based on the selected country using JavaScript -->
                        </select>
                        <label class="invalid-feedback">
                            Please select operator.
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Service Name <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="service_name" value="{{ old('service_name') }}" aria-required="true" aria-invalid="false" placeholder="Name of Your Service" required>
                        <label class="invalid-feedback">
                            Please enter service name.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Third Party Service Id <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="number" id="" class="form-control" name="third_party_service_id" value="{{ old('third_party_service_id') }}" aria-required="true" aria-invalid="false" placeholder="Enter Third Party Service Id" required>
                        <label class="invalid-feedback">
                            Please enter thid party service id.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Callback URL <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="callback_url" value="{{ old('callback_url') }}" aria-required="true" aria-invalid="false" placeholder="Callback URL ..." required>
                        <label class="invalid-feedback">
                            Please enter callback url.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Service URL <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="service_url" value="{{ old('service_url') }}" aria-required="true" aria-invalid="false" placeholder="Service URL ..." required>
                        <label class="invalid-feedback">
                            Please enter service url.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for=""> SDC </label>
                        <input type="number" id="" class="form-control" name="sdc" value="{{ old('service_url') }}" aria-required="true" aria-invalid="false" placeholder="Enter Sdc Number ...">
                        {{-- <label class="invalid-feedback">
                                Please Enter Sdc Number.
                            </label> --}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Provider <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="provider_name" value="{{ old('provider_name') }}" aria-required="true" aria-invalid="false" placeholder="Service Provider Name " required>
                        <label class="invalid-feedback">
                            Please enter provider name.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Description <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <textarea name="service_description" id="" cols="30" rows="1" value="{{ old('service_description') }}" class="form-control" placeholder="Service Description" required></textarea>
                        <label class="invalid-feedback">
                            Please enter description.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="serviceCategory">Service Category <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <select name="category" value="{{ old('category') }}" class="form-control select2" id="" required>
                            <option value="">Select Category</option>
                            <option value="Game">Game</option>
                            <option value="Video">Video</option>

                        </select>
                        <label class="invalid-feedback">
                            Please select a category.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">First Message <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="first_message" value="{{ old('first_message') }}" aria-required="true" aria-invalid="false" placeholder="enter first message" required>
                        <label class="invalid-feedback">
                            Please enter first message.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Renewal Message <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="renewal_message" value="{{ old('renewal_message') }}" aria-required="true" aria-invalid="false" placeholder="enter renewal message" required>
                        <label class="invalid-feedback">
                            Please enter renewal message.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Unsubscribe Message <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="unsubscribe_message" value="{{ old('unsubscribe_message') }}" aria-required="true" aria-invalid="false" placeholder="enter unsubscribe message " required>
                        <label class="invalid-feedback">
                            Please enter unsubscribe message.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Keyword <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="service_keyword" value="{{ old('service_keyword') }}" aria-required="true" aria-invalid="false" placeholder="enter service keyword" required>
                        <label class="invalid-feedback">
                            Please enter keyword.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Sub Keyword <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <input type="text" id="" class="form-control" name="service_sub_keyword" value="{{ old('service_sub_keyword') }}" aria-required="true" aria-invalid="false" placeholder="enter service sub keyword" required>
                        <label class="invalid-feedback">
                            Please enter sub keyword.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Channel Type <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <select name="channel_type" value="{{ old('channel_type') }}" class="form-control select2" id="" required>
                            <option value="">Select Channel</option>
                            <option value="Game">SMS</option>
                            <option value="Video">Web</option>
                            <option value="Video">Portal</option>
                        </select>
                        <label class="invalid-feedback">
                            Please select channel type.
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="">Subscribe Duration <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                        <select name="subscription_duration" value="{{ old('subscription_duration') }}" class="form-control select2" id="" required>
                            <option value="">Select Duration</option>
                            <option value="daily">Daily</option>
                            <option value="weekely">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        <label class="invalid-feedback">
                            Please select duration.
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="checkbox-inline">
                            <input type="checkbox" class="" id="freemium" name="freemium" required> Freemium Duration
                            <sup><i class="fa fa-asterisk" style="color: red; font-size: 7px;"></i></sup>
                        </label>
                        <div class="invalid-feedback" style="display: none;">
                            Please check the freemium duration.
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="p-2 border serviceRadio freemium_block">
                        <label for="freemium_duration" class="" style="width: 100%;display: inline-flex;align-items: baseline;justify-content: space-between;">
                            Select Your Freemium Duration
                            <span><sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i></sup></span>
                            <input type="number" id="freemium_duration" name="freemium_duration" value="" class="form-control" style="width: auto;" required>
                            <span style="float: right;">Days</span>
                        </label>
                        <div class="invalid-feedback" style="display: none;">
                            Please enter freemium duration days.
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share  has-success">
                        <label>AOC<span><sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></span></label>
                        <div class="border">
                            <div class="p-2 aoc_type_div">
                                <div class="custom-control custom-radio custom-control-inline serviceRadio">
                                    <input type="radio" id="aoc_type_pinflow" name="aoc_type" class="custom-control-input" value="pin flow" checked>
                                    <label class="custom-control-label" for="aoc_type_pinflow">Pin Flow</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline serviceRadio">
                                    <input type="radio" id="aoc_type_premiumsms" name="aoc_type" class="custom-control-input" value="premium sms">
                                    <label class="custom-control-label" for="aoc_type_premiumsms">Premium SMS</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline serviceRadio">
                                    <input type="radio" id="aoc_type_direct" name="aoc_type" class="custom-control-input" value="direct">
                                    <label class="custom-control-label" for="aoc_type_direct">Direct</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group field-orev-share has-success">
                        <label>Service Logo</label>
                        <div class="border border-dark rounded service_logo_div">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload-file-button mt-3 mb-3 ml-3">
                                        <span class="logo-size text-info small">Size of logo: 242x90px and must be of
                                            png format maximum of 700 KB</span>
                                        <div class="custom-file mt-2" style="width: 350px">
                                            <input type="file" class="custom-file-input" id="service_logo" name="service_logo" onchange="previewImage()">
                                            <label class="custom-file-label" for="service_logo" id="file-label">Choose file</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <div class="logo-preview-container" style="margin-top: 2%;">
                                            <img id="logo-preview" class="img-thumbnail border-dark" src="service/logo.png" alt="no img" style="max-width: 66px; max-height: 80px;">
                                            <p id="logo-name" class="mt-2"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group field-orev-share has-success">
                        <label>Payment Background<span>
                            </span></label>
                        <div class="border border-dark rounded service_logo_div">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload-file-button mt-3 mb-3 ml-3">
                                        <span class="logo-size text-info small">Size of Background: 700x700 px and must
                                            be of png format maximum of 1 MB</span>
                                        <div class="custom-file mt-2" style="width: 350px">
                                            <input type="file" class="custom-file-input" id="payment_background" name="payment_background" onchange="previewImage()">
                                            <label class="custom-file-label" for="service_logo" id="file-label-payment">Choose file</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <div class="logo-preview-container" style="margin-top: 2%;">
                                            <img id="logo-preview-payment" class="img-thumbnail border-dark" src="service/logo.png" alt="no img" style="max-width: 66px; max-height: 80px;">
                                            <p id="payment-name" class="mt-2"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group field-orev-share  has-success">
                        <fieldset class="card">
                            <legend class="d-inline-block badge px-5 py-2 color-d rounded text-center mx-auto" style="width:auto"><span class="subHeading">Price Point</span></legend>
                            <div class="d-flex" style="display: block;">
                                <table class="table table-bordered" id="price_point_tbl">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Country</th>
                                            <th scope="col">Operator</th>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Price Point</th>
                                        </tr>
                                    </thead>
                                    <tbody class="service_price_point_div" name="price_point">

                                    </tbody>
                                </table>
                            </div>

                        </fieldset>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group field-orev-share has-success">
                        <fieldset class="card">
                            <legend class="d-inline-block badge px-5 py-2 color-d rounded text-center mx-auto" style="width:auto"><span class="subHeading">Service Flow</span></legend>
                            <div class="d-flex">
                                <div class="col-sm-12">
                                    <div class="upload-file-button justify-content-between mb-5">
                                        <span>Subscription Flow</span>
                                        <div class="custom-file float-right subscription_flow_btn" style="width: 40%;">
                                            <input type="file" class="custom-file-input" id="subscription_flow" name="subscription_flow">
                                            <label class="custom-file-label" for="subscription_flow">Choose
                                                file</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="upload-file-button justify-content-between mb-5">
                                        <span>Unsubscription Flow</span>
                                        <div class="custom-file float-right unsubscription_flow_btn" style="width: 40%;">
                                            <input type="file" class="custom-file-input" id="unsubscription_flow" name="unsubscription_flow">
                                            <label class="custom-file-label" for="unsubscription_flow">Choose
                                                file</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <span class="text-danger" id="subscription-flow-error"></span>
                                    <div class="border p-1 mr-3 text-center text-info text-capitalize font-weight-bold" style="font-size: 10px">
                                        Note: Please upload PDF files that explain how your subscription and
                                        unsubscription will work
                                    </div>
                                    <div class="clearfix"></div>
                                    <span class="text-danger" id="unsubscription-flow-error"></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('services.index') }}" class="btn btn-primary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('assets/js/service.js') }}"></script>

@endpush