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

<div class="row">
    <div class="col-md-12">
        @can('Create Service')
        <div class="d-flex justify-content-end mr-6 mb-4"><a href="{{ Route('services.create') }}" role="button" class="btn btn-primary"><i class="fa fa-plus"> Add New </i></a>
        </div>@endcan
        <div class="card">

            <div class="card-body">

                <div class="operatorManagement">

                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Service Id') }}</th>
                                    <th>{{ __('Service Name') }}</th>
                                    <th>{{ __('Country ') }}</th>
                                    <th>{{ __('Operator ') }}</th>
                                    <th>{{ __('Payment ') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Service Logo') }}
                                    <th>{{ __('Status') }}</th>
                                    {{-- <th>{{__('Integration')}}</th> --}}
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                {{-- {{dd($service->operator)}} --}}
                                <tr>
                                    <td>{{ $service->id_service }}</td>
                                    <td>{{ $service->service_name }}</td>
                                    <td>{{ $service->countries->country }}</td>
                                    <td>{{ $service->operator->operator_name }}</td>
                                    <td>{{ $service->payment_type }}</td>
                                    <td>{{ $service->price_point }}</td>
                                    <td>{{ $service->category }}</td>
                                    <td>
                                        @php
                                        $filePath = public_path('files/service/asset/' . $service->service_logo);
                                        @endphp
                                        @if ($service->service_logo && file_exists($filePath))
                                        <img style="max-width: 50px; max-height: 50px; border-radius: 25%;" src="{{ asset('files/service/asset/' . $service->service_logo) }}" alt="Service Logo">
                                        @else
                                        <span>No Image</span>
                                        @endif
                                    </td>


                                    <td>
                                        @if ($service->status == 0)
                                        <span class="status-inactive">
                                            Inactive
                                            <span class="status-circle-inactive"></span>
                                        </span>
                                        @elseif($service->status == 1)
                                        <span class="status-active">
                                            Active
                                            <span class="status-circle-active"></span>
                                        </span>
                                        @endif
                                    </td>
                                    <td>

                                        @can('Edit Service')
                                        <a href="{{ route('services.edit', $service->id_service) }}" class="edit-icon"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                        <form action="{{ route('services.destroy', $service->id_service) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            @can('Delete Service')
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