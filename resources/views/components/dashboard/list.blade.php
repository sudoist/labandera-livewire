<div {{ $attributes }} class="bg-white shadow overflow-hidden sm:rounded-md">
	<h3 class="text-lg leading-6 font-medium text-gray-900">
		Orders
	</h3>
	<ul>
		@foreach(json_decode($orders) as $order)
			<li>
				<a href="#" class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
					<div class="px-4 py-4 sm:px-6">
						<div class="flex items-center justify-between">
							<div class="text-sm leading-5 font-medium text-indigo-600 truncate">
								{{ $order->name }}
							</div>
							<div class="ml-2 flex-shrink-0 flex">
								<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->isPaid == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}}">
									{{ $order->isPaid }}
								</span>
							</div>
						</div>
						<div class="mt-2 sm:flex sm:justify-between">
							<div class="sm:flex">
								<div class="mr-6 flex items-center text-sm leading-5 text-gray-500">
									<svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
										 xmlns="http://www.w3.org/2000/svg">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
									</svg>
									₱ {{ $order->price }}
								</div>
								<div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
									<svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
										 xmlns="http://www.w3.org/2000/svg">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
									</svg>
									{{ $order->status }}
								</div>
							</div>
							<div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">

								<!-- Heroicon name: calendar -->
								<svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
								</svg>
								<span>
									Date Received <time datetime="2020-01-07">{{ $order->dateReceived }}</time>
                				</span>
							</div>
						</div>
						@isset($order->dateReturned)
							<div class="mt-2 sm:flex sm:justify-between">
								<div class="sm:flex">

								</div>
								<div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">

									<!-- Heroicon name: calendar -->
									<svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
										<path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
									</svg>
									<span>
										Date Returned <time datetime="2020-01-07">{{ $order->dateReturned }}</time>
									</span>
								</div>
							</div>
						@endif
					</div>
				</a>
			</li>
		@endforeach
	</ul>
</div>
