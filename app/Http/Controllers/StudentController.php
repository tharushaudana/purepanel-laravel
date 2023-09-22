<?php

namespace App\Http\Controllers;

use App\Http\Requests\student\StoreRequest;
use App\Http\Requests\student\UpdateRequest;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return response()->success(['students' => Student::latest()->get()]);
    }

    public function store(StoreRequest $request)
    {
        $student = new Student($request->validated());
        $currentBatch = Batch::currentBatch()->id;

        $student->batch_id = $currentBatch;

        $student->save();

        return response()->success(['student' => $student]);
    }

    public function show(Student $student)
    {
        return response()->success(['student' => $student]);
    }

    public function update(UpdateRequest $request, Student $student)
    {
        
    }

    public function destroy(Student $student)
    {

    }
}
