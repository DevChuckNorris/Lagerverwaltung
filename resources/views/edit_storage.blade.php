@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('app.edit_storage', ['name' => $storage->name])</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ action('StorageController@edit', $storage->id) }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">@lang('app.storage_name')</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" value="{{$storage->name}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short" class="col-md-4 control-label">@lang('app.storage_short')</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="short" name="short" value="{{$storage->short_code}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="parent" class="col-md-4 control-label">@lang('app.storage_parent')</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="parent" id="parent" data-live-search="true">
                                        @foreach($all as $s)
                                            @if(sizeof($s->children) == 0)
                                                <option value="{{$s->id}}">{{$s->path()}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('app.save')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
