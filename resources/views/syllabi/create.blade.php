@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-journal-text"></i> @lang('Create Syllabus')</h1>
                    @include('session-messages')
                    <div class="col-md-8 offset-md-2">
                        <div class="card p-3 border bg-light shadow-sm">
                        <form action="{{route('syllabus.store')}}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label>@lang('Class')</label>
                                    <select onchange="getCourses(this);" class="form-select" name="class_id" required>
                                        @isset($school_classes)
                                            <option selected disabled>@lang('Please select one')</option>
                                            @foreach ($school_classes as $school_class)
                                            <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-2">@lang('Course')<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                                    <select class="form-select" id="course-select" name="course_id">
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label for="syllabus-name" class="form-label">@lang('Syllabus Name')</label>
                                    <input type="text" class="form-control" id="syllabus-name" name="syllabus_name" placeholder="" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <input type="file" name="file" class="form-control" id="syllabus-file" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="bi bi-check2"></i> @lang('Create')</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
    function getCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {

            var courseSelect = document.getElementById('course-select');
            courseSelect.options.length = 0;
            data.courses.unshift({'id': 0,'course_name': 'Seleccione un opción'})
            data.courses.forEach(function(course, key) {
                courseSelect[key] = new Option(course.course_name, course.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }
</script>
@endsection