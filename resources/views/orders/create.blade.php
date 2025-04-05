<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($order) ? __('Edit Order') : __('Add Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:p-8">
                @if(isset($order))
                <form method="POST" action="{{ route('orders.update', ['order' => $order->id]) }}" id="place_order">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $order->id }}">
                @else
                    <form method="POST" action="{{ route('orders.store') }}" id="place_order">
                @endif
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    
                    @csrf
                        <x-input-label for="customer_name" :value="__('Customer Name')"/>
                        <x-text-input id="customer_name" class="block mt-1 w-full" name="customer_name" :value="$order->customer_name ?? old('customer_name')" required />
                        <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                    
                    <div class="mt-4" id="product">
                        @php
                            $key = 1;
                        @endphp
                        
                        @if (isset($order) && $order->products)
                            @foreach ($order->products as $product)
                                <div class="product">
                                    <h2><strong>Product Detail</strong></h2>

                                    <x-input-label for="name" :value="__('Product Name')" class="mt-2" />
                        
                                    <x-text-input id="name" class="block mt-1 w-full" name="products[{{$key}}][name]" required value="{{ $product->name ?? null }}"/>

                                    {{-- amount --}}
                                    <x-input-label for="amount" :value="__('Product Amount')" class="mt-2 qua-amt-cal" />
                        
                                    <x-text-input class="block mt-1 w-full qua-amt-cal"
                                    type="number" name="products[{{$key}}][amount]" id="amount_{{ $key }}" required data-key="{{ $key }}"  value="{{ $product->amount ?? null }}"/>

                                    {{-- Quantity --}}
                                    <x-input-label for="quantity" :value="__('Product Quantity')" class="mt-2" />
                        
                                    <x-text-input class="block mt-1 w-full qua-amt-cal" data-key="{{ $key }}" 
                                    type="number" name="products[{{$key}}][quantity]" id="quantity_{{ $key }}" required  value="{{ $product->quantity ?? null }}"/>

                                    {{-- Total --}}
                                    <x-input-label for="total" :value="__('Product Total')" class="mt-2" data-key="{{ $key }}"/>
                        
                                    <x-text-input id="total" class="block mt-1 w-full"
                                    type="number" name="products[{{$key}}][total]" id="total_{{ $key }}" readonly="readonly"  value="{{ $product->total ?? null }}"/>

                                    <a class="btn btn-danger btn-sm btn-add-more-rm my-2"><i class="fa fa-trash"></i></a>

                                    <hr class="my-4">

                                </div>
                            @endforeach
                        @else
                            <h2><strong>Product Detail </strong></h2>
                            <x-input-label for="name" :value="__('Product Name')" class="mt-2" />
                
                            <x-text-input id="name" class="block mt-1 w-full" name="products[{{$key}}][name]" required />

                            {{-- amount --}}
                            <x-input-label for="amount" :value="__('Product Amount')" class="mt-2 qua-amt-cal" />
                
                            <x-text-input class="block mt-1 w-full qua-amt-cal"
                            type="number" name="products[{{$key}}][amount]" id="amount_{{ $key }}" required data-key="{{ $key }}"/>

                            {{-- Quantity --}}
                            <x-input-label for="quantity" :value="__('Product Quantity')" class="mt-2" />
                
                            <x-text-input class="block mt-1 w-full qua-amt-cal" data-key="{{ $key }}" 
                            type="number" name="products[{{$key}}][quantity]" id="quantity_{{ $key }}" required />

                            {{-- Total --}}
                            <x-input-label for="total" :value="__('Product Total')" class="mt-2" data-key="{{ $key }}"/>
                
                            <x-text-input id="total" class="block mt-1 w-full"
                            type="number" name="products[{{$key}}][total]" id="total_{{ $key }}" readonly="readonly" />
                        
                        @endif
                    </div>

                    <x-secondary-button class="btn-add-more mt-3">
                        <a>
                            {{ __('Add More Product') }}
                        </a>
                    </x-secondary-button>
                    
                    <div class="flex items-center justify-end mt-4">
                        <p class="mt-2 color-green" id="message"></p>

                        <x-primary-button class="ms-3">
                            {{ isset($order) ?  __('Update Order') : __('Place Order') }}
                        </x-primary-button>

                        <x-secondary-button class="ms-3">
                            <a href="{{ route('orders.index') }}">
                                {{ __('Back to Orders') }}
                            </a>
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add more product fields
            i = "{{$key}}";
        
            $(".btn-add-more").click(function(e){
                e.preventDefault();
                i++;
                $("#product").append('<div class="product"><hr class="my-4"><h2><strong>Product Detail</strong></h2><label class="block font-medium text-sm text-gray-700 mt-2" for="name">Product Name</label><input class="qua-amt-cal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="name_'+i+'" name="products['+i+'][name]" required="required"><label class="block font-medium text-sm text-gray-700 mt-2" for="amount">Product Amount</label><input class="qua-amt-cal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="amount_'+i+'" data-key="'+i+'" type="number" name="products['+i+'][amount]"  required="required"><label class="block font-medium text-sm text-gray-700 mt-2" for="quantity">Product Quantity</label><input class="qua-amt-cal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="quantity_'+i+'" data-key="'+i+'" type="number" name="products['+i+'][quantity]" required="required"><label class="block font-medium text-sm text-gray-700 mt-2" for="total">Product Total</label><input class="qua-amt-cal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="total_'+i+'" data-key="'+i+'" type="number" name="products['+i+'][total]" readonly="readonly"><a class="btn btn-danger btn-sm btn-add-more-rm my-2"><i class="fa fa-trash"></i></a></div>');
            });
            $(document).on('click', '.btn-add-more-rm', function(){  
                $(this).parents("div").closest('.product').remove();
            }); 

            // Calculate total amount
            $(document).on('change keyup', ".qua-amt-cal", function() {
                console.log("calla");
                $key = $(this).data('key');
                
                let quantity = $('#quantity_'+$key).val();
                let amount = $('#amount_'+$key).val();

                if(quantity > 0 && amount > 0){
                    let total = quantity * amount;
                    $('#total_'+$key).val(total);
                } else {
                    $('#total_'+$key).val(0);
                }
            });
        });

        $('#place_order').submit(function(e) {
            e.preventDefault();
            
            var url = $(this).attr("action");
            let formData = new FormData(this);
                console.log("calla");
            $.ajax({
                type:'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#message').html(response.message);
                    $('#message').css('color', 'green');
                    $('#place_order').trigger("reset");
                    $('#place_order').find(".print-error-msg").css('display','none');
                    
                    setTimeout(function() {
                        window.location.href = "{{ route('orders.index') }}";
                    }, 2000);
                },
                error: function(response){
                    $('#place_order').find(".print-error-msg").find("ul").html('');
                    $('#place_order').find(".print-error-msg").css('display','block');
                    $.each( response.responseJSON.errors, function( key, value ) {
                        $('#place_order').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });
                }
            });
        
        });
    </script>
</x-app-layout>