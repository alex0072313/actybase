<div class="form-group row">
    <label class="col-form-label col-md-3">{{ $label }}</label>
    <div class="col-md-9">
        <input type="text" name="{{ $name }}" value="{{ old('name') ? old('name') : (isset($value) ? $value : '') }}" class="form-control">
    </div>
</div>