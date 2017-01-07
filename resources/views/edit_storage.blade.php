@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if($storage->id == 0)
                            @lang('app.new_storage')
                        @else
                            @lang('app.edit_storage', ['name' => $storage->name])
                        @endif
                    </div>

                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ action('StorageController@edit', $storage->id) }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">@lang('app.storage_name')</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" value="{{old('name') ?: $storage->name}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short" class="col-md-4 control-label">@lang('app.storage_short')</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="short" name="short" value="{{old('short') ?: $storage->short_code}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="parent" class="col-md-4 control-label">@lang('app.storage_parent')</label>
                                <div class="col-md-6">
                                    <select class="form-control selectpicker" name="parent" id="parent" data-live-search="true">
                                        <option value="0">@lang('app.main_storage')</option>
                                        @foreach($all as $s)
                                            @if($s->id != $storage->id)
                                                <option
                                                        {{(old('parent') ?: $storage->parent_storage) == $s->id ? 'selected="selected" ' : ''}}
                                                        value="{{$s->id}}">
                                                    {{$s->path()}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <input type="hidden" name="id" value="{{$storage->id}}">
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
