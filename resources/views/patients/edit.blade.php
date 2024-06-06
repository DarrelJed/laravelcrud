@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Patient</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('patients.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Last Name:</strong>
                    <input type="text" name="lastname" value="{{ $patient->lastname }}" class="form-control" placeholder="Last Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>First Name:</strong>
                    <input type="text" name="firstname" value="{{ $patient->firstname }}" class="form-control" placeholder="First Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Middle Name:</strong>
                    <input type="text" name="middlename" value="{{ $patient->middlename }}" class="form-control" placeholder="Middle Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Gender:</strong>
                    <select name="gender" class="form-control">
                        <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>Date of Birth:</strong>
                    <input type="date" name="dateofbirth" value="{{ $patient->dateofbirth }}" class="form-control" placeholder="Date of Birth">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
