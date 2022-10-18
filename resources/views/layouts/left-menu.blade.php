
<div class="col-md-2 border-rt-e6 px-0" style="box-shadow: 0 0.1rem 1rem 0.25rem rgb(0 0 0 / 40%) !important;">
    <div class=" flex-column align-items-center align-items-sm-start ">
                <ul class="nav flex-column pt-2 w-100">
                    @can('view menu dashboard')
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ request()->is('home')? 'active' : '' }}" href="{{url('home')}}"><span class="material-icons">dashboard</span> {{ __('Dashboard') }}</a>
                    </li>
                    @endcan

                    @can('view menu escuelas')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link  {{ request()->is('school.list')? 'active' : '' }}" href="{{route('school.list')}}"><i class="bi bi-diagram-3"></i> <span class="ms-2 d-inline d-sm-none d-md-none d-xl-inline"> @lang('Schools')</span> <span class="ms-auto d-inline d-sm-none d-md-none d-xl-inline"></span></a>
                    </li>
                    @endcan

                    @can('view menu niveles')
                    <li class="nav-item w-100 ">
                        <a class="nav-link  {{ request()->is('classes')? 'active' : '' }}" href="{{url('classes')}}"><span class="material-icons">reduce_capacity</span> @lang('Classes')</a>
                    </li>
                    @endcan

                    @can ('view menu administrativos')
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ request()->routeIs('administrative.list.show')? 'active' : '' }}" href="{{route('administrative.list.show')}}"><span class="material-icons">people</span> @lang('Administratives')</a>
                    </li>
                    @endcan

                    @can ('view menu docentes')
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ request()->routeIs('teacher.list.show')? 'active' : '' }}" href="{{route('teacher.list.show')}}"><span class="material-icons">people</span> @lang('Teachers')</a>
                    </li>
                    @endcan

                    @can ('view menu estudiantes')
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ request()->routeIs('student.list.show')? 'active' : '' }}" href="{{route('student.list.show')}}"><span class="material-icons">school</span> @lang('Students')</a>
                    </li>
                    @endcan

                    @can ('view menu legajos')
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ request()->routeIs('student.legajo.show')? 'active' : '' }}" href="{{route('student.legajo.show')}}"><span class="material-icons">fact_check</span> @lang('Lejajos')</a>
                    </li>
                    @endcan                    

                    @can ('view menu miscursos')               
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ (request()->is('courses/teacher*') || request()->is('courses/assignments*'))? 'active' : '' }}" href="{{route('course.teacher.list.show', ['teacher_id' => Auth::user()->id])}}"><span class="material-icons">edit_calendar</span>  @lang('My Courses')</a>
                    </li>
                   @endcan

                    @can ('view menu miboletin')    
                    <li class="nav-item  w-100 ">
                        <a class="nav-link {{ request()->routeIs('student.boletin.show')? 'active' : '' }}" href="{{route('student.boletin.show', ['id' => Auth::user()->id])}}"><span class="material-icons">spellcheck</span> @lang('Report Card')</a>
                    </li>
                    @endcan

                    @can ('view menu miasistencia')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link {{ request()->routeIs('student.attendance.show')? 'active' : '' }}" href="{{route('student.attendance.show', ['id' => Auth::user()->id])}}"><span class="material-icons">fact_check</span>  @lang('My Attendance')</a>
                    @endcan
                    
                    @can ('view menu misasignaturas')    
                    <li class="nav-item w-100 ">
                        <a class="nav-link  {{ request()->routeIs('course.student.list.show')? 'active' : '' }}" href="{{route('course.student.list.show', ['student_id' => Auth::user()->id])}}"><span class="material-icons">folder_zip</span> @lang('My Courses')</a>
                    </li>
                    @endcan

                    @can ('view menu mishorarios')
                    <li class="nav-item  w-100 ">
                        @php
                            if (session()->has('browse_session_id')){
                                $class_info = \App\Models\Promotion::where('session_id', session('browse_session_id'))->where('student_id', Auth::user()->id)->first();
                            } else {
                                $latest_session = \App\Models\SchoolSession::latest()->where('school_id', Auth::user()->school_id)->first();
                                if($latest_session) {
                                    $class_info = \App\Models\Promotion::where('session_id', $latest_session->id)->where('student_id', Auth::user()->id)->first();
                                } else {
                                    $class_info = [];
                                }
                            }
                         @endphp

                        <a class="nav-link" href="{{route('section.routine.show', ['class_id'  => $class_info->class_id,'section_id'=> $class_info->section_id])}}"><span class="material-icons">update</span> @lang('My Routine')
                        </a>
                    </li>
                    @endcan

                    @can ('view menu examenes')
                        @can ('create exams')
                            <li class="nav-item w-100 ">
                                <a class="nav-link {{ request()->routeIs('exam.create.show')? 'active' : '' }}" href="{{route('exam.create.show')}}"><span class="material-icons">table_view</span>  @lang('Exams')</a>
                            </li>
                        @endcan
                    @endcan

                    @can ('view menu asistencia')
                        <li class="nav-item w-100"><a class="nav-link {{ request()->is('attendances*')? 'active' : '' }}" href="{{route('attendance.tomar.show')}}"><i class="bi bi-person-video2 me-2"></i>  @lang('Tomar Asistencia')</a></li>
                        </li>
                    @endcan

                    @can ('view menu avisos')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link {{ request()->is('notice*')? 'active' : '' }}" href="{{route('notice.create')}}"><span class="material-icons">campaign</span> @lang('Notices')</a>
                    </li>
                    @endcan

                    @can ('view menu horarios')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link w-100 {{ request()->routeIs('routine.list.show')? 'active' : '' }}" href="{{route('routine.list.show')}}"><span class="material-icons">pending_actions</span> @lang('Routines')</a>
                    </li>
                    @endcan                     

                    @can ('view menu eventos')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link {{ request()->is('calendar-event*')? 'active' : '' }}" href="{{route('events.show')}}"><span class="material-icons">question_answer</span> @lang('Events')</a>
                    </li>
                    @endcan

                    @can ('view menu planes')
                    <li class="nav-item w-100 ">
                        <a class="nav-link {{ request()->is('syllabus*')? 'active' : '' }}" href="{{route('class.syllabus.create')}}"><span class="material-icons">receipt</span> @lang('Syllabus')</a>
                    </li>
                    @endcan

                    @can ('view menu configuracion')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link {{ request()->is('academics*')? 'active' : '' }}" href="{{url('academics/settings')}}"><span class="material-icons">construction</span> @lang('Settings')</a>
                    </li>
                    @endcan

                    @can ('view menu promocion')
                    <li class="nav-item  w-100 ">
                        <a class="nav-link {{ request()->is('promotions*')? 'active' : '' }}" href="{{url('promotions/index')}}"><span class="material-icons">safety_divider</span> @lang('Promotion')</a>
                    </li>
                    @endcan
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bi bi-door-open me-2"></i> {{ __('Logout') }}
                    </a>
                </ul>
            </div>
        </div>