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

    <!-- Code write here -->
    <div class="card shadow-sm mt-0">
        <div class="card-body">
            <form action="{{ URL::to('services/' . $service->id_service) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-md-6">

                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="serviceType">Service Type <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            {{-- <select name="service_type" class="form-control select2" readonly aria-required="true" id="service_type">
                                <option value="{{ $service->service_type }}" selected>Select Service type</option>
                                <option value="Web SDK" {{ $service->service_type == 'Web SDK' ? 'selected' : '' }}>Web SDK
                                </option>
                                <option value="Hosted DCB" {{ $service->service_type == 'Hosted DCB' ? 'selected' : '' }}>
                                    Hosted DCB</option>
                            </select> --}}
                            <input type="text" class="form-control" name="service_type" id="service_type"
                                value="{{ $service->service_type }}" readonly>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="businessType">Payment Type <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            {{-- <select name="payment_type" value="{{ old('payment_type') }}" aria-readonly="true" class="form-control select2"
                                aria-required="true" id="payment_type">
                                <option value="Subscription"
                                    {{ $service->payment_type == 'Subscription' ? 'selected' : '' }}>Subscription</option>
                                <option value="Onetime Purchase"
                                    {{ $service->payment_type == 'Onetime Purchase' ? 'selected' : '' }}>Onetime Purchase
                                </option>
                            </select> --}}
                            <input type="text" class="form-control" name="payment_type" id="payment_type"
                                value="{{ $service->payment_type }}" readonly>

                            <div class="help-block"></div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="businessType">Where will you Provide The Service:</label>
                            {{-- <select name="service_country" class="form-control select2" id="country">
                                <option value="0">{{ $service->countries->country }}</option>
                                @foreach ($countrys as $country)
                                    <option value="{{ $country->id }}" <?php echo isset($CountryId) && $CountryId == $country->id ? 'selected' : ''; ?>>{{ $country->country }}
                                    </option>
                                @endforeach
                            </select> --}}
                            <!-- Display Country Name (Read-only) -->
                            <input type="text" class="form-control" value="{{ $service->countries->country }}" readonly>

                            <!-- Store Country Code (Hidden) -->
                            <input type="hidden" name="country_id" id="service_country" value="{{ $service->country_id }}">


                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="businessType">Operator</label>
                            {{-- <select name="operator_id" value="{{ old('service_operator') }}" class="form-control select2"
                                id="operator">
                                <option value="">{{ $service->operator->operator_name }}</option>
                                <!-- Options will be populated based on the selected country using JavaScript -->
                            </select> --}}
                           <input type="text" class="form-control"  value="{{ $service->operator->operator_name }}" readonly >

                            <!-- Store Country Code (Hidden) -->
                            <input type="hidden" name="operator_id" id="operator_id" value="{{ $service->operator_id }}">

                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Service Name <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="service_name"
                                value="{{ $service->service_name }}" aria-required="true" aria-invalid="false"
                                placeholder="Name of Your Service">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Third Party Service Id <sup><i
                                        class="fa fa-asterisk" style="color: red;font-size: 7px;"></i></sup></label>
                            <input type="number" id="" class="form-control" required name="third_party_service_id"
                                value="{{ $service->third_party_service_id }}" aria-required="true" aria-invalid="false"
                                placeholder="Enter Third Party Service Id">
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Callback URL <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="callback_url"
                                value="{{ $service->callback_url }}"aria-required="true" aria-invalid="false"
                                placeholder="Callback URL ...">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Service URL <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="service_url"
                                value="{{ $service->service_url }}"aria-required="true" aria-invalid="false"
                                placeholder="Service URL ...">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">SDC </label>
                            <input type="text" id="" class="form-control" name="sdc"
                                value="{{ $service->sdc }}"aria-required="true" aria-invalid="false"
                                placeholder="Sdc Nmber...">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Provider <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="provider_name"
                                value="{{ $service->provider_name }}" aria-required="true" aria-invalid="false"
                                placeholder="Service Provide Name ">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Description
                                <sup><i class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup>
                            </label>
                            <textarea name="service_description" id="" cols="30" rows="1" class="form-control" placeholder="Service Description">
                                {{ $service->service_description }}
                            </textarea>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="serviceCategory">Service Category <sup><i
                                        class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                            <select name="category" value=""class="form-control select2" id="">
                                <option value="Game"{{ $service->category == 'Game' ? 'selected' : '' }}>Game</option>
                                <option value="Video"{{ $service->category == 'Video' ? 'selected' : '' }}>Video</option>

                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">First Message <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="first_message"
                                value="{{ $service->first_message }}" aria-required="true" aria-invalid="false"
                                placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Renewal Message <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="renewal_message"
                                value="{{ $service->renewal_message }}" aria-required="true" aria-invalid="false"
                                placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Unsubscribe Message <sup><i
                                        class="fa fa-asterisk" style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="unsubscribe_message"
                                value="{{ $service->unsubscribe_message }}" aria-required="true" aria-invalid="false"
                                placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Keyword <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control" name="service_keyword"
                                value="{{ $service->service_keyword }}" aria-required="true" aria-invalid="false"
                                placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Sub Keyword <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <input type="text" id="" class="form-control"
                                name="service_sub_keyword"value="{{ $service->service_sub_keyword }}"
                                aria-required="true" aria-invalid="false" placeholder="">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Channel Type <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <select name="channel_type" value="" class="form-control select2" id="">
                                <option value="Sms" {{ $service->channel_type == 'Sms' ? 'selected' : '' }}>SMS
                                </option>
                                <option value="Web" {{ $service->channel_type == 'Web' ? 'selected' : '' }}>Web
                                </option>
                                <option value="Portal" {{ $service->channel_type == 'Portal' ? 'selected' : '' }}>Portal
                                </option>
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="control-label" for="">Subscribe Duration <sup><i class="fa fa-asterisk"
                                        style="color: red;font-size: 7px;"></i><sup></label>
                            <select name="subscription_duration" value="" class="form-control select2"
                                id="">
                                <option value="daily" {{ $service->subscription_duration == 'daily' ? 'selected' : '' }}>
                                    Daily</option>
                                <option value="weekely"
                                    {{ $service->subscription_duration == 'weekely' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly"
                                    {{ $service->subscription_duration == 'mounthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label class="checkbox-inline">
                                <input type="checkbox" class="" id="freemium" required name="freemium"
                                    {{ !empty($service->freemium_duration) ? 'checked' : '' }}>freemium
                                Duration<span><sup><i class="fa fa-asterisk"
                                            style="color: red;font-size: 7px;"></i><sup></span>
                                <div class="help-block"></div>
                            </label>&nbsp;
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border serviceRadio freemium_block">
                            <label for="freemium_duration" class=""
                                style="width: 100%;display: inline-flex;align-items: baseline;justify-content: space-between;">Select
                                Your Freemium Duration <span><sup><i class="fa fa-asterisk"
                                            style="color: red;font-size: 7px;"></i><sup></span> <input type="number"
                                    required id="freemium_duration" name="freemium_duration"
                                    value="{{ $service->freemium_duration }}" class="form-control"
                                    style="width: auto;"><span style="float: right;">Days</span></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group field-orev-share required has-success">
                            <label>AOC <sup><i class="fa fa-asterisk"
                                style="color: red;font-size: 7px;"></i><sup></label></span>
                            <div class="border">
                                <div class="p-2 aoc_type_div">
                                    <div class="custom-control custom-radio custom-control-inline serviceRadio">
                                        <input type="radio" id="aoc_type_pinflow" name="aoc_type"
                                            class="custom-control-input" value="pin flow"
                                            {{ $service->aoc_type === 'pin flow' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="aoc_type_pinflow">Pin Flow</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline serviceRadio">
                                        <input type="radio" id="aoc_type_premiumsms" name="aoc_type"
                                            class="custom-control-input" value="premium sms"
                                            {{ $service->aoc_type === 'premium sms' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="aoc_type_premiumsms">Premium SMS</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline serviceRadio">
                                        <input type="radio" id="aoc_type_direct" name="aoc_type"
                                            class="custom-control-input" value="direct"
                                            {{ $service->aoc_type === 'direct' ? 'checked' : '' }}>
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
                                                <input type="file" class="custom-file-input" id="service_logo"
                                                    name="service_logo" onchange="previewImage()">
                                                <label class="custom-file-label" for="service_logo"
                                                    id="file-label">{{$service->service_logo}}</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <div class="logo-preview-container"
                                                style="margin-top: 2%; position:absolute; left:62%">
                                                <img id="logo-preview" class="img-thumbnail border-dark"
                                                    src="{{asset('files/service/asset/'.$service->service_logo)}}" alt="no img" style="max-width: 66px; max-height: 80px;">
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
                                                <input type="file" class="custom-file-input" id="payment_background"
                                                    name="payment_background" onchange="previewImage()">
                                                <label class="custom-file-label" for="service_logo"
                                                    id="file-label-payment">{{$service->payment_background}}</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <div class="logo-preview-container" style="margin-top: 2%; position: absolute; left: 62%">
                                                <img id="logo-preview-payment" class="img-thumbnail border-dark" src="{{asset('files/service/asset/'.$service->payment_background)}}" alt="no img" style="max-width: 66px; max-height: 80px;">
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
                                <legend class="d-inline-block badge px-5 py-2 color-d rounded text-center mx-auto"
                                    style="width:auto"><span class="subHeading">Price Point</span></legend>
                                <div class="d-flex" style="display: block;">
                                    <table class="table table-bordered" id="price_point_tbl">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Country</th>
                                                <th scope="col">Operator</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Price Point</th>
                                            </tr>
                                        </thead>
                                        <tbody class="service_price_point_div">
                                            <tr>
                                                <td>{{ $service->countries->country }}</td>
                                                <td>{{ $service->operator->operator_name }}</td>
                                                <td>{{ $service->payment_type }}</td>
                                                <td><select class="form-control select2">
                                                        <option>{{ $service->price_point }}</option>
                                                    </select></td>
                                            </tr>
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
                                                <label class="custom-file-label" for="subscription_flow">Choose file</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="upload-file-button justify-content-between mb-5">
                                            <span>Unsubscription Flow</span>
                                            <div class="custom-file float-right unsubscription_flow_btn" style="width: 40%;">
                                                <input type="file" class="custom-file-input" id="unsubscription_flow" name="unsubscription_flow">
                                                <label class="custom-file-label" for="unsubscription_flow">Choose file</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <span class="text-danger" id="subscription-flow-error"></span>
                                        <div class="border p-1 mr-3 text-center text-info text-capitalize font-weight-bold" style="font-size: 10px">
                                            Note: Please upload PDF files that explain how your subscription and unsubscription will work
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
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('services.index') }}" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection



@push('script')
    <script>
        function previewImage() {
    var input = document.getElementById('service_logo');
    var input1 = document.getElementById('payment_background');
    var preview = document.getElementById('logo-preview');
    var preview1 = document.getElementById('logo-preview-payment');
    var fileLabel = document.getElementById('file-label');
    var fileLabel1 = document.getElementById('file-label-payment');

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        // Update the label text to display the selected file name
        fileLabel.innerText = input.files[0].name;
        reader.readAsDataURL(input.files[0]);
    }

    if (input1.files && input1.files[0]) {
        var reader1 = new FileReader();
        reader1.onload = function(e) {
            preview1.src = e.target.result;
        };
        // Update the label text to display the selected file name
        fileLabel1.innerText = input1.files[0].name;
        reader1.readAsDataURL(input1.files[0]);
    }
}



        // $(document).ready(function() {

        //     $('select[name="service_country"]').change(function() {
        //         updateOperators($(this).val());
        //     });

        //     function updateOperators(id) {
        //         var value = id;

        //         $.ajax({
        //             type: "POST",
        //             url: '/services/filter/',
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: {
        //                 'id': value
        //             },
        //             dataType: "json",
        //             success: function(responses) {
        //                 document.getElementById('operator').innerHTML =
        //                     '<option value="">Operator Name</option>';
        //                 $.each(responses, function(index, response) {

        //                     $("#operator").append('<option value="' + response.operator_id +
        //                         '" >' + response.operator_name + '</option>');

        //                 });

        //             },
        //         });
        //     }
        // });
    </script>

<script>
    $(document).ready(function() {
        // Function to update file label when a file is selected
        function updateFileLabel(input, label) {
            var fileName = $(input).val().split('\\').pop(); // Extract file name
            $(label).text(fileName); // Update label text with file name
        }

        // Event listener for Subscription Flow file input
        $('#subscription_flow').change(function() {
            updateFileLabel(this, '.subscription_flow_btn .custom-file-label');
        });

        // Event listener for Unsubscription Flow file input
        $('#unsubscription_flow').change(function() {
            updateFileLabel(this, '.unsubscription_flow_btn .custom-file-label');
        });
    });
</script>
@endpush
