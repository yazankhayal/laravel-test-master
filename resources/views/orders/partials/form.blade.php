{{ csrf_field() }}
<input value="{{$companies_id}}" type="hidden" name="companies_id">
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Name</label>
    <div class="col-md-12">
        <input id="name" type="text" class="form-control" name="name"
               value="{{ old('name', $order->name) }}">
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
    <label for="price" class="col-md-4 control-label">Price</label>
    <div class="col-md-12">
        <input id="price" type="text" class="form-control" name="price"
               value="{{ old('price', $order->price) }}">
        @if ($errors->has('price'))
            <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
    <label for="text" class="col-md-4 control-label">Test</label>
    <div class="col-md-12">
        <textarea id="text" rows="4" class="form-control" name="text">{{ old('text', $order->text) }}</textarea>
        @if ($errors->has('text'))
            <span class="help-block">
                <strong>{{ $errors->first('text') }}</strong>
            </span>
        @endif
    </div>
</div>
