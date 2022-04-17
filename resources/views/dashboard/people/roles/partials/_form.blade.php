@php
    $name = isset($form_data) ? $form_data->name : old('name');
    $display_name = isset($form_data) ? $form_data->display_name : old('display_name');
    $description = isset($form_data) ? $form_data->description : old('description');
@endphp
<div class="row">

    <div class="col-md-6">
        <div class="form-group" id="name_edit_div">
            <label>@lang('site.name')</label>
            <input type="text" name="name" placeholder="@lang('site.name')" class="form-control"
                   value="{{ $name }}">
            <span id="name_edit_error" class="help-block"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group" id="display_name_edit_div">
            <label>@lang('site.display_name')</label>
            <input type="text" name="display_name" placeholder="@lang('site.display_name')" class="form-control"
                   value="{{ $display_name }}">
        </div>
        <span id="display_name_edit_error" class="help-block"></span>
    </div>


    <div class="col-md-12">
        <div class="form-group" id="description_edit_div">
            <label>@lang('site.description')</label>
            <input type="text" name="description" placeholder="@lang('site.description')" class="form-control"
                   value="{{ $description }}">
        </div>
        <span id="description_edit_error" class="help-block"></span>
    </div>


    @php
        $models = __('models');
        $maps = ['create', 'read', 'update', 'delete'];
    @endphp

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row">
            <div class="col-md-8">
                <h2>@lang('site.privileges')</h2>
            </div>
            <div class="col-md-4">
                <label class="pull-right text-danger form-group ichack-input">
                    <input class="minimal" value="0" id="permissions_all" type="checkbox" name="permissions_all"
                    > {{ __('site.select_all') }}
                </label>
            </div>
        </div>

        <div class="row">
            @foreach ($models as $index=>$model)

                <div class="col-md-4 container_check">
                    <h4>
                        <label class="form-group ichack-input">
                            <input class="minimal container_check" type="checkbox" name="permissions_{{ $model }}"
                                   data-model="{{ $model }}" value=""/>
                            <span> {{ __('site.'.$model) }} </span>
                        </label>
                    </h4>
                    <div id="{{ $model }}" style="margin: 10px;">
                        @foreach ($maps as $map)
                            <br>
                            <label class="form-group ichack-input">
                                <input  class="minimal container_check chk_{{ $model }}" type="checkbox" name="permissions[]"
                                        @if(!empty($form_data)) {{ $form_data->hasPermission($model.'-'.$map) ? 'checked' : '' }} @endif value="{{ $model.'-'.$map }}"/>
                                <span>@lang('site.' . $map)</span>
                            </label>
                        @endforeach

                    </div>
                    <hr>
                </div>
            @endforeach

        </div>
    </div>

</div>

