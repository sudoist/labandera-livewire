@extends('layouts.app')

@section('content')
	<div class="bg-gray-100">
		@auth
		<x-nav />
		<div class="max-w-7xl mx-auto">
			<livewire:dashboard.index/>
		</div>
		<x-footer/>
		@else
			<script>
                window.location.href = "{{ route('home')}}";
			</script>
		@endauth
	</div>
@endsection
