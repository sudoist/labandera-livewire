<div {{ $attributes }}>
	<h3 class="text-lg leading-6 font-medium text-gray-900">
		Stats
	</h3>
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="px-4 py-5 sm:p-6">
				<dl>
					<dt class="text-sm leading-5 font-medium text-gray-500 truncate">
						Queued
					</dt>
					<dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
						{{ $queued }}
					</dd>
				</dl>
			</div>
		</div>
		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="px-4 py-5 sm:p-6">
				<dl>
					<dt class="text-sm leading-5 font-medium text-gray-500 truncate">
						Washing in progress
					</dt>
					<dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
						{{ $washing }}
					</dd>
				</dl>
			</div>
		</div>
		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="px-4 py-5 sm:p-6">
				<dl>
					<dt class="text-sm leading-5 font-medium text-gray-500 truncate">
						Ready for Pickup/Delivery
					</dt>
					<dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
						{{ $ready }}
					</dd>
				</dl>
			</div>
		</div>
		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="px-4 py-5 sm:p-6">
				<dl>
					<dt class="text-sm leading-5 font-medium text-gray-500 truncate">
						Order Complete
					</dt>
					<dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
						{{ $complete }}
					</dd>
				</dl>
			</div>
		</div>
	</div>
</div>
