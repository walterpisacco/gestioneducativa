@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-plus"></i> @lang('Create Routine')</h1>
                    @include('session-messages')
                    <div class="row">
                        <div class="col-md-10 offset-md-1 mb-4">
                            <div class="card p-3 border bg-light shadow-sm">
                                <form action="{{route('section.routine.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label class="mt-2">@lang('Class')<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                                            <select onchange="getSectionsAndCourses(this);" class="form-select" name="class_id" required>
                                                @isset($classes)
                                                    <option selected disabled>@lang('Please select one')</option>
                                                    @foreach ($classes as $school_class)
                                                    <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="mt-2">@lang('Please select one'):<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                                            <select class="form-select" id="section-select" name="section_id" required>
                                            </select>
                                        </div>
                                    <div  class="col-md-3">
                                        <label class="mt-2">@lang('Please select one'):<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                                        <select class="form-select" id="course-select" name="course_id" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <p>@lang('Week Day')<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                                        <select class="form-select" id="course-select" name="weekday" required>
                                            <option value="1">@lang('Monday')</option>
                                            <option value="2">@lang('Tuesday')</option>
                                            <option value="3">@lang('Wednesday')</option>
                                            <option value="4">@lang('Thursday')</option>
                                            <option value="5">@lang('Friday')</option>
                                            <option value="6">@lang('Saturday')</option>
                                            <option value="7">@lang('Sunday')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputStarts" class="form-label">@lang('Starts')<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                                        <input type="text" class="form-control" id="inputStarts" name="start" placeholder="09:00am" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputEnds" class="form-label">@lang('Ends')<sup><i class="bi bi-asterisk text-primary"></i></sup></label>
                                        <input type="text" class="form-control" id="inputEnds" name="end" placeholder="09:50am" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <button type="submit" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Create')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
    function getSectionsAndCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('section-select');
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Seleccione un opción'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });

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
