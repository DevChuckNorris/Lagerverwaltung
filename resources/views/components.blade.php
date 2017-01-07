@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('app.components')
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <a class="btn btn-primary">@lang('app.new')</a>
                            </div>
                        </div>

                        <br/>

                        <table id="components" class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('app.component_item_number')</th>
                                    <th>@lang('app.component_description')</th>
                                    <th>@lang('app.component_storage')</th>
                                    <th>@lang('app.component_quantity')</th>
                                    <th>@lang('app.component_min_quantity')</th>
                                    <th>@lang('app.component_price')</th>
                                    <th>@lang('app.updated_at')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($components as $component)
                                    <tr>
                                        <td>{{$component->item_number}}</td>
                                        <td>
                                            <a href="{{ action('ComponentController@view', ['id' => $component->id]) }}">{{$component->description}}</a>
                                        </td>
                                        <td>
                                            @foreach($component->storage as $cs)
                                                <span>{{$cs->ref_storage->path()}}</span>
                                                @if(!$loop->last)
                                                    <br/>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$component->quantity}}</td>
                                        <td>{{$component->min_quantity}}</td>
                                        <td>{{$component->price}} &euro;</td>
                                        <td>{{$component->updated_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function() {
                                $('#components').DataTable({
                                    'order': [[1, 'asc']]
                                });
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection