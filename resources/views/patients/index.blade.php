@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Patients</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('patients.create') }}"> Create New Patient</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Age</th>
            <th>Classification</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($patients as $patient)
        <tr>
            <td>{{ $patient->id }}</td>
            <td>{{ $patient->lastname }}</td>
            <td>{{ $patient->firstname }}</td>
            <td>{{ $patient->middlename }}</td>
            <td>{{ $patient->gender }}</td>
            <td>{{ $patient->dateofbirth }}</td>
            <td>{{ $patient->age }}</td>
            <td>{{ $patient->classification }}</td>
            <td>
                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
                    <a class="btn btn-primary" href="{{ route('patients.edit', $patient->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <h3>Classification Counts</h3>
    <table class="table table-bordered">
        <tr>
            <th>Classification</th>
            <th>Count</th>
        </tr>
        @foreach ($classificationCounts as $classification)
        <tr>
            <td>{{ $classification->classification }}</td>
            <td>{{ $classification->count }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
