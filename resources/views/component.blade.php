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
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="quantity"
                                               name="quantity"
                                               value="{{old('quantity') ?: $component->quantity}}" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="quantityPlus">+</button>
                                            <button class="btn btn-default" type="button" id="quantityMinus">-</button>
                                        </span>
                                    </div>


                                    <script>
                                        $(document).ready(function() {
                                            function updateQuantity(count) {
                                                $.get('/component/{{$component->id}}/quantity/' + count, function(data) {
                                                    $('#quantity').val(data);
                                                }).fail(function () {
                                                    alert("@lang('app.error')");
                                                });
                                            }

                                            $('#quantityPlus').click(function() {
                                                updateQuantity(1);
                                            });

                                            $('#quantityMinus').click(function() {
                                                updateQuantity(-1);
                                            });
                                        });
                                    </script>
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

                            <script>
                                function createSelect(newId, data) {
                                    var group = $('<div class="input-group"></div>');
                                    var select = $('<select class="form-control" name="'+newId+'" id="'+newId+'"></select>');
                                    group.append(select);

                                    select.append('<option value="0">@lang("app.please_select")</option>');
                                    $.each(data, function() {
                                        var hasChildren = this.children > 0 ? 1 : 0;
                                        select.append('<option data-haschildren="'+hasChildren+'" value="' + this.id + '">' + this.name + '</option>');
                                    });

                                    var btnGroup = $('<span class="input-group-btn"></span>');
                                    var btn = $('<button class="btn btn-default" type="button" id="auto-' + newId + '">Auto</button>');
                                    btnGroup.append(btn);
                                    group.append(btnGroup);

                                    return group;
                                }

                                function assignStorageSelect(selector, $root, sub) {
                                    $(selector).change(function() {
                                        var option = $(this).find(":selected");

                                        if(option.attr('data-haschildren') == '1') {
                                            // make full path, for pulling sub children
                                            $.get('/component/storage/children/' + option.val(), function (data) {
                                                var newId = "storage-" + $root + "-" + (sub+1);

                                                // Create new select
                                                var group = createSelect(newId, data);

                                                var currentNew = $('#'+newId);
                                                if(currentNew.length > 0) {
                                                    currentNew.parent().remove();

                                                    var i = sub+2;
                                                    while(true) {
                                                        currentNew = $('#storage-' + $root + '-' + i);

                                                        if(currentNew.length > 0) {
                                                            currentNew.parent().remove();
                                                        } else {
                                                            break;
                                                        }
                                                    }
                                                }

                                                group.insertAfter($(selector).parent());
                                                assignStorageSelect("#"+newId, $root, sub+1);

                                                // set input
                                                $('#storage-' + $root).val(sub+2);
                                            });
                                        } else {
                                            if(option.val() == 0) return;
                                            // no children no pull needed, add new storage selection
                                            var root = parseInt($('#storage').val());
                                            $('#storage').val(root+1);

                                            $.get('/component/storage/children/0', function(data) {
                                                var select = createSelect('storage-' + root + '-' + 0, data);

                                                var div = $('#storageSelect');
                                                div.append(select);
                                                div.append($('<input type="hidden" name="storage-'+root+'" id="storage-'+root+'" value="1" />'));
                                                div.append($('<hr />'));

                                                assignStorageSelect('#storage-' + root + '-' + 0, root, 0);
                                            });
                                        }
                                    });
                                }
                            </script>

                            <div class="form-group">
                                <label for="storage-1" class="col-md-4 control-label">
                                    @lang('app.component_storage')
                                </label>
                                <div class="col-md-6" id="storageSelect">
                                    @foreach($component->storageStructure() as $storagePath)
                                        @foreach($storagePath as $storage)
                                            <div class="input-group">
                                                <select class="form-control" id="storage-{{$loop->parent->index}}-{{$loop->index}}" name="storage-{{$loop->parent->index}}-{{$loop->index}}">
                                                    <option value="0">@lang('app.please_select')</option>
                                                    @foreach($storage->sameLevelStorage() as $s)
                                                        <option
                                                                {{$s->id == $storage->id ? "selected" : ""}}
                                                                value="{{$s->id}}"
                                                                data-haschildren="{{sizeof($s->children) > 0}}">
                                                            {{$s->name}}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" id="auto-storage-{{$loop->parent->index}}-{{$loop->index}}">Auto</button>
                                                </span>
                                            </div>

                                            <script>
                                                assignStorageSelect('#storage-{{$loop->parent->index}}-{{$loop->index}}', {{$loop->parent->index}}, {{$loop->index}});
                                            </script>
                                        @endforeach

                                        <input type="hidden" id="storage-{{$loop->index}}" value="{{sizeof($storagePath)}}" name="storage-{{$loop->index}}" value="{{sizeof($storagePath)}}" />
                                        <hr/>
                                    @endforeach
                                </div>
                            </div>

                            <input type="hidden" id="storage" name="storage" value="{{sizeof($component->storageStructure())}}" />

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