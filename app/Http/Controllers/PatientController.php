<?php

// app/Http/Controllers/PatientController.php
namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use DB;
class PatientController extends Controller
{
    public function index()
{
    $patients = Patient::select('patients.*', DB::raw('TIMESTAMPDIFF(YEAR, patients.dateofbirth, CURDATE()) AS age'), 'ageclassification.classification')
        ->leftJoin('ageclassification', function($join) {
            $join->on(DB::raw('TIMESTAMPDIFF(YEAR, patients.dateofbirth, CURDATE())'), '>=', 'ageclassification.minimum')
                 ->on(DB::raw('TIMESTAMPDIFF(YEAR, patients.dateofbirth, CURDATE())'), '<=', 'ageclassification.maximum');
        })
        ->get();

    $classificationCounts = Patient::select(DB::raw('COUNT(*) as count, ageclassification.classification'))
        ->leftJoin('ageclassification', function($join) {
            $join->on(DB::raw('TIMESTAMPDIFF(YEAR, patients.dateofbirth, CURDATE())'), '>=', 'ageclassification.minimum')
                 ->on(DB::raw('TIMESTAMPDIFF(YEAR, patients.dateofbirth, CURDATE())'), '<=', 'ageclassification.maximum');
        })
        ->groupBy('ageclassification.classification')
        ->get();

    return view('patients.index', compact('patients', 'classificationCounts'));
}

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'gender' => 'required',
            'dateofbirth' => 'required|date',
        ]);

        $duplicate = Patient::where('firstname', $request->firstname)
            ->where('lastname', $request->lastname)
            ->where('middlename', $request->middlename)
            ->where('dateofbirth', $request->dateofbirth)
            ->where('gender', $request->gender)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withErrors(['duplicate' => 'This patient already exists.'])->withInput();
        }

        Patient::create($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }


    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
{
    $request->validate([
        'lastname' => 'required',
        'firstname' => 'required',
        'middlename' => 'nullable',
        'gender' => 'required|in:Male,Female',
        'dateofbirth' => 'required|date',
    ]);

    $patient->update($request->all());

    return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
}

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
