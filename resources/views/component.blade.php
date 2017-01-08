@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('app.edit_component', ['component' => $component->description])
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

                        <form class="form-horizontal" method="post">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="item_number" class="col-md-4 control-label">@lang('app.component_item_number')</label>
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control"
                                           id="item_number"
                                           name="item_number"
                                           value="{{old('item_number') ?: $component->item_number}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-6">
                                    BARCODE
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">@lang('app.component_description')</label>
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control"
                                           id="description"
                                           name="description"
                                           value="{{old('description') ?: $component->description}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="col-md-4 control-label">@lang('app.component_quantity')</label>
                                <div class="col-md-6">
                                    <input type="number"
                                           class="form-control"
                                           id="quantity"
                                           name="quantity"
                                           value="{{old('quantity') ?: $component->quantity}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="min_quantity" class="col-md-4 control-label">@lang('app.component_min_quantity')</label>
                                <div class="col-md-6">
                                    <input type="number"
                                           class="form-control"
                                           id="min_quantity"
                                           name="min_quantity"
                                           value="{{old('min_quantity') ?: $component->min_quantity}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-md-4 control-label">@lang('app.component_price')</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">&euro;</span>
                                        <input type="text"
                                               class="form-control"
                                               id="price"
                                               name="price"
                                               value="{{old('price') ?: $component->price}}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="storage" class="col-md-4 control-label">@lang('app.component_storage')</label>
                                <div class="col-md-6">
                                    <select class="form-control selectpicker" name="storage[]" id="storage" data-live-search="true" multiple>
                                        @foreach($all as $s)
                                            @if(sizeof($s->children) == 0)
                                                <option {{$component->isInStorage($s->id) ? 'selected="selected"' : ''}} value="{{$s->id}}">
                                                    {{$s->path()}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <input type="hidden" name="id" value="{{$component->id}}">
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