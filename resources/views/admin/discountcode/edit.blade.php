@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ !empty($page_title) ? $page_title : 'Ecommerce' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/discountcode/list') }}">Discount Code list</a>
                        </li>
                        <li class="breadcrumb-item active">{{ ucfirst($page_title) }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit discount code - {{ ucfirst($page_title) }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-6">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name">Discount Code Name <span
                                                class="text text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            value="{{ old('name', $discountcode->name) }}" id="" required
                                            placeholder="Enter color name">
                                        @if ($errors->has('name'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('name') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="type">Type <span class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            name="type" required>
                                            <option value="">Select type</option>
                                            <option {{ old('type', $discountcode->type) == 'Amount' ? 'selected' : '' }}
                                                value="Amount">Amount
                                            </option>
                                            <option {{ old('type', $discountcode->type) == 'Percent' ? 'selected' : '' }}
                                                value="Percent">Percentage
                                            </option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('type') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="percent_amount">Percent / Amount <span
                                                class="text text-danger">*</span></label>
                                        <input type="text" name="percent_amount"
                                            class="form-control {{ $errors->has('percent_amount') ? ' is-invalid' : '' }}"
                                            value="{{ old('percent_amount',$discountcode->percent_amount) }}" id="" required
                                            placeholder="Percent / Amount">
                                        @if ($errors->has('percent_amount'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('percent_amount') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="expire_date">Expiry Date <span class="text text-danger">*</span></label>
                                        @php
                                        $formattedDate=\Illuminate\Support\Carbon::parse($discountcode->pubdate)->format('Y-m-d');
                                        @endphp
                                        <input type="date" name="expire_date"
                                            class="form-control {{ $errors->has('expire_date') ? ' is-invalid' : '' }}"
                                            value="{{ old('expire_date',$formattedDate) }}" id="" required
                                            placeholder="Enter expiry date">
                                        @if ($errors->has('expire_date'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('expire_date') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text text-danger">*</span></label>
                                        <select
                                            class="form-control select2 {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            name="status" required>
                                            <option {{ old('status',$discountcode->status) == 0 ? 'selected' : '' }} value="0">Active
                                            </option>
                                            <option {{ old('status',$discountcode->status) == 1 ? 'selected' : '' }} value="1">Inactive
                                            </option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('status') }}.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                    </form>
                </div>
                <!-- /.card -->



            </div>

        </div>

    </div>
@endsection
