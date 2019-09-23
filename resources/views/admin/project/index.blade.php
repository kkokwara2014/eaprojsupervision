@extends('admin.layout.app')


@section('content')
{{-- @include('admin.layout.statboard') --}}
@include('admin.layout.statboardcontainer')
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
            <span class="fa fa-plus"></span> Add Project
        </button>

    <a href="{{route('chapter.index')}}" class="btn btn-success"><span class="fa fa-eye"></span> Chapters</a>
    <a href="{{route('assignproject.index')}}" class="btn btn-success"><span class="fa fa-exchange"></span> Assign Projects</a>
        <br><br>

        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Case Study</th>
                                    <th>Project Year</th>
                                    <th>Class Level</th>

                                    <th>Edit</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                <tr>
                                    <td>{{$project->title}}</td>
                                    <td>{{$project->casestudy}}</td>
                                    <td>{{$project->projyear}}</td>
                                    <td>{{$project->classlevel->levelname}}</td>
                                    <td><a href="{{ route('project.edit',$project->id) }}"><span
                                                class="fa fa-edit fa-2x text-primary"></span></a></td>
                                    <td>
                                        <form id="delete-form-{{$project->id}}" style="display: none"
                                            action="{{ route('project.destroy',$project->id) }}" method="post">
                                            {{ csrf_field() }}
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a href="" onclick="
                                                            if (confirm('Are you sure you want to delete this?')) {
                                                                event.preventDefault();
                                                            document.getElementById('delete-form-{{$project->id}}').submit();
                                                            } else {
                                                                event.preventDefault();
                                                            }
                                                        "><span class="fa fa-trash fa-2x text-danger"></span>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Case Study</th>
                                    <th>Project Year</th>
                                    <th>Class Level</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>


        {{-- Data input modal area --}}
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">

                <form action="{{ route('project.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add Project</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Project Title <b style="color: red;">*</b></label>
                                <input type="text" class="form-control" name="title" placeholder="Project Title"
                                    autofocus>
                            </div>
                            <div class="form-group">
                                <label for="">Case Study</label>
                                <input type="text" class="form-control" name="casestudy"
                                    placeholder="Project Case Study">
                            </div>
                            <div class="form-group">
                                <label for="">Year</label>
                                <input type="text" class="form-control" id="datepicker" name="projyear"
                                    placeholder="Project year">
                            </div>
                            <div class="form-group">
                                <label for="">Level</label>
                                <select name="classlevel_id" class="form-control">
                                    <option selected="disabled">Select Level</option>
                                    @foreach ($classlevels as $classlevel)
                                    <option value="{{$classlevel->id}}">{{$classlevel->levelname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->

                </form>
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /.modal -->



    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    {{-- <section class="col-lg-5 connectedSortable"> --}}


    {{-- </section> --}}
    <!-- right col -->
</div>
<!-- /.row (main row) -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection