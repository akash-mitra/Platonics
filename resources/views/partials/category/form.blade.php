{{ csrf_field() }}
<input type="hidden" name="id" value="{{ old('id') ?? $category->id }}">
<div class="form-group">
	<label for="inputTitle">Category Name</label>
	<input 
		type="text" 
		class="form-control custom-control" 
		id="inputTitle" 
		placeholder="News or Sports..."
		name="head" 
		value="{{ old('head') ?? $category->name }}"
		data-validation='required'
	/>
</div>

<div class="form-group">
	<label for="inputUrl">URL Slug</label>
	<input 
		type="text" 
		class="form-control custom-control" 
		id="inputUrl" 
		name="url" 
		data-validation='required' 
		value="{{ old('url') ?? $category->slug }}" 
		readonly 
	/>
	</div>

<div class="form-group">
	<label for="inputCat">Select a category</label>
	<select 
		class="form-control custom-control" 
		id="inputCat" 
		name="cat">
	</select>
</div>

<div class="form-group">
	<label for="inputText">Category Description</label>
	<textarea 
		class="form-control custom-control" 
		id="inputText" 
		placeholder="Assorted collection of articles on day's breaking news..."
		name="body"
		style="height: 150px" 
		data-validation='required'>{!! old('body') ?? $category->description !!}</textarea>
</div>