<div class="form-group row">
    <label class="col-form-label col-md-3">{{ $label }}</label>
    <div class="col-md-9">
        <textarea name="{{ $name }}" class="textarea form-control wysihtml5" placeholder="Укажите {{ $label }}" >{{ old('name') ? old('name') : (isset($value) ? $value : '') }}</textarea>
    </div>
</div>