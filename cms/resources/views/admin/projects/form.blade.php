@extends('admin.layout')
@section('title', $project->exists ? 'Edit project' : 'New project')
@section('content')
<h1>{{ $project->exists ? 'Edit project' : 'New project' }}</h1>
<form method="post" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
@csrf @if($project->exists) @method('PUT') @endif
@foreach(['title' => 'Title', 'client' => 'Client', 'location' => 'Location', 'category' => 'Category', 'project_status' => 'Project status', 'completion_year' => 'Completion year'] as $field => $label)
<label>{{ $label }}<input name="{{ $field }}" value="{{ old($field, $project->$field) }}"></label><br>@error($field)<small>{{ $message }}</small>@enderror
@endforeach
<label>Sector<select name="sector_id"><option value="">None</option>@foreach($sectors as $sector)<option value="{{ $sector->id }}" @selected(old('sector_id', $project->sector_id) == $sector->id)>{{ $sector->title }}</option>@endforeach</select></label><br>
<label>Description<textarea name="description">{{ old('description', $project->description) }}</textarea></label><br>
<label>Scope (one item per line)<textarea name="scope_text">{{ old('scope_text', implode("\n", $project->scope ?? [])) }}</textarea></label><br>
<label>Thumbnail <input type="file" name="thumbnail" accept="image/*"></label><br>
<label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))> Featured</label>
<label><input type="checkbox" name="is_home_featured" value="1" @checked(old('is_home_featured', $project->is_home_featured))> Show on homepage</label><br>
<button name="workflow_action" value="draft">Save draft</button><button name="workflow_action" value="review">Send for review</button>
@if(auth()->user()->hasAnyRole('super_admin', 'admin'))<button name="workflow_action" value="publish">Publish</button>@endif
</form>
@if($project->exists && auth()->user()->hasAnyRole('super_admin', 'admin'))<form method="post" action="{{ route('admin.projects.destroy', $project) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete this project?')">Delete</button></form>@endif
@endsection
