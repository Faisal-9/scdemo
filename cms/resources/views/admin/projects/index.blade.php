@extends('admin.layout')
@section('title', 'Projects')
@section('content')
<h1>Projects</h1>
<p><a href="{{ route('admin.projects.create') }}">Add project</a></p>
<form><input name="search" value="{{ request('search') }}" placeholder="Search projects"><button>Search</button></form>
<table><thead><tr><th>Project</th><th>Workflow</th><th>Updated</th><th></th></tr></thead><tbody>
@forelse($projects as $project)<tr><td>{{ $project->title }}</td><td>{{ $project->status }}</td><td>{{ $project->updated_at->format('Y-m-d') }}</td><td><a href="{{ route('admin.projects.edit', $project) }}">Edit</a></td></tr>
@empty<tr><td colspan="4">No projects found.</td></tr>@endforelse
</tbody></table>
{{ $projects->links() }}
@endsection
