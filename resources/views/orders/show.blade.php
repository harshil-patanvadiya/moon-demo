<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Details</h3>
                    <p><strong>Order No:</strong> #{{ $order->id }}</p>
                    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Total Amount:</strong> {{ $order->total }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                    
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Products</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Product Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Quantity') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Price') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Total') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->total }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <x-secondary-button class="ms-3">
                        <a href="{{ route('orders.index') }}">
                            {{ __('Back to Orders') }}
                        </a>
                    </x-secondary-button>
            </div>
        </div>
    </div>
</x-app-layout>