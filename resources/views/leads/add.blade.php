@extends('layouts.admin')

@section('title')
{{ __('Manage Lead') }}
@endsection

@section('action-button')
<div class="all-button-box row d-flex justify-content-end">
    @can('Create Role')
    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6"></div>
    @endcan
</div>
@endsection

@section('content')

@if(Session::has('flash_message_success'))
<p class="alert {{ Session::get('alert-class', 'alert-success') }}">
    {{ Session::get('flash_message_success') }}
</p>
@endif



<h4 class="h4 font-weight-400 float-left modal-title mb-2 ml-2">Add Lead</h4>
<div class="card shadow-sm mt-0">
    <div class="card-body">
        <form action="{{route('leads.store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <div class="form-group row">

                <!-- Existing Fields -->
                <!-- ... (keep the existing fields) ... -->

                <!-- New Fields -->
                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="Date">Date</label>
                        <input type="date" id="Date" class="form-control" name="Date" value="{{old('Date')}}" required>
                        <div class="invalid-feedback">Please select a date.</div>
                    </div>
                </div>
 
        <div class="col-md-6">
                <div class="form-group field-orev-share required has-success">
                    <label class="control-label" for="Branch">Branch</label>
                    <select id="Branch" class="form-control" name="Branch" required>
                        <option value="">Select Branch</option>
                        @foreach($branc as $branch)
                            <option value="{{ $branch->id }}" {{ old('Branch') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a branch.</div>
                </div>
        </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="ResourceID">ResourceID</label>
                        <input type="text" id="ResourceID" class="form-control" name="ResourceID" value="{{old('ResourceID')}}" placeholder="Enter ResourceID" required>
                        <div class="invalid-feedback">Please enter ResourceID.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="CompanyName">CompanyName</label>
                        <input type="text" id="CompanyName" class="form-control" name="CompanyName" value="{{old('CompanyName')}}" placeholder="Enter CompanyName" required>
                        <div class="invalid-feedback">Please enter CompanyName.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="ContactPerson">ContactPerson</label>
                        <input type="text" id="ContactPerson" class="form-control" name="ContactPerson" value="{{old('ContactPerson')}}" placeholder="Enter ContactPerson" required>
                        <div class="invalid-feedback">Please enter ContactPerson.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="MobileNumber">MobileNumber</label>
                        <input type="text" id="MobileNumber" class="form-control" name="MobileNumber" value="{{old('MobileNumber')}}" placeholder="Enter MobileNumber" required>
                        <div class="invalid-feedback">Please enter MobileNumber.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="MailId">MailId</label>
                        <input type="email" id="MailId" class="form-control" name="MailId" value="{{old('MailId')}}" placeholder="Enter MailId" required>
                        <div class="invalid-feedback">Please enter a valid MailId.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="Address">Address</label>
                        <input type="text" id="Address" class="form-control" name="Address" value="{{old('Address')}}" placeholder="Enter Address" required>
                        <div class="invalid-feedback">Please enter Address.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="PinCode">PinCode</label>
                        <input type="text" id="PinCode" class="form-control" name="PinCode" value="{{old('PinCode')}}" placeholder="Enter PinCode" required>
                        <div class="invalid-feedback">Please enter PinCode.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="Product">Product</label>
                        <input type="text" id="Product" class="form-control" name="Product" value="{{old('Product')}}" placeholder="Enter Product" required>
                        <div class="invalid-feedback">Please enter Product.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="Service">Service</label>
                        <input type="text" id="Service" class="form-control" name="Service" value="{{old('Service')}}" placeholder="Enter Service" required>
                        <div class="invalid-feedback">Please enter Service.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="NextFollowUpDate">NextFollowUpDate</label>
                        <input type="date" id="NextFollowUpDate" class="form-control" name="NextFollowUpDate" value="{{old('NextFollowUpDate')}}" required>
                        <div class="invalid-feedback">Please select a date for NextFollowUpDate.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group field-orev-share required has-success">
                        <label class="control-label" for="Remarks">Remarks</label>
                        <textarea id="Remarks" class="form-control" name="Remarks" rows="3" required>{{old('Remarks')}}</textarea>
                        <div class="invalid-feedback">Please enter Remarks.</div>
                    </div>
                </div>

             

                

            </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{Route('leads.index')}}" role="button" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>



@endsection
