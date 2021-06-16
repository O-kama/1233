<div class="from-group">
    <input name="title" type="text" class="form-control"  required value="{{ old('title') ?? $post->title ?? ''}}">
</div>
<!-- /.from-group -->
<div class="from-group">
    <textarea name="desc"  rows="10" class="form-control" required >{{ old('desc') ?? $post->desc ?? ''}}</textarea>
</div>
<!-- /.from-group -->
<div class="from-group">
    <input name="img" type="file" >
</div>
<!-- /.from-group -->
