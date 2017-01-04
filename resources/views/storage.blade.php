@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('navigation.storage')</div>

                    <div class="panel-body">
                        <table class="table tree">
                            @foreach($storage as $s)
                                <tr class="treegrid-{{$s->tree_id}} {{$s->tree_parent != null ? 'treegrid-parent-' . $s->tree_parent : ''}}">
                                    <td>{{$s->short_code}}</td>
                                    <td>{{$s->name}}</td>
                                    <td><a href="{{ action('StorageController@edit', ['id' => $s->id]) }}">@lang('app.edit')</a></td>
                                </tr>
                            @endforeach
                        </table>

                        <script>
                            $(document).ready(function() {
                                $('.tree').treegrid({
                                    'initialState': 'collapsed'
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
