@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i>  @lang('Promote Students')
                    </h1>
                    @include('session-messages')
                    <p class="text-danger">
                        <small><i class="bi bi-exclamation-diamond-fill me-2"></i>  @lang('Students must be promoted only once to a new Session. Ususally, Admin will create a New Session once Academic activity ends for the Current Session').</small>
                    </p>
                    <div class="mb-4 mt-4">
                        <form action="{{route('promotions.store')}}" method="POST">
                            @csrf
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col"># @lang('Document')</th>
                                        <th scope="col"> @lang('First Name')</th>
                                        <th scope="col"> @lang('Last Name')</th>
                                        <th scope="col"> @lang('Previous Class')</th>
                                        <th scope="col"> @lang('Previous Section')</th>
                                        <th scope="col"> @lang('Promoting to Class')</th>
                                        <th scope="col"> @lang('Promoting to Section')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($students)
                                        @foreach ($students as $index => $student)
                                        <tr>
                                            <th scope="row">
                                                <input type="hidden" class="form-control" name="alumno[{{$student->student->id}}]" value="{{$student->student->id}}">
                                                {{$student->student->document}}
                                            </th>
                                            <td>{{$student->student->first_name}}</td>
                                            <td>{{$student->student->last_name}}</td>
                                            <td>{{$schoolClass->class_name}}</td>
                                            <td>{{$section->section_name}}</td>
                                            <td>
                                                <select onchange="getSections(this, {{$index}});" class="form-select form-select-sm" id="inputAssignToClass{{$index}}" name="class_id[{{$index}}]" required>
                                                    @isset($school_classes)
                                                        <option selected disabled> @lang('Please select one')</option>
                                                        @foreach ($school_classes as $school_class)
                                                            <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm" aria-label="Section" id="inputAssignToSection{{$index}}" name="section_id[{{$index}}]" required>
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success mb-3"><i class="bi bi-sort-numeric-up-alt"></i>  @lang('Promote')</button>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
    function getSections(obj, index) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
            var sectionSelect = document.getElementById('inputAssignToSection'+index);
            sectionSelect.options.length = 0;
            data.sections.unshift({'id': 0,'section_name': 'Please select a section'})
            data.sections.forEach(function(section, key) {
                sectionSelect[key] = new Option(section.section_name, section.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }
</script>
@endsection
