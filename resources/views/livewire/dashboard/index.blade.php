<div>
	<x-dashboard.stats
		class="p-12"
		:queued="$queued"
		:washing="$washing"
		:ready="$ready"
		:complete="$complete"
	/>
	<x-dashboard.list class="p-12" :orders="json_encode($orders)"/>
</div>
