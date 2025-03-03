<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request){
        $perPage = $request->get('per_page', 10);
        $subjects = Subject::query()->paginate($perPage);
        return response()->json($subjects);
    }
    public function show(Subject $subject){
        return response()->json($subject);
    }
    public function store (StoreSubjectRequest $request) {
        $validator = $request->validated();
        Subject::query()->create($validator);
        return response()->json(['message' => 'Subject created successfully.']);
    }
    public function update(UpdateSubjectRequest $request, Subject $subject){
        $validator = $request->validated();
        $subject->update($validator);
        return response()->json(['message' => 'Subject updated successfully.']);
    }
    public function delete(Subject $subject){
        $subject->delete();
        return response()->json(['message' => 'Subject deleted successfully.']);
    }
}
