@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('navigation.storage')</div>

                    <div class="panel-body">

                        <a href="{{ action('StorageController@newStorage')}}" class="pull-right">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a><br /><br />

                        <table class="table table-condensed tree">
                            @foreach($storage as $s)
                                <tr class="treegrid-{{$s->id}} {{$s->parent_storage != null ? 'treegrid-parent-' . $s->parent_storage : ''}}">
                                    <td class="col-md-2">{{$s->short_code}}</td>
                                    <td class="col-md-8">{{$s->name}}</td>
                                    <td class="col-md-2 text-right">
                                        <a href="{{ action('StorageController@newStorageParent', ['parent' => $s->id]) }}">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                        <a href="{{ action('StorageController@edit', ['id' => $s->id]) }}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <a href="{{ action('StorageController@delete', ['id' => $s->id]) }}"
                                           onclick="event.preventDefault(); remove({{$s->id}}, {{$s->tree_id}})">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <script>
                            var deleteUrl = "{{action('StorageController@delete', ['id' => 'INSERT_ID'])}}";

                            function remove(id, treeId) {
                                // Search for children
                                var childrenCount = $('.treegrid-parent-' + treeId).length;
                                var removeText = "@lang('app.remove_storage')";

                                if(childrenCount > 0) {
                                    removeText = "@lang('app.remove_storage_with_children')";
                                }

                                // Ask for confirmation
                                var confirmation = confirm(removeText);
                                if(confirmation) {
                                    var url = deleteUrl.replace('INSERT_ID', id);
                                    $.ajax(url).done(function(msg) {
                                        var res = JSON.parse(msg);

                                        if(res.error) {
                                            alert(res.message);
                                        } else {
                                            alert("@lang('app.remove_storage_success')");
                                            $('.treegrid-' + treeId).remove();
                                        }
                                    }).fail(function() {
                                        alert("A problem occurred.");
                                    })
                                }
                            }

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
