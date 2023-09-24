<?php

namespace App\Http\Controllers;

use App\Http\Requests\test\AddMarkRequest;
use App\Http\Requests\test\StoreRequest;
use App\Http\Requests\test\UpdateRequest;
use App\Models\Center;
use App\Models\Student;
use App\Models\Test;
use App\Models\TestMark;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index(Center $center)
    {
        $tests = Test::where('center_id', $center->id)->orderBy('id', 'DESC')->get();
        return response()->success(['tests' => $tests]);
    }

    public function store(StoreRequest $request, Center $center)
    {
        $test = new Test($request->validated());
        $test->center_id = $center->id;
        $test->save();
        return response()->success(['test' => $test]);
    }

    public function addMark(AddMarkRequest $request, Center $center, Test $test)
    {
        $student_id = $request->get('student_id');
        $test_id = $test->id;

        $exists = TestMark::where('student_id', $student_id)->where('test_id', $test_id)->count() > 0;

        if ($exists) {
            return response()->error('The marks of the student have already been entered for the relevent test.');
        }

        $mark = new TestMark($request->validated());
        $mark->test_id = $test->id;
        $mark->user_id = Auth::user()->id;
        $mark->save();

        return response()->success(['mark' => $mark]);
    }

    public function show(Center $center, Test $test)
    {
        return response()->success(['test' => $test]);
    }

    public function showMarks(Center $center, Test $test)
    {
        $marks = $test->marks;
        return response()->success(['marks' => $marks]);
    }

    public function showMyMarks(Center $center, Test $test)
    {
        $user_id = Auth::user()->id;
        $marks = TestMark::where('test_id', $test->id)->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        return response()->success(['marks' => $marks]);
    }

    public function showMark(Center $center, Test $test, Student $student)
    {
        $mark = TestMark::where('test_id', $test->id)->where('student_id', $student->id)->first();

        if (is_null($mark)) {
            return response()->error('The marks not found for the given student for relevent test.', 404);
        }

        return response()->success(['mark' => $mark]);
    }

    public function update(UpdateRequest $request, Center $center, Test $test)
    {

    }

    public function destroy(Center $center, Test $test)
    {
        $test->delete();
        return response()->success(null, 'Successfully deleted.');
    }

    public function destroyMark(Center $center, Test $test, Student $student)
    {
        $mark = TestMark::where('test_id', $test->id)->where('student_id', $student->id)->first();

        if (is_null($mark)) {
            return response()->error('The marks not found for the given student for relevent test.', 404);
        }

        if (!Auth::user()->hasLevel('a|m|l') && $mark->user_id != Auth::user()->id) {
            return response()->error('This marks was entered by another member. You are not allowed to do this.', 403);
        }

        $mark->delete();

        return response()->success(null, 'Successfully deleted.');
    }
}
