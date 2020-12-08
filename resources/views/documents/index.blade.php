@extends('layouts.app')
@section('title',ucfirst(config('settings.document_label_plural'))." List")
@section('css')
    <style type="text/css">
        .bg-folder-shaper {
            width: 100%;
            height: 115px;
            border-radius: 0px 15px 15px 15px !Important;
        }

        .folder-shape-top {
            width: 57px;
            height: 17px;
            border-radius: 20px 37px 0px 0px;
            position: absolute;
            top: -16px;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .widget-user-2 .widget-user-username, .widget-user-2 .widget-user-desc {
            margin-left: 10px;
            font-weight: 400;
            font-size: 17px;
        }

        .widget-user-username {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-t-20 {
            margin-top: 20px;
        }

        .dropdown-menu {
            min-width: 100%;
        }

        .doc-box.box {
            box-shadow: 0 0px 0px rgba(0, 0, 0, 0.0) !important;
        }

        .bg-folder-shaper:hover {
            background-color: yellow;
        }

        .select2-container {
            width: 100% !important;
        }

        #filterForm.in, filterForm.collapsing {
            display: block !important;
        }
        #Div2 {
            display: none;
        }
    </style>
@stop
@section('scripts')
    <script>
        function switchVisible() {
                    if (document.getElementById('Div1')) {

                        if (document.getElementById('Div1').style.display == 'none') {
                            document.getElementById('Div1').style.display = 'block';
                            document.getElementById('Div2').style.display = 'none';
                        }
                        else {
                            document.getElementById('Div1').style.display = 'none';
                            document.getElementById('Div2').style.display = 'block';
                        }
                    }
        }
    </script>
@stop


@section('content')

    <section class="content-header">
        <h1 class="pull-left">

        {{ __('content.document') }}
        </h1>
        <h1 class="pull-right">
            @can('create',\App\Document::class)
                <a href="{{route('documents.create')}}"
                   class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    {{ __('content.add_new') }}
                </a>
            @endcan
        </h1>

        <h1 class="pull-right">
            <div class="h-sb-Ic h-R-d a-c-d" role="button" style="user-select: none;" tabindex="0" data-tooltip="Vista de cuadrícula" aria-label="Vista de cuadrícula" data-tooltip-align="b,c" data-tooltip-delay="500" data-tooltip-unhoverable="true">
                    <svg class="a-s-fa-Ha-pa" width="24px" height="24px" viewBox="0 0 24 24" fill="#000000">
                        <path d="M2,5v14h20V5H2z M14,7v4h-4V7H14z M4,7h4v4H4V7z M16,11V7h4v4H16z M4,17v-4h4v4H4z M10,17v-4h4v4H10z M20,17 h-4v-4h4V17z" onclick="switchVisible();"></path>
                    </svg>
            </div>
        </h1>

    </section>



    
    <div class="content" style="margin-top: 22px;">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-header">
                <div class="form-group hidden visible-xs">
                    <button type="button" class="btn btn-default btn-block" data-toggle="collapse"
                            data-target="#filterForm"><i class="fa fa-filter"></i> Filter
                    </button>
                </div>
                {!! Form::model(request()->all(), ['method'=>'get','class'=>'form-inline visible hidden-xs','id'=>'filterForm']) !!}
                <div class="form-group">
                    <label for="search" class="sr-only">Search</label>
                    {!! Form::text('search',null,['class'=>'form-control input-sm','placeholder'=>'Search...']) !!}
                </div>
                <div class="form-group">
                    <label for="tags" class="sr-only">{{config('settings.tags_label_singular')}}:</label>
                    <select class="form-control select2 input-sm" name="tags[]" id="tags"
                            data-placeholder="Choose {{config('settings.tags_label_singular')}}" multiple>
                        @foreach($tags as $tag)
                            @canany(['read documents','read documents in tag '.$tag->id])
                                <option
                                    value="{{$tag->id}}" {{in_array($tag->id,request('tags',[]))?'selected':''}}>{{$tag->name}}</option>
                            @endcanany
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status" class="sr-only">{{config('settings.tags_label_singular')}}:</label>
                    {!! Form::select('status',['0'=>"ALL",config('constants.STATUS.PENDING')=>config('constants.STATUS.PENDING'),config('constants.STATUS.APPROVED')=>config('constants.STATUS.APPROVED'),config('constants.STATUS.REJECT')=>config('constants.STATUS.REJECT')],null,['class'=>'form-control input-sm']) !!}
                </div>
                <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-filter"></i> Filter</button>
                {!! Form::close() !!}
            </div>
            <div class="box-body" id="Div1" >
                <div class="row">
                    @foreach ($documents as $document)
                        @cannot('view',$document)
                            @continue
                        @endcannot
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 m-t-20" style="cursor:pointer;">
                            <div class="doc-box box box-widget widget-user-2">
                                <div class="widget-user-header bg-gray bg-folder-shaper no-padding">
                                    <div class="folder-shape-top bg-gray"></div>
                                    <div class="box-header">
                                        <a href="{{route('documents.show',$document->id)}}" style="color: black;">
                                            <h3 class="box-title"><i class="fa fa-folder text-yellow"></i></h3>
                                        </a>

                                        <div class="box-tools pull-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"
                                                        style="    background: transparent;border: none;">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                                    <li><a href="{{route('documents.show',$document->id)}}">Show</a>
                                                    </li>
                                                    @can('edit',$document)
                                                        <li><a href="{{route('documents.edit',$document->id)}}">Edit</a>
                                                        </li>
                                                    @endcan
                                                    @can('delete',$document)
                                                        <li>
                                                            {!! Form::open(['route' => ['documents.destroy', $document->id], 'method' => 'delete']) !!}
                                                            {!! Form::button('Delete', [
                                                                        'type' => 'submit',
                                                                        'class' => 'btn btn-link',
                                                                        'onclick' => "return conformDel(this,event)"
                                                                    ]) !!}
                                                            {!! Form::close() !!}
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.widget-user-image -->
                                    <a href="{{route('documents.show',$document->id)}}" style="color: black;">
                                    <span style="max-lines: 1; white-space: nowrap;margin-left: 3px;">
                                    @foreach ($document->tags as $tag)
                                            <small class="label"
                                                   style="background-color: {{$tag->color}};font-size: 0.93rem;">{{$tag->name}}</small>
                                        @endforeach
                                    </span>
                                        <h5 class="widget-user-username" title="{{$document->name}}"
                                            data-toggle="tooltip">{{$document->name}}</h5>
                                        <?php
                                            $count = DB::table('files')->where('document_id', $document->id)->get()->count();
                                        ?>
                                        <h5 class="widget-user-username" title="{{$document->name}}"
                                        data-toggle="tooltip">{{$count}}</h5>



                                        <h5 class="widget-user-desc" style="font-size: 12px"><span data-toggle="tooltip"
                                                                                                   title="{{formatDateTime($document->updated_at)}}">{{formatDate($document->updated_at)}}</span>
                                            </h5>
                                    </a>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="box-body" id="Div2" >
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('id') }}
                                    </th>
                                    <th>
                                        {{ trans('Nombre') }}
                                    </th>
                                    <th>
                                        {{ trans('Descripción') }}
                                    </th>
                                    <th>
                                        {{ trans('Estado') }}
                                    </th>
                                    <th>
                                        {{ trans('Fecha Creación') }}
                                    </th>

                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @if($trash )
                                    @foreach($documents as $key => $document)
                                        <tr data-entry-id="{{ $document->id }}">
                                            @if($document->deleted_at !== NULL )

                                            <td>

                                            </td>
                                            <td>
                                                {{ $document->id ?? '' }}   
                                            </td>
                                            <td>
                                                {{ $document->name ?? '' }}
                                            </td>
                                            <td>
                                            <p>{!! $document->description !!}</p>
                                            </td>
                                            <td>
                                                @if ($document->status==config('constants.STATUS.PENDING'))
                                                    <span class="label label-warning">{{$document->status}}</span>
                                                @elseif($document->status==config('constants.STATUS.APPROVED'))
                                                    <span class="label label-success">{{$document->status}}</span>
                                                @else
                                                    <span class="label label-danger">{{$document->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $document->created_at ?? '' }}
                                            </td>

                                            <td>
                                                    <a class="btn btn-xs btn-primary" href="{{route('documents.show',$document->id)}}">View</a>

                                                @can('edit',$document)
                                                    <a class="btn btn-xs btn-info" href="{{route('documents.edit',$document->id)}}">Edit</a>
                                                    
                                                @endcan
                                            </td>
                                            @endif

                                        </tr>
                                    @endforeach

                                    @else
                                    @foreach($documents as $key => $document)
                                        <tr data-entry-id="{{ $document->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $document->id ?? '' }}   
                                            </td>
                                            <td>
                                                {{ $document->name ?? '' }}
                                            </td>
                                            <td>
                                            <p>{!! $document->description !!}</p>
                                            </td>
                                            <td>
                                                @if ($document->status==config('constants.STATUS.PENDING'))
                                                    <span class="label label-warning">{{$document->status}}</span>
                                                @elseif($document->status==config('constants.STATUS.APPROVED'))
                                                    <span class="label label-success">{{$document->status}}</span>
                                                @else
                                                    <span class="label label-danger">{{$document->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $document->created_at ?? '' }}
                                            </td>

                                            <td>
                                                    <a class="btn btn-xs btn-primary" href="{{route('documents.show',$document->id)}}">View</a>

                                                @can('edit',$document)
                                                    <a class="btn btn-xs btn-info" href="{{route('documents.edit',$document->id)}}">Edit</a>
                                                    
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach


                                    @endif
                            </tbody>
                        </table>
                    </div>


                </div>
                
            </div>



            <div class="box-footer">
                {!! $documents->appends(request()->all())->render() !!}
            </div>
        </div>
    </div>
@endsection
